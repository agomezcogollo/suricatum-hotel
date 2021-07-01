<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|max:20',
            'apellido' => 'required|max:20',
            'telefono' => 'required|max:15',
            'correo_electronico' => 'required|max:30',
            'direccion' => 'required|min:5',
            'foto' => 'required|image|mimes:jpg,bmp,png|max:5120',
        ];
    }
}
