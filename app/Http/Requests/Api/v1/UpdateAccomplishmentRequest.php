<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAccomplishmentRequest extends FormRequest
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
            'user_id' => 'sometimes|exists:users,id',
            'title' => 'sometimes|string|max:255',
            'about' => 'sometimes|string|max:1000',
            'date' => 'sometimes|date',
            'status' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.exists' => ':attribute is invalid.',
            'title.string' => ':attribute must be a string.',
            'about.string' => ':attribute must be a string.',
            'date.date' => ':attribute must be a valid date.',
            'status.boolean' => ':attribute must be true or false.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user_id' => 'User',
            'title' => 'Title',
            'about' => 'About the accomplishment',
            'date' => 'Date of accomplishment',
            'status' => 'status',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation Failed',
            'errors' => $validator->errors()
        ], 422));
    }

}
