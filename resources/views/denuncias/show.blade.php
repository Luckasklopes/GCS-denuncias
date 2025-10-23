<<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Detalhes da Denúncia #{{ str_pad($denuncia->id_denuncia, 6, '0', STR_PAD_LEFT) }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-gray-900 text-white p-6 rounded-lg shadow-lg">

            <!-- Botão Voltar -->
            <div class="mb-4">
                <a href="{{ route('user.dashboard') }}" 
                   class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700 transition">
                   ← Voltar para Minhas Denúncias
                </a>
            </div>

            <!-- Card com Detalhes -->
            <div class="bg-gray-800 p-4 rounded-lg space-y-3">
                <p><strong>Descrição:</strong> {{ $denuncia->descricao }}</p>
                <p><strong>Classificação:</strong> {{ ucfirst(str_replace('_',' ', $denuncia->classificacao)) }}</p>
                <p><strong>Status:</strong> 
                    <span class="
                        @if($denuncia->status == 'aceito') bg-green-500
                        @elseif($denuncia->status == 'rejeitado') bg-red-500
                        @elseif($denuncia->status == 'enviado') bg-yellow-500
                        @else bg-gray-400
                        @endif
                        text-black px-2 py-1 rounded text-sm font-bold
                    ">
                        {{ strtoupper($denuncia->status) }}
                    </span>
                </p>
                <p><strong>Bairro:</strong> {{ $denuncia->bairro ?? 'N/A' }}</p>
                <p><strong>Rua:</strong> {{ $denuncia->rua ?? 'N/A' }}</p>
                <p><strong>CEP:</strong> {{ $denuncia->cep ?? 'N/A' }}</p>
                <p><strong>Anônimo:</strong> {{ $denuncia->anonimo ? 'Sim' : 'Não' }}</p>
                <p><strong>Data Criação:</strong> {{ $denuncia->data_criacao }}</p>

                @if($denuncia->foto)
                    <div>
                        <strong>Foto:</strong>
                        <img src="{{ asset('storage/'.$denuncia->foto) }}" alt="Foto denúncia" class="max-w-xs mt-2 rounded shadow-lg">
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
