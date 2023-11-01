<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
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
            'subject'=>'required|string',
            'category'=>'required|in:Quality of service,Customer satisfaction,Problems and complaints,Suggestions and recommendations,Infrastructure and technology,Communication and information',
            // 'isAnswered'=>'required',
			'messages'=>'required',
			'file'=>'sometimes|image:jpg,jpeg,png'
        ];
    }
}
