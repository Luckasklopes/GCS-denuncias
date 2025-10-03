<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    use HasFactory;

    protected $table = 'denuncias';
    protected $primaryKey = 'id_denuncia';

    protected $fillable = [
        'id_usuario',
        'id_admin',
        'foto',
        'descricao',
        'classificacao',
        'bairro',
        'rua',
        'cep',
        'anonimo',
        'status',
        'motivo_rejeicao'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}
