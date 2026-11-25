<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    //Campos que se pueden llenar en bloque (create/update)
    protected $fillable = [
        'nombre',
        'color'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tarea (){
        return $this->hasMany(Tarea::class);
    }
}
