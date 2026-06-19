<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('plants')->get();
        $latestPlants = Plant::with('category')->latest()->take(6)->get();
        
        return view('home', compact('categories', 'latestPlants'));
    }
}