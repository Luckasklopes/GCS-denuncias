<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DenunciaController extends Controller
{
    public function index()
    {
        $denuncias = Denuncia::latest()->paginate(10);
        return view('denuncias.index', compact('denuncias'));

        // Se for admin, mostra tudo
        if (Auth::user()->is_admin) {
        $denuncias = Denuncia::latest()->paginate(10);
        } 
        // Se não for admin, mostra apenas as do usuário
        else {
        $denuncias = Denuncia::where('id_usuario', Auth::id())->latest()->paginate(10);
        }

        return view('index', compact('denuncias'));
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

        // Se não for anônima, atribui o usuário logado
        $validated['id_usuario'] = $validated['anonimo'] ? null : Auth::id();

        Denuncia::create($validated);

        return redirect()->route('denuncias.index')->with('success', 'Denúncia enviada com sucesso!');
    }

    public function show($id)
    {
    $denuncia = Denuncia::findOrFail($id);

    // Se for anônima e o usuário não for admin, bloqueia
    if ($denuncia->anonimo && !Auth::user()->is_admin) {
        abort(403, 'Você não tem permissão para ver esta denúncia anônima.');
    }

    // Se não for admin e a denúncia não pertence ao usuário, bloqueia
    if (!$denuncia->anonimo && $denuncia->id_usuario !== Auth::id() && !Auth::user()->is_admin) {
        abort(403, 'Você não tem permissão para ver esta denúncia.');
    }

    return view('denuncias.show', compact('denuncia'));

}
    public function userDashboard()
    {
        $userId = Auth::id();

        //Pegando apenas as denúncias do usuário logado
        $denuncias = Denuncia::where('id_usuario', $userId)->latest()->get();

        //resumo rápido
        $total = $denuncias->count();
        $aceitas = $denuncias->where('status', 'aceito')->count(); 
        $rejeitadas = $denuncias->where('status', 'rejeitado')->count();
        $enviadas = $denuncias->where('status', 'enviado')->count();

        //ultimas 5 denúncias
        $ultimas = $denuncias->take(5);

        return view('denuncias.user-dashboard', compact('denuncias', 'total', 'aceitas', 'rejeitadas', 'enviadas', 'ultimas'));
    }

    public function adminDashboard()
    {
        //Denuncias por categoria
        $denunciasPorCategoria = Denuncia::select('classificacao', DB::raw('count(*) as total'))
            ->groupBy('classificacao')
            ->pluck('total', 'classificacao');

     //Usuarios cadastrados por dia
        $usuariosPorDia = User::select(DB::raw('DATE(created_at) as dia'), DB::raw('count(*) as total'))
            ->groupBy('dia')
            ->orderBy('dia', 'desc')
            ->pluck('total', 'dia');

        // Denuncias invalidas (exemplo: status = rejeitado)
        $denunciasInvalidas = Denuncia::where('status', 'rejeitado')->get();

        return view('denuncias.admin-dashboard', compact('denunciasPorCategoria', 'usuariosPorDia', 'denunciasInvalidas'));

            
    }



}

