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

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
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