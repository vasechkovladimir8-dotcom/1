<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'plantsCount' => Plant::count(),
            'categoriesCount' => Category::count(),
            'usersCount' => User::count(),
        ]);
    }
}