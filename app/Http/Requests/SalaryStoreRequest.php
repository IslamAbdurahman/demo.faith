<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryStoreRequest extends FormRequest
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
            'kassa_id' => 'required|integer',
            'worker_id' => 'required|integer',
            'amount' => 'required|numeric',
            'comment' => 'required|string',
            'personal' => 'required|string',
        ];
    }
}
