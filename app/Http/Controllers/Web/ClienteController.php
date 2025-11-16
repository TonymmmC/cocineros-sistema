<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ClienteController extends Controller
{
    public function showLoginForm(): View
    {
        return view('cliente.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Bienvenido de nuevo!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegisterForm(): View
    {
        return view('cliente.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'nullable|string|max:20',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'cliente',
        ]);

        // Crear perfil de cliente
        Cliente::create([
            'user_id' => $user->id,
            'telefono' => $validated['telefono'] ?? null,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Cuenta creada exitosamente!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Sesión cerrada correctamente.');
    }

    public function perfil(): View
    {
        $user = Auth::user();
        $cliente = $user->cliente;

        $estadisticas = [
            'total_pedidos' => $cliente ? $cliente->pedidos()->count() : 0,
            'pedidos_completados' => $cliente ? $cliente->pedidos()->where('estado', 'entregado')->count() : 0,
            'total_gastado' => $cliente ? $cliente->pedidos()->where('estado', 'entregado')->sum('total') : 0,
            'favoritos' => $cliente ? $cliente->favoritos()->count() : 0,
        ];

        return view('cliente.perfil', compact('user', 'cliente', 'estadisticas'));
    }

    public function updatePerfil(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telefono' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        if ($user->cliente) {
            $user->cliente->update([
                'telefono' => $validated['telefono'] ?? $user->cliente->telefono,
            ]);
        }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function pedidos(): View
    {
        $user = Auth::user();
        $pedidos = collect();

        if ($user->cliente) {
            $pedidos = $user->cliente->pedidos()
                ->with(['cocinero', 'detalles'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('cliente.pedidos', compact('pedidos'));
    }

    public function favoritos(): View
    {
        $user = Auth::user();
        $favoritos = collect();

        if ($user->cliente) {
            $favoritos = $user->cliente->favoritos()
                ->with(['producto.categoria', 'producto.cocinero'])
                ->paginate(12);
        }

        return view('cliente.favoritos', compact('favoritos'));
    }
}
