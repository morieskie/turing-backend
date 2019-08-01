<?php

namespace Turing\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Turing\Backend\Http\Requests\BaseFormRequest;

class PutCustomerCreditCardRequest extends BaseFormRequest
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
            'credit_card' => 'required|max:16|ccn'
        ];
    }
}
