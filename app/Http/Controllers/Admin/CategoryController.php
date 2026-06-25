<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /* Список всех категорий */
    public function index()
    {
        $categories = Category::withCount('plants')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    /* Форма создания категории */
    public function create()
    {
        return view('admin.categories.create');
    }

    /* Сохранение новой категории */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Загрузка изображения
        if ($request->hasFile('image')) {
            // Сохраняем файл и получаем путь
            $imagePath = $request->file('image')->store('categories', 'public');
            // Добавляем путь в массив валидированных данных
            $validated['image'] = $imagePath;
        }

        // Создаём категорию с путём к изображению
        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория успешно добавлена');
    }

    /* Просмотр категории */
    public function show($id)
    {
        $category = Category::with('plants')->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    /* Форма редактирования категории */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /* Обновление категории */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Название категории обязательно',
            'name.unique' => 'Категория с таким названием уже существует',
            'image.max' => 'Изображение не должно превышать 2 МБ',
            'image.image' => 'Файл должен быть изображением',
            'image.mimes' => 'Допустимые форматы: JPG, PNG, GIF',
        ]);

        // Загрузка нового изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение, если оно есть
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория успешно обновлена');
    }

    /* Удаление категории */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Нельзя удалить категорию, если в ней есть растения
        if ($category->plants()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Нельзя удалить категорию, в которой есть растения');
        }
        
        // Удаляем изображение категории, если оно есть
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория успешно удалена');
    }
}