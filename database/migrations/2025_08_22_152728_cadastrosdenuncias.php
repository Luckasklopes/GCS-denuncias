<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 📌 Tabela Usuario
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('cpf')->unique();
            $table->string('nome');
            $table->string('numero'); // telefone
            $table->string('senha'); // hash da senha
            $table->boolean('termos_aceitos');
            $table->timestamps();
        });

        // 📌 Tabela Admin
        Schema::create('admins', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('matricula')->unique();
            $table->string('nome');
            $table->string('senha'); // hash da senha
            $table->timestamps();
        });

        // 📌 Tabela Denuncia
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id('id_denuncia');

            // FK Usuario (pode ser nulo se anônima)
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('set null');

            // FK Admin (pode ser nulo se não adotada)
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->foreign('id_admin')->references('id_admin')->on('admins')->onDelete('set null');

            // Dados da denúncia
            $table->string('foto')->nullable();
            $table->text('descricao');

            $table->enum('classificacao', ['ambiental', 'civil_criminal', 'perturbacao_paz']);

            $table->string('bairro')->nullable();
            $table->string('rua')->nullable();
            $table->string('cep')->nullable();

            $table->boolean('anonimo')->default(false);

            $table->enum('status', ['enviado', 'aceito', 'rejeitado'])->default('enviado');

            $table->timestamp('data_criacao')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denuncias');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('usuarios');
    }
};