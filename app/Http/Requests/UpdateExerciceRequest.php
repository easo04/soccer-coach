<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciceRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'principe' => 'required|min:1|max:100',
            'sousPrincipe' => 'required|min:1|max:100',
            'physique' => 'max:60|alpha',
            'time' => 'required|max:10',
            'nbJoueurs' => 'required',
            'description' => 'required|max:900',
            'observations' => 'max:900',
            'url',
            'typesexcercice_id' => 'required'
        ];
    }

    /*public function messages(){
        return [
            'principe.require' => 'Champ obligatoire',
            'time.require' => 'Champ obligatoire',
            'nbJoueurs.require' => 'Champ obligatoire',
            'description.require' => 'Champ obligatoire',
        ];
    }*/

}
