<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'friend_ids' => 'required|array|min:2',
            'friend_ids.*' => 'integer',
            'message' => 'required|string|max:500',
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'friend_ids.required' => 'Please select at least two recipients for group messaging.',
            'friend_ids.min' => 'Please select at least two recipients for group messaging.',
        ];
    }
}
