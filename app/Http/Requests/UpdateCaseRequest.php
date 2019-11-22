<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
<<<<<<< HEAD
use App\Models\Case_Study;
=======
use App\Models\Case;
>>>>>>> Gustavo

class UpdateCaseRequest extends FormRequest
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
<<<<<<< HEAD
        $rules = Case_Study::$rules;

=======
        $rules = Case::$rules;
        
>>>>>>> Gustavo
        return $rules;
    }
}
