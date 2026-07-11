<?php

namespace App\Http\Requests;

use App\Models\Event;
use App\Support\Address\BrazilianStates;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('event_edit');
    }

    public function rules()
    {
        return [
            'photo' => [
                'array',
            ],
            'name' => [
                'string',
                'required',
            ],
            'start' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'end' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'link' => [
                'string',
                'nullable',
            ],
            'pixel' => [
                'string',
                'nullable',
            ],
            'capacity' => [
                'required_if:type,0',
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'cep' => [
                'nullable',
                'string',
                'regex:/^\d{5}-?\d{3}$/',
            ],
            'state' => [
                'nullable',
                Rule::in(BrazilianStates::codes()),
            ],
            'city' => [
                'nullable',
                'string',
            ],
            'neighborhood' => [
                'nullable',
                'string',
            ],
            'street' => [
                'nullable',
                'string',
            ],
            'number' => [
                'nullable',
                'string',
            ],
        ];
    }
}
