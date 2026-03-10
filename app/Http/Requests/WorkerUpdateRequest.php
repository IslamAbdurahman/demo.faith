<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkerUpdateRequest extends FormRequest
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
            'phone'=>['required','string','min:12','max:12', Rule::unique('users', 'phone')->ignore($this->worker->id)],
            'email'=>'required',
            'password'=>'required',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ];
    }
}
