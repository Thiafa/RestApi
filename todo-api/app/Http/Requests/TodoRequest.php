<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'task' => ['required', 'max:127'],
            'due' => ['required', 'date'],
            'status' => ['required', 'boolean']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O :attribute precisa ser preenchido.',
            'max' => 'O :attribute deve ter no máximo 127 caracteres.',
            'status.boolean' => 'O :attribute precisa ser true ou false.',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'data'      => $validator->errors()
            ], status: 400)
        );
    }
}
