<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SecurityQuestionController extends Controller
{
    // Muestra la pregunta
    public function showForm(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'Correo no encontrado.']);
        }

        $questions = [
            1 => "¿Cuál es su color favorito?",
            2 => "¿Cuál es su comida favorita?",
            3 => "¿Cuál es su pasatiempo favorito?",
            4 => "¿Cuál es su deporte favorito?",
            5 => "¿Cuál es su fruta favorita?",
            6 => "¿Cuál es su música favorita?",
        ];

        return view('auth.verify-questions', [
            'email' => $email,
            'question' => $questions[$user->security_question] ?? 'No configurada'
        ]);
    }

    // Valida la respuesta
    public function verify(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        // Comparamos la respuesta (puedes usar strtolower para que no importen mayúsculas)
        if ($user && strtolower($user->security_answer) == strtolower($request->answer)) {

            // Si es correcta, lo mandamos a la vista de resetear clave
            // Usamos un token manual para saltar la validación de email por ahora
            return redirect()->route('password.reset', ['token' => 'pregunta-seguridad'])
                             ->with('email', $request->email);
        }

        return back()->withErrors(['answer' => 'La respuesta es incorrecta.']);
    }
}
