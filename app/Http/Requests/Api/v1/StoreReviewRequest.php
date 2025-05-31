<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreReviewRequest extends FormRequest
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
            'user_id'       => 'required|exists:users,id',
            'is_guest'      => 'nullable|boolean',
            'rater_name'    => 'required|string|max:255',
            'rater_user_id' => 'nullable|exists:users,id',
            'review_msg'    => 'nullable|string|max:255',
            'ratings'       => 'nullable|integer|max:5',
            'date_given'    => 'required|date'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists'      => ':attribute does not exist.',
            'rater_name.required'    => ':attribute name is required.',
            'rater_name.max'       => ':attribute name must be less than 255 characters.',
            'date_given.required'    => ':attribute given is required.',  
            'date_given.date'      => ':attribute given must be a valid date.'
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id'       => 'User',
            'is_guest'      => 'Is Guest',  
            'rater_name'    => 'Rater Name',
            'rater_user_id' => 'Rater User ID',
            'review_msg'    => 'Review Message',
            'ratings'       => 'Ratings',
            'date_given'    => 'Date Given'
        ];
    }

    //response
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation Failed',
            'errors' => $validator->errors()
        ], 422));
    }

}
