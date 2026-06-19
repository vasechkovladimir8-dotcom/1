<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Category;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index(Request $request)
    {
        $query = Plant::with(['category', 'characteristics']);

        // Поиск по названию
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Фильтрация по категории
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $plants = $query->paginate(12);
        $categories = Category::all();

        return view('plants.index', compact('plants', 'categories'));
    }

    public function show($id)
    {
        $plant = Plant::with(['category', 'characteristics'])->findOrFail($id);
        
        return view('plants.show', compact('plant'));
    }
}