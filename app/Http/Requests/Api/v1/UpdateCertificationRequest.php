<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCertificationRequest extends FormRequest
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
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:1000',
            'completion_date' => 'required|date',
            'certification_no' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.exists' => ':attribute not existed',
            'name.required' => ':atttibute is required.',
            'institution.required' => ':atttibute is required.',
            'short_description.max' => ':atttibute may not be greater than 1000 characters.',
            'completion_date.required' => ':atttibute field is required.',
            'certification_no.max' => ':atttibute may not be greater than 255 characters.',
        ];
    }

    //attributes
    public function attributes(): array
    {
        return [
            'user_id' => 'User',
            'name' => 'Certification Name',
            'institution' => 'institution name',
            'short_description' => 'short description',
            'completion_date' => 'Completion Date',
            'certification_no' => 'Certification Number',
        ];
    }

    // response
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation Failed',
            'errors' => $validator->errors()
        ], 422));
    }
}
