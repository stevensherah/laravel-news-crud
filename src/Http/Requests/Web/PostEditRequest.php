<?php

namespace Sevenpluss\NewsCrud\Http\Requests\Web;

/**
 * Class PostEditRequest
 * @package Sevenpluss\NewsCrud\Http\Requests\Web
 */
class PostEditRequest extends PostCreateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), ['id' => 'required|integer']);
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'id' => [
                'required' => trans('validation.required',
                    ['attribute' => trans('news::post.validate_messages.edit.id')]),
                'integer' => trans('validation.integer',
                    ['attribute' => trans('news::post.validate_messages.edit.id')]),
            ]
        ]);
    }
}
