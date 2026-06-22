<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
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
        ], [
            'category_id.required' => 'Выберите категорию',
            'name.required' => 'Название обязательно',
            'image.max' => 'Изображение не должно превышать 2 МБ',
        ]);

        // Загрузка изображения
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('plants', 'public');
        }

        Plant::create($validated);

        return redirect()->route('admin.plants.index')->with('success', 'Растение успешно добавлено');
    }

    /**
     * Просмотр растения
     */
    public function show($id)
    {
        $plant = Plant::with(['category', 'characteristics'])->findOrFail($id);
        return view('admin.plants.show', compact('plant'));
    }

    /**
     * Форма редактирования
     */
    public function edit($id)
    {
        $plant = Plant::findOrFail($id);
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
        ]);

        // Загрузка нового изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($plant->image) {
                Storage::disk('public')->delete($plant->image);
            }
            $validated['image'] = $request->file('image')->store('plants', 'public');
        }

        $plant->update($validated);

        return redirect()->route('admin.plants.index')->with('success', 'Растение обновлено');
    }

    /**
     * Удаление растения
     */
    public function destroy($id)
    {
        $plant = Plant::findOrFail($id);
        
        // Удаляем изображение
        if ($plant->image) {
            Storage::disk('public')->delete($plant->image);
        }
        
        $plant->delete();
        return redirect()->route('admin.plants.index')->with('success', 'Растение удалено');
    }
}