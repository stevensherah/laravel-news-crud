<?php

namespace Sevenpluss\NewsCrud\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostCreateRequest
 * @package Sevenpluss\NewsCrud\Http\Requests\Web
 */
class PostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'published_at' => 'nullable',
            'published_now' => 'nullable|boolean',
            'category_id' => 'required|integer',
            'slug' => ['nullable', 'string', 'max:70', 'regex:/^[0-9a-zA-Z\-]+/'],

            'title' => 'nullable|string|max:55',
            'description' => 'nullable|string|max:155',
            'keywords' => 'nullable|string|max:250',
            'name' => 'required|string|max:255',
            'summary' => 'required|string|max:1000',
            'story' => 'nullable|string|max:5000',

            'tags' => 'sometimes|array',
            'tags.*' => 'sometimes|string|max:20',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'user_id' => [
                'required' => trans('validation.required',
                    ['attribute' => trans('news::post.validate_messages.create.user_id')]),
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::post.validate_messages.create.user_id')]),
            ],
            'published_at' => [
                'date_format' => trans('validation.date_format',
                    [
                        'attribute' => trans('news::post.validate_messages.create.published_at'),
                        'format' => 'YYYY-MM-DD h:m:s'
                    ]),
            ],
            'published_now' => [
                'boolean' => trans('validation.boolean',
                    ['attribute' => trans('news::post.validate_messages.create.published_now')]),
            ],
            'category_id' => [
                'required' => trans('validation.required',
                    ['attribute' => trans('news::post.validate_messages.create.category_id')]),
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::post.validate_messages.create.category_id')]),
            ],
            'slug' => [
                'string' => trans('validation.string',
                    ['attribute' => trans('news::post.validate_messages.create.slug')]),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::post.validate_messages.create.slug'), 'max' => 70]),
                ],
            ],

            'tags' => [
                'array' => trans('validation.array',
                    ['attribute' => trans('news::post.validate_messages.create.tags')]),
                '*' => [
                    'string' => trans('validation.string',
                        ['attribute' => trans('news::post.validate_messages.create.tags')]),
                    'max' => [
                        'string' => trans('validation.max.string',
                            ['attribute' => trans('news::post.validate_messages.create.tags'), 'max' => 20]),
                    ],
                ],
            ],

            'title' => [
                'string' => trans('validation.string',
                    ['attribute' => trans('news::post.validate_messages.create.title')]),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::post.validate_messages.create.title'), 'max' => 55]),
                ],
            ],
            'description' => [
                'string' => trans('validation.string',
                    ['attribute' => trans('news::post.validate_messages.create.description')]),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::post.validate_messages.create.description'), 'max' => 155]),
                ],
            ],
            'keywords' => [
                'string' => trans('validation.string',
                    ['attribute' => trans('news::post.validate_messages.create.keywords')]),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::post.validate_messages.create.keywords'), 'max' => 250]),
                ],
            ],
            'name' => [
                'required' => trans('validation.required',
                    ['attribute' => trans('news::post.validate_messages.create.name')]),
                'string' => trans('validation.string',
                    ['attribute' => trans('news::post.validate_messages.create.name')]),
                'min' => [
                    'string' => trans('validation.min.string',
                        ['attribute' => trans('news::post.validate_messages.create.name'), 'min' => 3]),
                ],
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::post.validate_messages.create.name'), 'max' => 255]),
                ],
            ],
            'summary' => [
                'required' => trans('validation.required',
                    ['attribute' => trans('news::post.validate_messages.create.summary')]),
                'string' => trans('validation.string',
                    ['attribute' => trans('news::post.validate_messages.create.summary')]),
                'min' => [
                    'string' => trans('validation.min.string',
                        ['attribute' => trans('news::post.validate_messages.create.summary'), 'min' => 3]),
                ],
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::post.validate_messages.create.summary'), 'max' => 1000]),
                ],
            ],
            'story' => [
                'string' => trans('validation.string',
                    ['attribute' => trans('news::post.validate_messages.create.story')]),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::post.validate_messages.create.story'), 'max' => 5000]),
                ],
            ],

        ];
    }
}
