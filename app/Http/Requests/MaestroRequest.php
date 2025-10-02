<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaestroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function getUserIdToIgnore()
    {
        $maestro = $this->route('maestro');

        return $maestro && $maestro->user ? $maestro->user->id : null;
    }

    public function storeRules(): array
    {
        return [

            'primer_nombre' => ['required', 'string', 'max:25', 'alpha_spaces'],
            'segundo_nombre' => ['nullable', 'string', 'max:25', 'alpha_spaces'],
            'primer_apellido' => ['required', 'string', 'max:25', 'alpha_spaces'],
            'segundo_apellido' => ['nullable', 'string', 'max:25', 'alpha_spaces'],

            'nacionalidad' => ['required', 'string', 'max:25', 'alpha_spaces'],

            'cedula' => ['required', 'string', 'max:50', 'alpha_num', 'unique:users,cedula'],

            'telefono' => ['required', 'regex:/^[78624]\d{7}$/',],

            'correo' => ['required', 'email:rfc,dns', 'max:100', 'unique:users,email'],

            'nombramiento_inicio' => ['required', 'date'],

            'nombramiento_final' => ['required', 'date', 'after_or_equal:nombramiento_inicio'],

        ];
    }

    public function updateRules(): array
    {
        $maestro_user_id = $this->getUserIdToIgnore();

        return [

            'primer_nombre' => ['required', 'string', 'max:25', 'alpha_spaces'],
            'segundo_nombre' => ['nullable', 'string', 'max:25', 'alpha_spaces'],
            'primer_apellido' => ['required', 'string', 'max:25', 'alpha_spaces'],
            'segundo_apellido' => ['nullable', 'string', 'max:25', 'alpha_spaces'],

            'nacionalidad' => ['required', 'string', 'max:25', 'alpha_spaces'],

            'telefono' => ['required', 'regex:/^[78624]\d{7}$/',],

            'correo' => ['required', 'email:rfc,dns', 'max:100', Rule::unique('users', 'email')->ignore($maestro_user_id),],

            'nombramiento_inicio' => ['required', 'date'],

            'nombramiento_final' => ['required', 'date', 'after_or_equal:nombramiento_inicio'],

            'password' => ['nullable', 'string', 'max:12', 'confirmed'],
            'password_confirmation' => ['nullable', 'string', 'max:12', 'required_with:password'],

            'activo' => ['required'],
        ];
    }

    public function rules(): array
    {
        if ($this->isMethod('POST')) {
            return $this->storeRules();
        }

        return $this->updateRules();
    }

    public function messages(): array
    {
        return [

            'primer_nombre.required' => 'Por favor, ingrese el primer nombre del maestro.',
            'primer_nombre.alpha_spaces' => 'El nombre solo debe de tener letras.',

            'segundo_nombre.alpha_spaces' => 'El nombre solo debe de tener letras.',

            'primer_apellido.required' => 'Por favor, ingrese el primer apellido del maestro.',
            'primer_apellido.alpha_spaces' => 'El primer apellido solo debe de tener letras.',

            'segundo_apellido.alpha_spaces' => 'El segundo apellido solo debe de tener letras.',

            'correo.email' => 'El formato del correo electrónico no es válido. Por favor, revíselo.',
            'correo.required' => 'Por favor, ingrese el correo.',
            'correo.unique' => 'El correo ya se encuentra registrado a otro maestro.',


            'cedula.unique' => 'La cédula ingresada ya está registrada en el sistema.',
            'cedula.required' => 'Por favor, ingrese la identificación.',
            'cedula.alpha_num' => 'La cédula solo debe contener letras y números, sin espacios ni símbolos.',

            'telefono.required' => 'Debe ingresar un número de teléfono de 8 dígitos.',
            'telefono.regex' => 'El teléfono debe ser de 8 dígitos y debe comenzar con 7, 8, 6, 2, o 4.',

            'nombramiento_inicio.required' => 'Por favor, ingrese fecha de inicio del nombramiento.',

            'nombramiento_final.after_or_equal' => 'La fecha de fin de nombramiento no puede ser anterior a la fecha de inicio.',
            'nombramiento_final.required' => 'Por favor, ingrese la fecha final del nombramiento.',

            'nacionalidad.alpha_spaces' => 'La nacionalidad solo debe contener letras y espacios.',
            'nacionalidad.required' => 'Por favor, ingrese la nacionalidad.',

            'password_confirmation' => 'La contraseña no coincide.',
            'password' => 'La contraseña no coincide.',
        ];
    }

}
