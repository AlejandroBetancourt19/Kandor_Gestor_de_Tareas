<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuardarTareaRequest extends FormRequest {
    public function authorize(): bool { //se puede hacer este pedido porque la ruta ya exige sesión
        return true;
    }

    public function rules(): array {
        return [
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:250',
            'categoria_id' => [
                'required', Rule::exists('categorias', 'id')->where('user_id', $this->user()->id), //deben existir en la tabla categorias y deben ser de este usuario
            ], 
            'estado' => 'sometimes|required|in:pendiente,en_proceso,completado',
            'fecha_limite' => 'nullable|date',
        ];
    }

    public function messages(): array {
        return [
            'titulo.required' => 'El título debe ser obligatorio.',
            'titulo.max' => 'El título no puede superar 150 carácteres.',
            'descripcion.max' => 'La decripción no pude superar 250 carácteres.',
            'categoria_id.required' =>'Elige una categoría.',
            'categoria_id.exists' => 'La categoría elegida no es válida.',
            'estado.in' => 'El estado no es válido.',
            'fecha_limite.date' => 'La fecha límite no es válida.',
        ];
    }
}