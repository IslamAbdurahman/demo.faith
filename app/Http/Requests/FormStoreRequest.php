<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'gender'=>'required',
            'birth_date'=>'required',
            'phone'=>'required|string|min:12|max:12|unique:students,phone',
            'parent_phone'=>'required|string|min:12|max:12',
        ];
    }
}
