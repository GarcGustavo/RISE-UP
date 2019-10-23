<?php

namespace App\Http\Requests\API;

use App\Models\Item_Type;
use InfyOm\Generator\Request\APIRequest;

class UpdateItem_TypeAPIRequest extends APIRequest
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
        $rules = Item_Type::$rules;
        
        return $rules;
    }
}
