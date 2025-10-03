<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Meu Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto bg-gray-900 text-white p-6 rounded-lg shadow-lg">

            <!-- Resumo -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-600 p-4 rounded-lg text-center">
                    <h3 class="text-lg font-bold">Total</h3>
                    <p class="text-2xl">{{ $total }}</p>
                </div>
                <div class="bg-green-600 p-4 rounded-lg text-center">
                    <h3 class="text-lg font-bold">Aceitas</h3>
                    <p class="text-2xl">{{ $aceitas }}</p>
                </div>
                <div class="bg-red-600 p-4 rounded-lg text-center">
                    <h3 class="text-lg font-bold">Rejeitadas</h3>
                    <p class="text-2xl">{{ $rejeitadas }}</p>
                </div>
                <div class="bg-yellow-500 text-black p-4 rounded-lg text-center sm:col-span-3">
                    <h3 class="text-lg font-bold">Enviadas</h3>
                    <p class="text-2xl">{{ $enviadas }}</p>
                </div>
            </div>

            <!-- Últimas Denúncias -->
            <h3 class="text-lg font-bold mb-4">Últimas denúncias</h3>
            <div class="space-y-3">
                @forelse($ultimas as $denuncia)
                    <a href="{{ route('denuncias.show', $denuncia->id_denuncia) }}"
                       class="block p-4 rounded-lg transition hover:scale-105
                       @if($denuncia->status == 'aceito') bg-green-600
                       @elseif($denuncia->status == 'rejeitado') bg-red-600
                       @elseif($denuncia->status == 'enviado') bg-yellow-500 text-black
                       @else bg-gray-600
                       @endif">
                        <div class="flex justify-between">
                            <span>#{{ str_pad($denuncia->id_denuncia, 6, '0', STR_PAD_LEFT) }}</span>
                            <span class="font-bold">{{ strtoupper($denuncia->status) }}</span>
                        </div>
                        <p class="mt-2 text-sm">{{ Str::limit($denuncia->descricao, 80) }}</p>
                    </a>
                @empty
                    <p class="text-gray-400">Você ainda não fez nenhuma denúncia.</p>
                @endforelse
            </div>

            <!-- Botão Nova Denúncia -->
            <div class="mt-6 text-center">
                <a href="{{ route('denuncias.create') }}" 
                   class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded">
                   + Nova Denúncia
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
