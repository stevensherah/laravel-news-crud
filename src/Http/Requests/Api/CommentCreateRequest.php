<?php

namespace Sevenpluss\NewsCrud\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CommentCreateRequest
 * @package Sevenpluss\NewsCrud\Http\Requests\Api
 */
class CommentCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->has('user_id') ? auth()->check() : true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'post_id' => 'required|integer',
            'user_id' => 'required_without_all:name,email|integer|exists:users,id',
            'name' => 'required_without:user_id|required_with:email|string|min:3|max:50',
            'email' => 'required_without:user_id|required_with:name|email|min:6|max:50',
            'content' => 'required|string|between:3,500',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'post_id' => [
                'required' => trans('validation.required',
                    ['attribute' => trans('news::comments.validate_messages.create.post_id')]),
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::comments.validate_messages.create.post_id')]),
            ],
            'user_id' => [
                'required_without_all' => trans('validation.required_without_all',
                    [
                        'attribute' => trans('news::comments.validate_messages.create.user_id'),
                        'values' => trans('news::comments.validate_messages.create.name_and_email')
                    ]),
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::comments.validate_messages.create.user_id')]),
                'exists' => trans('validation.exists',
                    ['attribute' => trans('news::comments.validate_messages.create.user_id')]),
            ],
            'name' => [
                'string' => trans('validation.string',
                    ['attribute' => trans('news::comments.validate_messages.create.name')]),
                'required_without' => trans('validation.required_without',
                    [
                        'attribute' => trans('news::comments.validate_messages.create.name'),
                        'values' => trans('news::comments.validate_messages.create.user_id')
                    ]),
                'required_with' => trans('validation.required_with',
                    [
                        'attribute' => trans('news::comments.validate_messages.create.name'),
                        'values' => trans('news::comments.validate_messages.create.email')
                    ]),
                'min' => [
                    'string' => trans('validation.min.string',
                        ['attribute' => trans('news::comments.validate_messages.create.name'), 'min' => 3]),
                ],
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::comments.validate_messages.create.name'), 'max' => 50]),
                ],
            ],
            'email' => [
                'required_without' => trans('validation.required_without',
                    [
                        'attribute' => trans('news::comments.validate_messages.create.email'),
                        'values' => trans('news::comments.validate_messages.create.user_id')
                    ]),
                'required_with' => trans('validation.required_with',
                    [
                        'attribute' => trans('news::comments.validate_messages.create.email'),
                        'values' => trans('news::comments.validate_messages.create.name')
                    ]),
                'email' => trans('validation.email',
                    ['attribute' => trans('news::comments.validate_messages.create.email')]),
                'min' => [
                    'string' => trans('validation.min.string',
                        ['attribute' => trans('news::comments.validate_messages.create.email'), 'min' => 6]),
                ],
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::comments.validate_messages.create.email'), 'max' => 50]),
                ],
            ],
            'content' => [
                'required' => trans('validation.required',
                    ['attribute' => trans('news::comments.validate_messages.create.content')]),
                'string' => trans('validation.string',
                    ['attribute' => trans('news::comments.validate_messages.create.content')]),
                'min' => [
                    'string' => trans('validation.min.string',
                        ['attribute' => trans('news::comments.validate_messages.create.content'), 'min' => 3]),
                ],
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::comments.validate_messages.create.content'), 'max' => 500]),
                ],
            ],
        ];
    }
}
