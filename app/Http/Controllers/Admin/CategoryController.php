<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Список всех категорий
     */
    public function index()
    {
        $categories = Category::withCount('plants')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Форма создания категории
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Сохранение новой категории
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Название категории обязательно',
            'name.unique' => 'Категория с таким названием уже существует',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Категория добавлена');
    }

    /**
     * Просмотр категории
     */
    public function show($id)
    {
        $category = Category::with('plants')->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Форма редактирования
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Обновление категории
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ], [
            'name.required' => 'Название категории обязательно',
            'name.unique' => 'Категория с таким названием уже существует',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена');
    }

    /**
     * Удаление категории
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Нельзя удалить категорию, если в ней есть растения
        if ($category->plants()->count() > 0) {
            return redirect()->back()->with('error', 'Нельзя удалить категорию, в которой есть растения');
        }
        
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена');
    }
}