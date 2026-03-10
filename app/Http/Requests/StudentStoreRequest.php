<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:students,name',
            'gender' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|min:12|max:12|unique:students,phone',
            'parent_phone' => 'nullable|string|min:12|max:12',
            'discount_education' => 'required|integer',
        ];
    }
}
