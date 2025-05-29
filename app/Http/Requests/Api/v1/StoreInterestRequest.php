<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreInterestRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:interests,name',
            'is_active' => 'required|boolean',
            'is_featured' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer',
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
            'name.required' => ':atttibute is required.',
            'name.unique' => ':atttibute is already exist.',
            'name.max' => ':atttibute only 255 maximum characters.',
            'is_active.required' => ':atttibute is required.',
        ];
    }

    //attributes
    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'is_active' => 'Status',
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
