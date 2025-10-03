<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Dashboard do Administrador
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto bg-gray-900 text-white p-6 rounded-lg shadow-lg">

            <!-- Gráfico Denúncias por Categoria -->
            <h3 class="text-lg font-bold mb-4">Denúncias por Categoria</h3>
            <canvas id="chartCategorias" class="mb-6"></canvas>

            <!-- Gráfico Usuários por Dia -->
            <h3 class="text-lg font-bold mb-4">Usuários cadastrados por dia</h3>
            <canvas id="chartUsuarios" class="mb-6"></canvas>

            <!-- Denúncias Inválidas -->
            <h3 class="text-lg font-bold mb-4">Denúncias inválidas (rejeitadas)</h3>
            <ul class="space-y-2">
                @forelse($denunciasInvalidas as $denuncia)
                    <li class="bg-red-600 p-3 rounded">
                        <strong>#{{ $denuncia->id_denuncia }}</strong> - {{ $denuncia->descricao }}
                    </li>
                @empty
                    <p class="text-gray-400">Nenhuma denúncia inválida encontrada.</p>
                @endforelse
            </ul>
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
    </script>
</x-app-layout>
