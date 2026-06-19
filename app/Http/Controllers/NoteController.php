<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Plant;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // Список всех заметок пользователя
    public function index()
    {
        $notes = auth()->user()
            ->notes()
            ->with('plant')
            ->latest()
            ->paginate(10);

        return view('notes.index', compact('notes'));
    }

    // Форма создания заметки к растению
    public function create($plantId)
    {
        $plant = Plant::findOrFail($plantId);
        return view('notes.create', compact('plant'));
    }

    // Сохранение заметки
    public function store(Request $request, $plantId)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
        ], [
            'content.required' => 'Текст заметки обязателен',
            'content.max' => 'Заметка не должна превышать 2000 символов',
        ]);

        $plant = Plant::findOrFail($plantId);

        Note::create([
            'user_id' => auth()->id(),
            'plant_id' => $plant->id,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')
            ->with('success', 'Заметка успешно добавлена');
    }

    // Форма редактирования заметки
    public function edit($id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);
        return view('notes.edit', compact('note'));
    }

    // Обновление заметки
    public function update(Request $request, $id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);

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

    // Удаление заметки
    public function destroy($id)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($id);
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Заметка удалена');
    }
}