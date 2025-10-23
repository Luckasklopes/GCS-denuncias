<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Nova Denúncia') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-gray-900 text-white p-6 rounded-lg shadow-lg">

            <!-- Menu -->
            <div class="flex justify-between mb-4">
                <a href="{{ route('user.dashboard') }}" class="bg-blue-600 px-4 py-2 rounded">Minhas denúncias</a>
                <a href="{{ route('denuncias.create') }}" class="bg-green-600 px-4 py-2 rounded">Nova denúncia</a>
                <a href="{{ route('profile.edit') }}" class="bg-gray-600 px-4 py-2 rounded">Meu perfil</a>
            </div>

            <!-- Formulário -->
            <form action="{{ route('denuncias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">Descrição</label>
                    <textarea name="descricao" class="w-full p-2 rounded text-black" rows="3" placeholder="Descreva a denúncia..." required>{{ old('descricao') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Classificação</label>
                    <select name="classificacao" class="w-full p-2 rounded text-black" required>
                        <option value="">Selecione...</option>
                        <option value="ambiental">Ambiental</option>
                        <option value="civil_criminal">Civil / Criminal</option>
                        <option value="perturbacao_paz">Perturbação da Paz</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Bairro</label>
                    <input type="text" name="bairro" class="w-full p-2 rounded text-black" placeholder="Digite o bairro">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Rua</label>
                    <input type="text" name="rua" class="w-full p-2 rounded text-black" placeholder="Digite a rua">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">CEP</label>
                    <input type="text" name="cep" class="w-full p-2 rounded text-black" placeholder="Digite o CEP">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Foto (opcional)</label>
                    <input type="file" name="foto" class="w-full p-2 rounded bg-white text-black">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="anonimo" id="anonimo" class="mr-2">
                    <label for="anonimo">Enviar anonimamente</label>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('user.dashboard') }}" class="bg-gray-600 px-4 py-2 rounded">Cancelar</a>
                    <button type="submit" class="bg-green-600 px-4 py-2 rounded">Enviar Denúncia</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
