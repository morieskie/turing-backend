<?php

namespace Turing\Payment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Turing\Backend\Http\Requests\BaseFormRequest;

class PostStripeChargeRequest extends BaseFormRequest
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
            'stripeToken' => 'required|string',
            'order_id' => 'required|integer|exists:orders,order_id',
            'description' => 'required|string',
            'amount' => 'required|integer',
            'currency' => 'filled|string|max:3',
        ];
    }
}
