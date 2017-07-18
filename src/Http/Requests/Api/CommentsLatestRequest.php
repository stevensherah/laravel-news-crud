<?php

namespace Sevenpluss\NewsCrud\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CommentsLatestRequest
 * @package Sevenpluss\NewsCrud\Http\Requests\Api
 */
class CommentsLatestRequest extends FormRequest
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
            'limit' => 'required|integer',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'limit' => [
                'required' => trans('validation.required',
                    ['attribute' => trans('news::comments.validate_messages.latest.limit')]),
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::comments.validate_messages.latest.limit')]),
            ],
        ];
    }
}
