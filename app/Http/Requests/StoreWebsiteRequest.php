<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWebsiteRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:5', 'max:255', Rule::unique('websites')],
            'domain' => ['required', 'string', 'min:5', 'max:255', Rule::unique('websites')],
            'description' => 'required|min:10',
            'onboard_message' => 'required|min:10',
            'farewell_message' => 'required|min:10',
        ];
    }
}
