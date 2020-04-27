<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExerciceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       return [
            'principe' => 'required|min:1|max:60',
            'sous-principe' => 'required|min:1|max:60',
            'physique' => 'max:60|alpha',
            'time' => 'required|max:10',
            'nb-joueurs' => 'required',
            'description' => 'required|max:900',
            'observations-coach' => 'max:900',
            'image' => 'required|image',
        ];
    }
}
