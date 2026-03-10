<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
        $id = $this->route('admin');
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:12|max:12|unique:users,phone,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required',
            'role' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ];
    }
}
