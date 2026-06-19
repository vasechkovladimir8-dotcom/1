<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Plant;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // Список избранных растений
    public function index()
    {
        $favorites = auth()->user()
            ->favorites()
            ->with('plant.category')
            ->latest()
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    // Добавить/удалить из избранного (toggle)
    public function toggle($plantId)
    {
        $plant = Plant::findOrFail($plantId);
        $user = auth()->user();

        $existing = Favorite::where('user_id', $user->id)
            ->where('plant_id', $plant->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Растение удалено из избранного';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'plant_id' => $plant->id,
            ]);
            $message = 'Растение добавлено в избранное';
        }

        return redirect()->back()->with('success', $message);
    }
}