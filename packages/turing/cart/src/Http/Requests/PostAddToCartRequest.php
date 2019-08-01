<?php

namespace Turing\Cart\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Turing\Backend\Http\Requests\BaseFormRequest;

class PostAddToCartRequest extends BaseFormRequest
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
            'cart_id' => 'required|string|max:32',
            'product_id' => 'required|integer|exists:product,product_id',
            'attributes' => 'required|string|max:1000',
        ];
    }
}
