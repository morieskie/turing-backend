<?php

namespace Turing\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Turing\Backend\Http\Requests\BaseFormRequest;

class PostCustomerLoginRequest extends BaseFormRequest
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
            //'email' => 'required|email|exists:customer,email',
            'password' => 'required|string'
        ];
    }
}
