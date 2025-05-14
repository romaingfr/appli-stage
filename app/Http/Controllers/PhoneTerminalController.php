<?php

namespace App\Http\Controllers;

use App\Models\PhoneTerminal;
use Illuminate\Http\Request;

class PhoneTerminalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index', 'search']);
    }

    public function index()
    {
        $terminals = PhoneTerminal::orderBy('brand')->orderBy('terminal_type')->get();
        return view('settings.terminals.index', compact('terminals'));
    }

    public function create()
    {
        return view('settings.terminals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:100',
            'terminal_type' => 'required|string|max:100',
            'serial_number' => 'required|string|max:100|unique:phone_terminals',
            'notes' => 'nullable|string',
        ]);

        PhoneTerminal::create($validated);
        return redirect()->route('terminals.index')->with('success', 'Terminal ajouté avec succès');
    }

    public function edit(PhoneTerminal $terminal)
    {
        return view('settings.terminals.edit', compact('terminal'));
    }

    public function update(Request $request, PhoneTerminal $terminal)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:100',
            'terminal_type' => 'required|string|max:100',
            'serial_number' => 'required|string|max:100|unique:phone_terminals,serial_number,'.$terminal->id,
            'notes' => 'nullable|string',
        ]);

        $terminal->update($validated);
        return redirect()->route('terminals.index')->with('success', 'Terminal mis à jour avec succès');
    }

    public function destroy(PhoneTerminal $terminal)
    {
        $terminal->delete();
        return redirect()->route('terminals.index')->with('success', 'Terminal supprimé avec succès');
    }

    public function search(Request $request)
    {
        $query = PhoneTerminal::query();

        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->has('terminal_type')) {
            $query->where('terminal_type', $request->terminal_type);
        }

        if ($request->has('serial_number')) {
            $query->where('serial_number', $request->serial_number);
        }

        $terminals = $query->get();
        return response()->json($terminals);
    }

    public function brands()
    {
        $brands = PhoneTerminal::select('brand')->distinct()->pluck('brand');
        return response()->json($brands);
    }

    public function types(Request $request)
    {
        $query = PhoneTerminal::select('terminal_type')->distinct();

        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        $types = $query->pluck('terminal_type');
        return response()->json($types);
    }
}
