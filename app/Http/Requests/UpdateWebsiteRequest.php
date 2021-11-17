<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWebsiteRequest extends StoreWebsiteRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $website = $this->route('website');

        return [
                'name' => ['required', 'string', 'min:5', 'max:255', Rule::unique('websites')->ignoreModel($website)],
                'domain' => ['required', 'string', 'min:5', 'max:255', Rule::unique('websites')->ignoreModel($website)],
            ] + parent::rules();
    }
}
