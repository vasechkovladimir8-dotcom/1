<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $notes = $user->notes()
            ->with('plant')
            ->latest()
            ->paginate(10);

        return view('notes.index', compact('notes'));
    }

    public function create($plantId)
    {
        $plant = Plant::findOrFail($plantId);
        return view('notes.create', compact('plant'));
    }

    public function store(Request $request, $plantId)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
        ], [
            'content.required' => 'Текст заметки обязателен',
            'content.max' => 'Заметка не должна превышать 2000 символов',
        ]);

        $plant = Plant::findOrFail($plantId);
        $user = Auth::user();

        Note::create([
            'user_id' => $user->id,
            'plant_id' => $plant->id,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')
            ->with('success', 'Заметка успешно добавлена');
    }

    public function edit($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $note = Note::where('user_id', $user->id)->findOrFail($id);
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $note = Note::where('user_id', $user->id)->findOrFail($id);

        $request->validate([
            'content' => 'required|string|max:2000',
        ], [
            'content.required' => 'Текст заметки обязателен',
            'content.max' => 'Заметка не должна превышать 2000 символов',
        ]);

        $note->update([
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')
            ->with('success', 'Заметка обновлена');
    }

    public function destroy($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $note = Note::where('user_id', $user->id)->findOrFail($id);
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Заметка удалена');
    }
}