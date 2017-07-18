<?php

namespace Sevenpluss\NewsCrud\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostIndexRequest
 * @package Sevenpluss\NewsCrud\Http\Requests\Web
 */
class PostIndexRequest extends FormRequest
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
            'page' => 'sometimes|integer',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'user_id' => 'sometimes|integer|exists:users,id',
            'limit' => 'sometimes|integer|max:100',
            'tag' => 'sometimes|string|between:2,20',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'page' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::post.validate_messages.index.page')]),
            ],
            'limit' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::post.validate_messages.index.limit')]),
                'max' => [
                    'integer' => trans('validation.max.integer',
                        ['attribute' => trans('news::post.validate_messages.index.limit'), 'max' => 100]),
                ],
            ],
            'category_id' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::post.validate_messages.index.category_id')]),
                'exists' => trans('validation.exists',
                    ['attribute' => trans('news::post.validate_messages.index.category_id')]),
            ],
            'user_id' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::post.validate_messages.index.user_id')]),
                'exists' => trans('validation.exists',
                    ['attribute' => trans('news::post.validate_messages.index.user_id')]),
            ],
            'tag' => [
                'string' => trans('validation.integer',
                    ['attribute' => trans('news::post.validate_messages.index.limit')]),
                'between' => [
                    'string' => trans('validation.between.string',
                        ['attribute' => trans('news::post.validate_messages.index.limit'), 'min' => 3, 'max' => 20])
                ],
            ],
        ];
    }
}
