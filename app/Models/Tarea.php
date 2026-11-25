<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [ //los campos que se pueden llenar
        'titulo',
        'descripcion',
        'estado',
        'fecha_limite',
        'user_id',
        'categoria_id'
    ];

    protected $casts = [
        'fecha_limite' => 'date:Y-m-d',]; //trata la fecha limite commo una fecha, muestra con el formato año, mes, dia

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categorias() {
        return $this->belongsTo(Categoria::class);
    }
}
