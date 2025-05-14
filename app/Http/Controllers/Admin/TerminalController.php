<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terminal;

class TerminalController extends Controller
{
    public function index()
    {
        $terminals = Terminal::all();

        // Au lieu de return $terminals;
        return view('admin.terminals.index', compact('terminals'));

    }

    public function create()
    {
        return view('admin.terminals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'serial_number' => 'nullable|string|max:255|unique:terminals',
            'status' => 'required|in:disponible,en_service,maintenance',
        ]);

        Terminal::create($validated);
        return redirect()->route('terminals.index')->with('success', 'Terminal ajouté avec succès');    }

    public function edit(Terminal $terminal)
    {
        return view('admin.terminals.edit', compact('terminal'));
    }

    public function update(Request $request, Terminal $terminal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'serial_number' => 'nullable|string|max:255|unique:terminals,serial_number,'.$terminal->id,
            'status' => 'required|in:disponible,en_service,maintenance',
        ]);

        $terminal->update($validated);
        return redirect()->route('terminals.index')->with('success', 'Terminal mis à jour avec succès');
    }

    public function destroy(Terminal $terminal)
    {
        $terminal->delete();
        return redirect()->route('terminals.index')->with('success', 'Terminal supprimé avec succès');    }
}
