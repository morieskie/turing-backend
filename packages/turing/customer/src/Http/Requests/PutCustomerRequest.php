<?php

namespace Turing\Customer\Http\Requests;

use Turing\Backend\Http\Requests\BaseFormRequest;

/**
 * Class PutCustomerRequest
 * @package Turing\Customer\Http\Requests
 */
class PutCustomerRequest extends BaseFormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'filled|string',
            'day_phone' => 'filled|string|phone:ZA,US,GB',
            'eve_phone' => 'filled|string|phone:ZA,US,GB',
            'mob_phone' => 'filled|string|phone:ZA,US,GB',
        ];
    }
}
