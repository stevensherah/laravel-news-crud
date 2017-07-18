<?php

namespace Sevenpluss\NewsCrud\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CategoryCreateRequest
 * @package Sevenpluss\NewsCrud\Http\Requests\Web
 */
class CategoryCreateRequest extends FormRequest
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
            'active' => 'nullable|boolean',
            'slug' => ['sometimes', 'string', 'max:70', 'regex:/^[0-9a-zA-Z\-]+/'],
            'name' => 'required|string|max:100',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'active' => [
                'boolean' => trans('validation.boolean',
                    ['attribute' => trans('news::category.validate_messages.create.active')]),
            ],
            'slug' => [
                'string' => trans('validation.string',
                    ['attribute' => trans('news::category.validate_messages.create.slug')]),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::category.validate_messages.create.slug'), 'max' => 70]),
                ],
                'regex' => trans('validation.regex',
                    ['attribute' => trans('news::category.validate_messages.create.slug')]),
            ],
            'name' => [
                'required' => trans('validation.required',
                    ['attribute' => trans('news::category.validate_messages.create.name')]),
                'string' => trans('validation.string',
                    ['attribute' => trans('news::category.validate_messages.create.name')]),
                'max' => [
                    'string' => trans('validation.max.string',
                        ['attribute' => trans('news::category.validate_messages.create.name'), 'max' => 100]),
                ],
            ],
        ];
    }
}
