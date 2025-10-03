<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaestroRequest;
use App\Models\Maestro;
use App\Models\User;
use App\Models\UsuarioRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MaestroController extends Controller
{

    /**
     * Muestra una lista de todos los maestros.
     */
    public function index(): View
    {
        return view('maestros.index');
    }

    /**
     * Muestra los detalles de un maestro específico usando Route-Model Binding.
     */
    public function show(Maestro $maestro): View
    {
        $maestro->load(['user', 'materias']);
        return view('maestros.show', compact('maestro'));
    }

    public function create(): View
    {
        $maestro = null;
        return view('maestros.create', compact('maestro'));
    }

    public function edit(Maestro $maestro): View
    {
        $maestro->load('user');
        return view('maestros.create', compact('maestro'));
    }

    public function store(MaestroRequest $request)
    {
        // 1. Validar datos. Laravel redirecciona automáticamente si falla.
        $datosValidados = $request->validated();
        $passwordPorDefecto = '12345678';
        $user = null; // Inicializar User para el catch
        $usuariorol = null;
        try {
            // ----------------------------------------------------
            // PASO 2: CREAR EL REGISTRO DE USUARIO (User)
            // ----------------------------------------------------

            $nombreCompleto = trim($datosValidados['primer_nombre'] . ' ' . $datosValidados['primer_apellido']);

            $user = User::create([
                'cedula' => $datosValidados['cedula'],
                'name' => $nombreCompleto,
                'email' => $datosValidados['correo'],
                'password' => Hash::make($passwordPorDefecto),
                'activo' => true,
                // Asegúrate de que el modelo User tenga 'cedula', 'name', 'email', 'password' y 'activo' en $fillable.
            ]);


            // ----------------------------------------------------
            // PASO 3: CREAR EL REGISTRO DEL MAESTRO (Maestro)
            // ----------------------------------------------------

            // a) Agregamos el ID del usuario al array de datos
            $datosValidados['usuario_id'] = $user->id;

            // b) Eliminamos la cédula, ya que la tabla 'maestro' NO tiene columna 'cedula'
            unset($datosValidados['cedula']);
            unset($datosValidados['correo']);

            $usuariorol = UsuarioRol::create(['usuario_id' => $user->id, 'rol_id' => 2,]);

            // c) Creamos el Maestro con el ID de usuario recién vinculado
            $maestro = Maestro::create($datosValidados);

            // 4. Redirección al Detalle
            return redirect()
                ->route('maestros.show', $maestro)
                ->with('success', 'El maestro y su usuario de acceso fueron registrados exitosamente.');

        } catch (\Exception $e) {

            // Si algo falla al crear el maestro, eliminamos el usuario que ya se creó
            if (isset($user)) {
                $user->delete();
            }

            if (isset($usuariorol)) {
                $usuariorol->delete();
            }

            return back()->withInput()->with('error', 'Hubo un error al guardar el maestro o su usuario. Inténtelo de nuevo.');
        }
    }

    public function update(MaestroRequest $request, Maestro $maestro)
    {
        $datosValidados = $request->validated();

        try {

            $nombreCompleto = trim($datosValidados['primer_nombre'] . ' ' . $datosValidados['primer_apellido']);

            $userData = [
                'name' => $nombreCompleto,
                'email' => $datosValidados['correo'],
                'activo' => $datosValidados['activo'],
            ];

            if (!empty($datosValidados['password'])) {
                $userData['password'] = Hash::make($datosValidados['password']);
            }

            $maestro->user->update($userData);

            unset($datosValidados['cedula']);
            unset($datosValidados['correo']);
            unset($datosValidados['password']);
            unset($datosValidados['password_confirmation']);

            $maestro->update($datosValidados);

            return redirect()
                ->route('maestros.show', $maestro)
                ->with('success', 'El maestro y su usuario de acceso fueron actualizados exitosamente.');

        } catch (\Exception $e) {

            return back()->withInput()->with('error', 'Hubo un error al actualizar el maestro o su usuario. Inténtelo de nuevo.');
        }
    }

    public function destroy(Maestro $maestro)
    {

        try {
            $userData = ['activo' => 0];

            $maestro->user->update($userData);
            $maestro->update($userData);

            return redirect()
                ->route('maestros.index', $maestro)
                ->with('success', 'El maestro y su usuario de acceso fueron inactivados exitosamente.');

        } catch (\Exception $e) {

            return back()->withInput()->with('error', 'Hubo un error al inactivar el maestro o su usuario. Inténtelo de nuevo.');
        }
    }

}
