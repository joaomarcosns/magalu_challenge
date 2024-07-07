<?php

namespace App\Http\Requests;

use App\Enums\NotificationChannelEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validChannels = collect(NotificationChannelEnum::all())->map(function ($value) {
            return (string) $value->name;
        })->toArray();

        return [
            'send_at' => ['required', 'date'],
            'channel' => ['required', 'string', 'in:' . implode(',', $validChannels)],
            'message' => ['required'],
            'destination' => [
                'required',
                'string',
                'max:255',
                Rule::when($this->channel === 'EMAIL', ['email']),
                Rule::when($this->channel === 'SMS', ['regex:/^\+?[1-9]\d{1,14}$/']),
                Rule::when($this->channel === 'WHATSAPP', ['regex:/^\+?[1-9]\d{1,14}$/']),
                Rule::when($this->channel === 'PUSH', [
                    'min:5',
                    function ($attribute, $value, $fail) {
                        if (preg_match('/^[a-zA-Z0-9:_-]{140,255}$/', $value)) {
                            $fail('The ' . $attribute . ' must not be a valid Firebase Cloud Messaging token.');
                        }
                    },
                ]),
            ],
        ];
    }
}
