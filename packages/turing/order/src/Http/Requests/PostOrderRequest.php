<?php

namespace Turing\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Turing\Backend\Http\Requests\BaseFormRequest;

class PostOrderRequest extends BaseFormRequest
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
            'cart_id' => 'required|string|max:32|exists:shopping_cart',
            'shipping_id' => 'required|integer|exists:shipping,shipping_id',
            'tax_id' => 'required|integer|exists:tax,tax_id',
        ];
    }
}
