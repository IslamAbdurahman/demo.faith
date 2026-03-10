<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
        $student = $this->route('student');
        $id = $student ? $student->id : null;
        return [
            'name' => 'required|string|max:255|unique:students,name,' . $id,
            'gender' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|min:12|max:12|unique:students,phone,' . $id,
            'parent_phone' => 'nullable|string|min:12|max:12',
            'discount_education' => 'required|integer',
        ];
    }
}
