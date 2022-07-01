<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Str;

class NotesController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Note::class);
        return view('site.notes.index', [
            'notes' => Note::all(),
            '_pageTitle' => 'View Notes'
        ]);
    }

    public function create()
    {
        $this->authorize('create', Note::class);
        return view('site.notes.create', [
            'moderators' => User::role(['Administrator', 'Quadrumvirate', 'Moderator'])->get(),
            '_pageTitle' => 'View Notes'
        ]);
    }

    public function store(StoreNoteRequest $request)
    {
        $note = Note::create(array_merge(['id' => Str::uuid()], $request->validated()));
        session()->flash('top-positive-msg', 'Note created!');
        return redirect()->route('site.notes.show', $note);
    }

    public function show(Note $note)
    {
        $this->authorize('view', $note);
        return view('site.notes.show', [
            'note' => $note,
            '_pageTitle' => "Note re: $note->reddit_username"
        ]);
    }

    public function edit(Note $note)
    {
        $this->authorize('update', $note);
        return view('site.notes.edit', [
            'moderators' => User::role(['Administrator', 'Quadrumvirate', 'Moderator'])->get(),
            'note' => $note,
            '_pageTitle' => "Edit Note re: $note->reddit_username"
        ]);
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());
        $note->save();
        session()->flash('top-positive-msg', 'Note updated!');
        return redirect()->route('site.notes.show', $note);
    }

    public function delete(Note $note)
    {
        $this->authorize('delete', $note);
        if ($note->trashed()) {
            abort(403, 'Already trashed');
        }
        $note->delete();
        session()->flash('top-info-msg', 'Note deleted.');
        return redirect()->route('site.notes.index');
    }
}
