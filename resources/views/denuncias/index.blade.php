<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Minhas Denúncias
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-gray-900 text-white p-6 rounded-lg shadow-lg">

            <!-- Menu -->
            <div class="flex justify-between mb-4">
                <a href="{{ route('denuncias.index') }}" class="bg-blue-600 px-4 py-2 rounded">Minhas denúncias</a>
                <a href="{{ route('denuncias.create') }}" class="bg-green-600 px-4 py-2 rounded">Nova denúncia</a>
                <a href="{{ route('profile.edit') }}" class="bg-gray-600 px-4 py-2 rounded">Meu perfil</a>
            </div>

            <!-- Mensagem de sucesso -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-700 text-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mensagem de erro -->
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-700 text-red-100 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Lista de Denúncias -->
            <div class="space-y-2">
                @forelse($denuncias as $denuncia)
                    <a href="{{ route('denuncias.show', $denuncia->id_denuncia) }}" 
                       class="block px-4 py-2 rounded text-black font-bold transition hover:scale-105
                       @if($denuncia->status == 'aceito') bg-green-500
                       @elseif($denuncia->status == 'rejeitado') bg-red-500
                       @elseif($denuncia->status == 'enviado') bg-yellow-500
                       @else bg-gray-400
                       @endif">
                        <div class="flex justify-between">
                            <span>#{{ str_pad($denuncia->id_denuncia, 6, '0', STR_PAD_LEFT) }}</span>
                            <span>{{ strtoupper($denuncia->status) }}</span>
                        </div>
                    </a>
                @empty
                    <p class="text-center text-gray-300">Nenhuma denúncia encontrada.</p>
                @endforelse
            </div>

            <!-- Paginação -->
            <div class="mt-4">
                {{ $denuncias->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
