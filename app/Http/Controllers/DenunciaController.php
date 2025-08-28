<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use Illuminate\Http\Request;

class DenunciaController extends Controller
{
    public function index()
    {
        $denuncias = Denuncia::latest()->paginate(10);
        return view('denuncias.index', compact('denuncias'));
    }

    public function create()
    {
        return view('denuncias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => 'required|string',
            'classificacao' => 'required|in:ambiental,civil_criminal,perturbacao_paz',
            'bairro' => 'nullable|string',
            'rua' => 'nullable|string',
            'cep' => 'nullable|string',
            'anonimo' => 'nullable|boolean',
            'foto' => 'nullable|file|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('denuncias', 'public');
        }

        $validated['anonimo'] = $request->has('anonimo');

        Denuncia::create($validated);

        return redirect()->route('denuncias.index')->with('success', 'Denúncia enviada com sucesso!');
    }
}

