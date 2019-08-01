<?php

namespace Turing\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Turing\Backend\Http\Requests\BaseFormRequest;

class PostProductReviewRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'review' => 'required|string',
            'rating' => 'required|integer'
        ];
    }
}
