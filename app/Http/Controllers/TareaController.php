<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarTareaRequest;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    //GET
    public function index(Request $request) {
        return $request
        ->user()
        ->tareas()
        ->with('categoria:id,nombre,color')
        ->latest('id')
        ->get(); //del usuario trae las tareas, tambien el id nombre y colo de la categoria y ordenar de la mas nueva a la mas vieja y traelas
    }

    //POST
    public function store(GuardarTareaRequest $request) {
        $tarea = $request->user()->tareas()->create($request->validated());
        return response()->json([
            'message' => 'Tarea creada correctamente.',
            'tarea' => $tarea->load('categoria'),
        ], 201); //laravel valida antes de entrar y crea la tarea con los datos ya revisados
    }

    //PUT
    public function update(GuardarTareaRequest $request, int $id) {
        $tarea = $request->user()->tareas()->findOrFail($id);
        $tarea->update($request->validated());
        return response()->json([
            'message' => 'Tarea actualizada correctamente',
            'tarea' => $tarea->load('categoria')
        ]);
    }

    //PATCH
    public function actualizarEstado(Request $request, int $id) {
        $datos = $request->validated([
            'estado' => 'required|in:pendiente, en_proceso_completado',
        ]);
        $request->user()->tareas()->findOrFail($id)->update($datos);
        return response()->json([
            'message' => 'Estado actualizado'
        ]);
    }

    //DELETE
    public function destroy(Request $request, int $id) {
        $request->user()->tareas()->FildOrFail($id)->delete();
        return response()->json([
            'message' => 'Tarea eliminada correctamente'
        ]);
    }
}
