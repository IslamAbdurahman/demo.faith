<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'teacher_id' => 'required|integer',
            'course_id' => 'required|integer',
            'room_id' => 'required|integer',
            'days' => 'required|array',
            'percent' => 'required|integer',
            'starts_at' => 'required',
            'ends_at' => 'required',
        ];
    }
}
