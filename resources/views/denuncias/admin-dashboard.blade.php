<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Dashboard do Administrador
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto bg-gray-900 text-white p-6 rounded-lg shadow-lg">

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="mb-4 bg-green-600 text-white px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 bg-red-600 text-white px-4 py-2 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Gráfico Denúncias por Categoria -->
            <h3 class="text-lg font-bold mb-4">Denúncias por Categoria</h3>
            <canvas id="chartCategorias" class="mb-6"></canvas>

            <!-- Gráfico Usuários por Dia -->
            <h3 class="text-lg font-bold mb-4">Usuários cadastrados por dia</h3>
            <canvas id="chartUsuarios" class="mb-10"></canvas>

            <!-- Denúncias Inválidas -->
            <h3 class="text-lg font-bold mb-4">Denúncias inválidas (rejeitadas)</h3>
            <ul class="space-y-2 mb-10">
                @forelse($denunciasInvalidas as $denuncia)
                    <li class="bg-red-600/80 p-3 rounded">
                        <strong>#{{ $denuncia->id_denuncia }}</strong> —
                        {{ \Illuminate\Support\Str::limit($denuncia->descricao, 120) }}
                        @if($denuncia->motivo_rejeicao)
                            <div class="text-sm text-white/90 mt-1"><b>Motivo:</b> {{ $denuncia->motivo_rejeicao }}</div>
                        @endif
                    </li>
                @empty
                    <p class="text-gray-400">Nenhuma denúncia inválida encontrada.</p>
                @endforelse
            </ul>

            <!-- ==================== GERENCIAR DENÚNCIAS ==================== -->
            <h3 id="gerenciar-denuncias" class="text-lg font-bold mb-4">Gerenciar Denúncias</h3>

            {{-- Filtros --}}
            <form method="GET" class="mb-4 grid sm:grid-cols-4 gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por ID/descrição/bairro/rua/CEP"
                       class="bg-gray-800 text-white rounded px-3 py-2 border border-gray-700 placeholder-gray-400">

                <select name="status" class="bg-gray-800 text-white rounded px-3 py-2 border border-gray-700">
                    <option value="">Status (todos)</option>
                    @foreach(['enviado'=>'Enviado','aceito'=>'Aceito','rejeitado'=>'Rejeitado'] as $k=>$v)
                        <option value="{{ $k }}" @selected(request('status')===$k)>{{ $v }}</option>
                    @endforeach
                </select>

                <select name="classificacao" class="bg-gray-800 text-white rounded px-3 py-2 border border-gray-700">
                    <option value="">Categoria (todas)</option>
                    @foreach(['ambiental'=>'Ambiental','civil_criminal'=>'Civil/Criminal','perturbacao_paz'=>'Perturbação da paz'] as $k=>$v)
                        <option value="{{ $k }}" @selected(request('classificacao')===$k)>{{ $v }}</option>
                    @endforeach
                </select>

                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                    Filtrar
                </button>
            </form>

            <div class="overflow-x-auto rounded-lg ring-1 ring-gray-700">
                <table class="min-w-full text-sm bg-gray-800 text-gray-100">
                    <thead class="bg-gray-900 text-gray-100 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Descrição</th>
                            <th class="px-4 py-3 text-left">Categoria</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($denuncias as $denuncia)
                            <tr class="odd:bg-gray-800 even:bg-gray-750 hover:bg-gray-700 transition">
                                <td class="px-4 py-3 font-semibold">#{{ $denuncia->id_denuncia }}</td>
                                <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit($denuncia->descricao, 80) }}</td>
                                <td class="px-4 py-3">{{ ucfirst(str_replace('_',' ', $denuncia->classificacao)) }}</td>
                                <td class="px-4 py-3">
                                    @if($denuncia->status === 'enviado')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-yellow-400 text-gray-900 font-bold">Enviado</span>
                                    @elseif($denuncia->status === 'aceito')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-green-500 text-black font-bold">Aceito</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-red-500 text-white font-bold">Rejeitado</span>
                                    @endif
                                    @if($denuncia->motivo_rejeicao)
                                        <div class="text-xs text-gray-300 mt-1">Motivo: {{ $denuncia->motivo_rejeicao }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($denuncia->status === 'enviado')
                                        <form method="POST" action="{{ route('admin.denuncias.aceitar', $denuncia->id_denuncia) }}" class="inline">
                                            @csrf
                                            <button class="bg-green-600 hover:bg-green-700 px-3 py-1 rounded font-semibold">Aceitar</button>
                                        </form>

                                        <button class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded font-semibold ml-2"
                                                onclick="abrirModal({{ $denuncia->id_denuncia }})">
                                            Rejeitar
                                        </button>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                                    Nenhuma denúncia encontrada com os filtros atuais.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="mt-4">
                {{ $denuncias->links() }}
            </div>
        </div>
    </div>

    <!-- Modal de rejeição -->
    <div id="modalRejeicao" class="hidden fixed inset-0 bg-black/70 z-50">
      <div class="h-full w-full flex items-center justify-center p-4">
        <div class="bg-gray-900 text-gray-100 p-6 rounded-xl shadow-xl max-w-md w-full ring-1 ring-gray-700">
            <h3 class="text-lg font-bold mb-3">Motivo da Rejeição</h3>
            <form id="formRejeicao" method="POST">
                @csrf
                <textarea name="motivo_rejeicao" required class="w-full text-black rounded p-2" rows="3"
                          placeholder="Descreva o motivo..."></textarea>
                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" class="bg-gray-600 hover:bg-gray-700 px-3 py-1 rounded" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded font-semibold">Rejeitar</button>
                </div>
            </form>
        </div>
      </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Denúncias por categoria
        const categorias = @json($denunciasPorCategoria->keys());
        const valoresCategorias = @json($denunciasPorCategoria->values());

        new Chart(document.getElementById('chartCategorias'), {
            type: 'pie',
            data: {
                labels: categorias,
                datasets: [{
                    data: valoresCategorias,
                    backgroundColor: ['#4ade80','#60a5fa','#facc15','#f87171']
                }]
            }
        });

        // Usuários por dia
        const dias = @json($usuariosPorDia->keys());
        const valoresUsuarios = @json($usuariosPorDia->values());

        new Chart(document.getElementById('chartUsuarios'), {
            type: 'line',
            data: {
                labels: dias,
                datasets: [{
                    label: 'Usuários cadastrados',
                    data: valoresUsuarios,
                    borderColor: '#60a5fa',
                    fill: true,
                    tension: 0.3
                }]
            }
        });

        // Modal de rejeição
        function abrirModal(id) {
            const modal = document.getElementById('modalRejeicao');
            const form = document.getElementById('formRejeicao');
            form.action = `/denuncias/${id}/rejeitar`;
            modal.classList.remove('hidden');
        }
        function fecharModal() {
            document.getElementById('modalRejeicao').classList.add('hidden');
        }
    </script>
</x-app-layout>
