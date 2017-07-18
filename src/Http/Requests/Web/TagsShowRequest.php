<?php

namespace Sevenpluss\NewsCrud\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TagsShowRequest
 * @package Sevenpluss\NewsCrud\Http\Requests\Web
 */
class TagsShowRequest extends FormRequest
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
            'limit' => 'sometimes|integer|max:100',
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
                    ['attribute' => trans('news::tags.validate_messages.show.page')]),
            ],
            'limit' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::tags.validate_messages.show.limit')]),
                'max' => [
                    'integer' => trans('validation.max.integer',
                        ['attribute' => trans('news::tags.validate_messages.show.limit'), 'max' => 100]),
                ],
            ],
            'user_id' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::tags.validate_messages.show.user_id')]),
                'exists' => trans('validation.exists',
                    ['attribute' => trans('news::tags.validate_messages.show.user_id')]),
            ],
        ];
    }
}
