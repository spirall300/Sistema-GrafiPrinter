<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

// Controlador para la gestión de usuarios por parte de administradores
class AdminUserController extends Controller
{
    // Método para mostrar la lista de todos los usuarios (solo para administradores)
    public function index()
    {
        // Solo administradores
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Método para mostrar el formulario de edición de un usuario
    public function edit(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        return view('admin.users.edit', compact('user'));
    }

    // Método para actualizar los datos de un usuario
    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        // Validar los datos del formulario
        $request->validate([
            'role' => 'required|in:admin,encargado',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'security_question' => 'nullable|in:¿Cuál es el nombre de tu primera mascota?,¿Cuál es tu color favorito?,¿Cuál es el nombre de tu madre?,¿En qué ciudad naciste?,¿Cuál es tu comida favorita?',
            'security_answer' => 'nullable|string|max:255',
        ]);

        // Verificar que no se elimine el último administrador
        $admins = User::where('role', 'admin')->count();
        if ($request->role === 'user' && $user->role === 'admin' && $admins <= 1) {
            return redirect()->back()->with('error', 'No puedes cambiar el rol del último administrador.');
        }

        // Preparar los datos para actualizar
        $data = [];
        $data['role'] = $request->role;
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->filled('security_question')) {
            $data['security_question'] = $request->security_question;
        }
        if ($request->filled('security_answer')) {
            $data['security_answer'] = $request->security_answer;
        }

        $user->update($data);

        // Registrar la acción en la bitácora
        Bitacora::log("Usuario #{$user->id} actualizado (rol: {$user->role})");

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Método para eliminar un usuario
    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        // Verificar que no se elimine así mismo o el último administrador
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $admins = User::where('role', 'admin')->count();
        if ($user->role === 'admin' && $admins <= 1) {
            return redirect()->route('admin.users.index')->with('error', 'Debe haber al menos un administrador.');
        }

        $user->delete();

        // Registrar la eliminación en la bitácora
        Bitacora::log("Usuario #{$user->id} eliminado");

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
