<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstudianteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function getEstudianteIdToIgnore()
    {
        $estudiante = $this->route('estudiante');
        return $estudiante ? $estudiante->id : null;
    }

    public function storeRules(): array
    {
        return [
            'cedula' => ['required', 'string', 'max:20', 'unique:estudiante,cedula'],

            'primer_nombre' => ['required', 'string', 'max:100', 'alpha_spaces'],
            'segundo_nombre' => ['nullable', 'string', 'max:100', 'alpha_spaces'],
            'primer_apellido' => ['required', 'string', 'max:100', 'alpha_spaces'],
            'segundo_apellido' => ['nullable', 'string', 'max:100', 'alpha_spaces'],

            'fecha_nacimiento' => ['required', 'date', 'before:today', 'after:2000-01-01'],
            'genero' => ['required', 'in:M,F,O'],
            'nacionalidad' => ['nullable', 'string', 'max:100', 'alpha_spaces'],

            'provincia' => ['nullable', 'string', 'max:100', 'alpha_spaces'],
            'canton' => ['nullable', 'string', 'max:100', 'alpha_spaces'],
            'distrito' => ['nullable', 'string', 'max:100', 'alpha_spaces'],
            'direccion_exacta' => ['nullable', 'string', 'max:500'],

            'grado_id' => ['required', 'exists:grado,id'],
            'activo' => ['nullable', 'boolean'],

            'tiene_adecuacion' => ['nullable', 'boolean'],
            'adecuacion_id' => ['nullable', 'required_if:tiene_adecuacion,1', 'exists:adecuacion,id'],
            'nivel_adecuacion' => ['nullable', 'required_if:tiene_adecuacion,1', 'in:Significativa,No Significativa,De Acceso'],
            'fecha_asignacion_adecuacion' => ['nullable', 'required_if:tiene_adecuacion,1', 'date', 'before_or_equal:today'],
            'adecuacion_activa' => ['nullable', 'boolean'],
        ];
    }

    public function updateRules(): array
    {
        $estudiante_id = $this->getEstudianteIdToIgnore();

        return [
            'cedula' => ['required', 'string', 'max:20', Rule::unique('estudiante', 'cedula')->ignore($estudiante_id)],

            'primer_nombre' => ['required', 'string', 'max:100', 'alpha_spaces'],
            'segundo_nombre' => ['nullable', 'string', 'max:100', 'alpha_spaces'],
            'primer_apellido' => ['required', 'string', 'max:100', 'alpha_spaces'],
            'segundo_apellido' => ['nullable', 'string', 'max:100', 'alpha_spaces'],

            'fecha_nacimiento' => ['required', 'date', 'before:today', 'after:2000-01-01'],
            'genero' => ['required', 'in:M,F,O'],
            'nacionalidad' => ['nullable', 'string', 'max:100', 'alpha_spaces'],

            'provincia' => ['nullable', 'string', 'max:100', 'alpha_spaces'],
            'canton' => ['nullable', 'string', 'max:100', 'alpha_spaces'],
            'distrito' => ['nullable', 'string', 'max:100', 'alpha_spaces'],
            'direccion_exacta' => ['nullable', 'string', 'max:500'],

            'grado_id' => ['nullable', 'exists:grado,id'],
            'activo' => ['nullable', 'boolean'],

            'tiene_adecuacion' => ['nullable', 'boolean'],
            'adecuacion_id' => ['nullable', 'required_if:tiene_adecuacion,1', 'exists:adecuacion,id'],
            'nivel_adecuacion' => ['nullable', 'required_if:tiene_adecuacion,1', 'in:Significativa,No Significativa,De Acceso'],
            'fecha_asignacion_adecuacion' => ['nullable', 'required_if:tiene_adecuacion,1', 'date', 'before_or_equal:today'],
            'adecuacion_activa' => ['nullable', 'boolean'],
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
            // Cédula
            'cedula.required' => 'Por favor, ingrese la cédula del estudiante.',
            'cedula.unique' => 'Esta cédula ya está registrada en el sistema.',
            'cedula.max' => 'La cédula no puede tener más de 20 caracteres.',

            // Nombres
            'primer_nombre.required' => 'Por favor, ingrese el primer nombre del estudiante.',
            'primer_nombre.alpha_spaces' => 'El primer nombre solo debe contener letras y espacios.',
            'primer_nombre.max' => 'El primer nombre no puede tener más de 100 caracteres.',

            'segundo_nombre.alpha_spaces' => 'El segundo nombre solo debe contener letras y espacios.',
            'segundo_nombre.max' => 'El segundo nombre no puede tener más de 100 caracteres.',

            // Apellidos
            'primer_apellido.required' => 'Por favor, ingrese el primer apellido del estudiante.',
            'primer_apellido.alpha_spaces' => 'El primer apellido solo debe contener letras y espacios.',
            'primer_apellido.max' => 'El primer apellido no puede tener más de 100 caracteres.',

            'segundo_apellido.alpha_spaces' => 'El segundo apellido solo debe contener letras y espacios.',
            'segundo_apellido.max' => 'El segundo apellido no puede tener más de 100 caracteres.',

            // Fecha de nacimiento
            'fecha_nacimiento.required' => 'Por favor, ingrese la fecha de nacimiento.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'fecha_nacimiento.after' => 'La fecha de nacimiento debe ser posterior al año 2000.',

            // Género
            'genero.required' => 'Por favor, seleccione el género del estudiante.',
            'genero.in' => 'El género seleccionado no es válido.',

            // Nacionalidad
            'nacionalidad.alpha_spaces' => 'La nacionalidad solo debe contener letras y espacios.',
            'nacionalidad.max' => 'La nacionalidad no puede tener más de 100 caracteres.',

            // Dirección
            'provincia.alpha_spaces' => 'La provincia solo debe contener letras y espacios.',
            'provincia.max' => 'La provincia no puede tener más de 100 caracteres.',

            'canton.alpha_spaces' => 'El cantón solo debe contener letras y espacios.',
            'canton.max' => 'El cantón no puede tener más de 100 caracteres.',

            'distrito.alpha_spaces' => 'El distrito solo debe contener letras y espacios.',
            'distrito.max' => 'El distrito no puede tener más de 100 caracteres.',

            'direccion_exacta.max' => 'La dirección exacta no puede tener más de 500 caracteres.',

            // Grado
            'grado_id.required' => 'Por favor, seleccione un grado para el estudiante.',
            'grado_id.exists' => 'El grado seleccionado no es válido.',

            // Adecuaciones
            'adecuacion_id.required_if' => 'Debe seleccionar un tipo de adecuación.',
            'adecuacion_id.exists' => 'La adecuación seleccionada no es válida.',

            'nivel_adecuacion.required_if' => 'Debe seleccionar un nivel de adecuación.',
            'nivel_adecuacion.in' => 'El nivel de adecuación seleccionado no es válido.',

            'fecha_asignacion_adecuacion.required_if' => 'Debe ingresar la fecha de asignación de la adecuación.',
            'fecha_asignacion_adecuacion.date' => 'La fecha de asignación no es válida.',
            'fecha_asignacion_adecuacion.before_or_equal' => 'La fecha de asignación no puede ser posterior a hoy.',
        ];
    }
}
