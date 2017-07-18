<?php

namespace Sevenpluss\NewsCrud\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PostShowRequest
 * @package Sevenpluss\NewsCrud\Http\Requests
 */
class PostShowRequest extends FormRequest
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
            'commentPage' => 'sometimes|integer',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'commentPage' => [
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::post.validate_messages.show_comments')])
            ]
        ];
    }
}
