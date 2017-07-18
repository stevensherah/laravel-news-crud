<?php

namespace Sevenpluss\NewsCrud\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CommentsIndexRequest
 * @package Sevenpluss\NewsCrud\Http\Requests\Web
 */
class CommentsIndexRequest extends FormRequest
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
            'user_id' => 'sometimes|integer|exists:users,id',
            'post_id' => 'sometimes|integer|exists:posts,id',
            'limit' => 'sometimes|integer|max:100'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'page' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::comments.validate_messages.index.page')]),
            ],
            'user_id' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::comments.validate_messages.index.user_id')]),
                'exists' => trans('validation.exists',
                    ['attribute' => trans('news::comments.validate_messages.index.user_id')]),
            ],
            'post_id' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::comments.validate_messages.index.post_id')]),
                'exists' => trans('validation.exists',
                    ['attribute' => trans('news::comments.validate_messages.index.post_id')]),
            ],
            'limit' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::comments.validate_messages.index.limit')]),
                'max' => [
                    'integer' => trans('validation.max.integer',
                        ['attribute' => trans('news::comments.validate_messages.index.limit'), 'max' => 100]),
                ],
            ],
        ];
    }
}
