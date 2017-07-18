<?php

namespace Sevenpluss\NewsCrud\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostDeleteRequest
 * @package Sevenpluss\NewsCrud\Http\Requests\Api
 */
class PostDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'id' => [
                'required' => trans('validation.required',
                    ['attribute' => trans('news::post.validate_messages.delete.id')]),
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::post.validate_messages.delete.id')]),
            ],
        ];
    }
}
