<?php

namespace App\Http\Requests;

use App\Models\Event;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

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
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
