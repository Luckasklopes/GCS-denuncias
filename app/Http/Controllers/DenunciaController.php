<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DenunciaController extends Controller
{
    /** LISTAGEM PADRÃO (apenas se você ainda usa /denuncias) */
    public function index()
    {
        // Se for admin, vê tudo; senão, só as do usuário
        if (Auth::user()->is_admin) {
            $denuncias = Denuncia::latest()->paginate(10);
        } else {
            $denuncias = Denuncia::where('id_usuario', Auth::id())->latest()->paginate(10);
        }

        return view('denuncias.index', compact('denuncias'));
    }

    /** FORM DE CRIAÇÃO */
    public function create()
    {
        return view('denuncias.create');
    }

    /** SALVAR NOVA DENÚNCIA */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao'      => 'required|string',
            'classificacao'  => 'required|in:ambiental,civil_criminal,perturbacao_paz',
            'bairro'         => 'nullable|string',
            'rua'            => 'nullable|string',
            'cep'            => 'nullable|string',
            'anonimo'        => 'nullable|boolean',
            'foto'           => 'nullable|file|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('denuncias', 'public');
        }

        $validated['anonimo']    = $request->boolean('anonimo');
        $validated['id_usuario'] = $validated['anonimo'] ? null : Auth::id();

        Denuncia::create($validated);

        return redirect()->route('user.dashboard')->with('success', 'Denúncia enviada com sucesso!');
    }

    /** DETALHE DA DENÚNCIA (controles de acesso) */
    public function show($id)
    {
        $denuncia = Denuncia::findOrFail($id);

        // Se for anônima e não for admin, bloqueia
        if ($denuncia->anonimo && !Auth::user()->is_admin) {
            abort(403, 'Você não tem permissão para ver esta denúncia anônima.');
        }

        // Se não for admin e a denúncia não pertence ao usuário, bloqueia
        if (
            !$denuncia->anonimo &&
            $denuncia->id_usuario !== Auth::id() &&
            !Auth::user()->is_admin
        ) {
            abort(403, 'Você não tem permissão para ver esta denúncia.');
        }

        return view('denuncias.show', compact('denuncia'));
    }

    /** DASHBOARD DO USUÁRIO */
    public function userDashboard()
    {
        $userId    = Auth::id();
        $denuncias = Denuncia::where('id_usuario', $userId)->latest()->get();

        $total      = $denuncias->count();
        $aceitas    = $denuncias->where('status', 'aceito')->count();
        $rejeitadas = $denuncias->where('status', 'rejeitado')->count();
        $enviadas   = $denuncias->where('status', 'enviado')->count();
        $ultimas    = $denuncias->take(5);

        return view('denuncias.user-dashboard', compact(
            'denuncias', 'total', 'aceitas', 'rejeitadas', 'enviadas', 'ultimas'
        ));
    }

    /** DASHBOARD DO ADMIN (relatórios + gestão) */
    public function adminDashboard(Request $request)
    {
        // Relatórios
        $denunciasPorCategoria = Denuncia::select('classificacao', DB::raw('count(*) as total'))
            ->groupBy('classificacao')
            ->pluck('total', 'classificacao');

        $usuariosPorDia = User::select(DB::raw('DATE(created_at) as dia'), DB::raw('count(*) as total'))
            ->groupBy('dia')
            ->orderBy('dia', 'asc')
            ->pluck('total', 'dia');

        $denunciasInvalidas = Denuncia::where('status', 'rejeitado')
            ->latest()->take(20)->get();

        // Listagem com filtros
        $query = Denuncia::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('classificacao')) {
            $query->where('classificacao', $request->classificacao);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('descricao', 'LIKE', "%{$q}%")
                  ->orWhere('bairro', 'LIKE', "%{$q}%")
                  ->orWhere('rua', 'LIKE', "%{$q}%")
                  ->orWhere('cep', 'LIKE', "%{$q}%");
                if (is_numeric($q)) {
                    $w->orWhere('id_denuncia', intval($q));
                }
            });
        }

        $denuncias = $query->paginate(10)->withQueryString();

        return view('denuncias.admin-dashboard', compact(
            'denunciasPorCategoria', 'usuariosPorDia', 'denunciasInvalidas', 'denuncias'
        ));
    }

    /** ADMIN: ACEITAR DENÚNCIA */
    public function aceitar($id)
    {
        $denuncia = Denuncia::findOrFail($id);
        $denuncia->status = 'aceito';
        $denuncia->motivo_rejeicao = null; // limpa se existir
        $denuncia->save();

        return redirect()->route('admin.dashboard')->with('success', 'Denúncia aceita com sucesso!');
    }

    /** ADMIN: REJEITAR DENÚNCIA (com motivo) */
    public function rejeitar(Request $request, $id)
    {
        $request->validate([
            'motivo_rejeicao' => 'required|string|max:1000',
        ]);

        $denuncia = Denuncia::findOrFail($id);
        $denuncia->status = 'rejeitado';
        $denuncia->motivo_rejeicao = $request->motivo_rejeicao;
        $denuncia->save();

        return back()->with('success', 'Denúncia rejeitada com sucesso!');
    }
}


