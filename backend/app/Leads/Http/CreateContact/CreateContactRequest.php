<?php

declare(strict_types = 1);

namespace App\Leads\Http\CreateContact;

use Illuminate\Foundation\Http\FormRequest;

final class CreateContactRequest extends FormRequest
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
     * @return array<string, array<mixed>|\Illuminate\Contracts\Validation\ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'phone' => 'required',
            'comment' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Необходимо заполнить все обязательные поля.',
            'comment.required' => 'Необходимо заполнить все обязательные поля.',
            'phone.regex' => 'Необходимо ввести телефон в нужном формате.',
        ];
    }
}
