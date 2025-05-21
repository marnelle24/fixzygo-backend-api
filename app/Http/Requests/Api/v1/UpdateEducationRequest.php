<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateEducationRequest extends FormRequest
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
            'type'          => 'required|string|max:255',
            'degree'        => 'nullable|string|max:255',
            'title'         => 'nullable|string|max:255',
            'institution'   => 'required|string|max:255',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date',
            'status'        => 'nullable|string|max:255',
            'grade'         => 'nullable|string|max:255',
            'field_of_study'=> 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'    => ':attribute is required.',
            'institution.required' => ':attribute is required.',
            'start_date.required' => ':attribute is required.',
            'end_date.required'   => ':attribute is required.',
        ];
    }
    public function attributes(): array
    {
        return [
            'user_id'       => 'User',
            'type'          => 'Type',
            'degree'        => 'Degree',
            'title'         => 'title',
            'institution'   => 'Institution',
            'start_date'    => 'Start Date',
            'end_date'      => 'End Date',
            'status'        => 'Status',
            'grade'         => 'Grade',
            'field_of_study'=> 'Field of Study',
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
