<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GraphicStoreRequest extends FormRequest
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
            'year' => 'required',
            'month_list' => 'required|array',
            'group_id' => 'required|integer',
            'education' => 'required'
        ];
    }
}
