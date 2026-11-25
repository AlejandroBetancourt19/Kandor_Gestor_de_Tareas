<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function mostrarLogin(){
        return view('auth.login');
    }

    public function mostrarRegistro(){
        return view('auth.registro');
    }

    public function registro(Request $request){ //recordatorio -> en $request se gusarda la información de pedido
        $datos = $request->validate([
            'name'=> 'required | string | max:100',
            'email' => 'required | email | max:150 | unique:users,email', //Que el correo sea valido y unico
            'password' => 'required | string | min:6 | confirmed',
        ], [
            'name.required' => 'Escribe tu nombre',
            'email.required' => 'Escribe tu correo',
            'email.email' => 'El correo el inválido',
            'email.unique' => 'El correo ya está registrado',
            'password.required' => 'Escribe una contraseña',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]
        );

        User::create($datos); //Se crea el usuario nuevo
        return redirect()->route('login')->with('ok', '¡Cuenta creada! Ya puedes entrar.'); //Lleva al login con el mensaje de cuenta creada

    }

    public function login(Request $request){
        $credenciales = $request->validate([
            'email' => 'required | email',
            'password' => 'required',
        ], [
            'email.required' => 'Escribe tu correo',
            'email.email' => 'El correo es inválido',
            'password.required' => 'Escribe tu contraseña',
        ]);

        if (Auth::attempt($credenciales)){ //Busca al usuario y comprueba que la contraseña sea correcta
            $request->session()->regenerate(); //Cambia el identificador de la sesión

            return redirect()->intended(route('panel')); //Lo lleva a donde quería ir o al panel
        }

             //mensaje si falla el correo o la contraseña
            return back()
                ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
                ->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout(); //cierra la sesión

        //borrar el resto de los datos de seguridad
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('ok', 'Cerraste sesión. ¡Hasta pronto!'); //manda al login y muestra el mensaje
    } 
}
