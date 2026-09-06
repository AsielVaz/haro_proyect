<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return session()->has('haro_admin.id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_marca' => ['required', 'integer', 'exists:marca,id'],
            'id_modelo' => ['required', 'integer', 'exists:modelo,id'],
            'id_transmision' => ['required', 'integer', 'exists:transmision,id'],
            'id_interiores' => ['required', 'integer', 'exists:interiores,id'],
            'id_duenio' => ['required', 'integer', 'exists:clientes_banca,id'],
            'id_almacen' => ['nullable', 'integer', 'exists:almacenes,id'],
            'anio' => ['required', 'integer', 'between:1950,'.(date('Y') + 2)],
            'cilindrage' => ['required', 'integer', 'min:0'],
            'precio' => ['required', 'numeric', 'min:0'],
            'kilometrage' => ['required', 'integer', 'min:0'],
            'asientos' => ['required', 'integer', 'between:1,20'],
            'descripcion' => ['required', 'string', 'max:2000'],
            'nacionalidad' => ['required', 'string', 'max:50'],
            'estatus' => ['required', 'string', 'max:50'],
            'combustible' => ['required', 'string', 'max:50'],
            'color' => ['required', 'string', 'max:50'],
            'cuerpo' => ['required', 'string', 'max:50'],
            'poder' => ['required', 'string', 'max:50'],
            'consig' => ['nullable', 'boolean'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['integer', 'exists:imagen,id'],
        ];
    }
}
