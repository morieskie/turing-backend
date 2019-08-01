<?php

namespace Turing\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Turing\Backend\Http\Requests\BaseFormRequest;

class PutCustomerAddressRequest extends BaseFormRequest
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
            'address_1' => 'required|string',
            'address_2' => 'filled|string',
            'city' => 'required|string',
            'region' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
            'shipping_region_id' => 'required|integer|exists:shipping_region,shipping_region_id',
        ];
    }
}
