<?php

namespace Turing\Customer\Http\Requests;

use Turing\Backend\Http\Requests\BaseFormRequest;

/**
 * Class PostCustomerFacebookRequest
 * @package Turing\Customer\Http\Requests
 */
class PostCustomerFacebookRequest extends BaseFormRequest
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
            'access_token' => 'required|string'
        ];
    }
}
