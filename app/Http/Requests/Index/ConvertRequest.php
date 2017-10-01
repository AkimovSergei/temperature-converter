<?php

namespace App\Http\Requests\Index;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConvertRequest extends FormRequest
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
            'temperature' => 'required|numeric',
            'from' => [
                'required',
                Rule::in('C', 'F', 'K'),
            ],
            'to' => [
                'required',
                Rule::in('C', 'F', 'K'),
            ],
        ];
    }
}
