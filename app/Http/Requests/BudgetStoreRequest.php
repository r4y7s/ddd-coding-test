<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudgetStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
        //return !empty($this->toArray());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
//            '*' => [
//                'required',
//                'array'
//            ],
            '*.netAmount' => [
                'required',
                'numeric',
                'min:0'
            ],
            '*.vat' => [
                'required',
                'numeric',
                'min:0'
            ],
            '*.vatAmount' => [
                'required',
                'numeric',
                'min:0'
            ],
        ];
    }
}
