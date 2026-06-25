<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\PlantImage;
use App\Models\Category;
use App\Models\Characteristic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlantController extends Controller
{
    /**
     * Список всех растений
     */
    public function index()
    {
        $plants = Plant::with('category')->latest()->paginate(15);
        return view('admin.plants.index', compact('plants'));
    }

    /**
     * Форма создания растения
     */
    public function create()
    {
        $categories = Category::all();
        $characteristics = Characteristic::all();
        return view('admin.plants.create', compact('categories', 'characteristics'));
    }

    /**
     * Сохранение нового растения
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'latin_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'category_id.required' => 'Выберите категорию',
            'name.required' => 'Название обязательно',
            'image.max' => 'Основное изображение не должно превышать 2 МБ',
            'images.*.max' => 'Дополнительное изображение не должно превышать 2 МБ',
            'image.image' => 'Файл должен быть изображением',
            'images.*.image' => 'Файл должен быть изображением',
        ]);

        // Загрузка основного изображения
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('plants', 'public');
        }

        // Создание растения
        $plant = Plant::create($validated);

        // Загрузка дополнительных изображений
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('plants', 'public');
                PlantImage::create([
                    'plant_id' => $plant->id,
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        // Привязка характеристик
        $this->syncCharacteristics($plant, $request);

        return redirect()->route('admin.plants.index')
            ->with('success', 'Растение успешно добавлено');
    }

    /**
     * Просмотр растения
     */
    public function show($id)
    {
        $plant = Plant::with(['category', 'characteristics', 'images'])->findOrFail($id);
        return view('admin.plants.show', compact('plant'));
    }

    /**
     * Форма редактирования
     */
    public function edit($id)
    {
        $plant = Plant::with('images')->findOrFail($id);
        $categories = Category::all();
        $characteristics = Characteristic::all();
        return view('admin.plants.edit', compact('plant', 'categories', 'characteristics'));
    }

    /**
     * Обновление растения
     */
    public function update(Request $request, $id)
    {
        $plant = Plant::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'latin_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'category_id.required' => 'Выберите категорию',
            'name.required' => 'Название обязательно',
            'image.max' => 'Основное изображение не должно превышать 2 МБ',
            'images.*.max' => 'Дополнительное изображение не должно превышать 2 МБ',
        ]);

        // Обновление основного изображения
        if ($request->hasFile('image')) {
            if ($plant->image) {
                Storage::disk('public')->delete($plant->image);
            }
            $validated['image'] = $request->file('image')->store('plants', 'public');
        }

        $plant->update($validated);

        // Удаление выбранных дополнительных изображений
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $plant->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        // Загрузка новых дополнительных изображений
        if ($request->hasFile('images')) {
            $sortOrder = $plant->images()->count();
            foreach ($request->file('images') as $image) {
                $path = $image->store('plants', 'public');
                PlantImage::create([
                    'plant_id' => $plant->id,
                    'path' => $path,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        // Обновление характеристик
        $this->syncCharacteristics($plant, $request);

        return redirect()->route('admin.plants.index')
            ->with('success', 'Растение успешно обновлено');
    }

    /**
     * Удаление растения
     */
    public function destroy($id)
    {
        $plant = Plant::findOrFail($id);
        
        // Удаление основного изображения
        if ($plant->image) {
            Storage::disk('public')->delete($plant->image);
        }
        
        // Удаление всех дополнительных изображений
        foreach ($plant->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        
        // Отвязка характеристик и удаление растения
        $plant->characteristics()->detach();
        $plant->favorites()->delete();
        $plant->notes()->delete();
        $plant->delete();
        
        return redirect()->route('admin.plants.index')
            ->with('success', 'Растение удалено');
    }

    /**
     * Привязка характеристик к растению
     */
    private function syncCharacteristics(Plant $plant, Request $request)
    {
        $characteristicIds = [];
        
        if ($request->has('characteristics')) {
            foreach ($request->input('characteristics') as $charId) {
                if ($charId) {
                    $characteristicIds[] = $charId;
                }
            }
        }
        
        $plant->characteristics()->sync($characteristicIds);
    }
}