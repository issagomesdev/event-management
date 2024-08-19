<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'surname' => [
                'string',
                'required',
            ],
            'phonenumber' => [
                'string',
                'required',
                'unique:customers',
            ],
            // 'email' => [
            //     'required',
            //     'unique:customers',
            // ],
            'birthdate' => [
                'date_format:' . config('panel.date_format')
            ],
        ];
    }
}
