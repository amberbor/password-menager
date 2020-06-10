<?php

namespace App\Http\Requests;

use App\Rules\StrongPassword;
use Illuminate\Foundation\Http\FormRequest;

class PasswordStorageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'platform' => 'required|string|min:2|max:190',
            'platform_url' => 'nullable|url|min:2|max:190',
            'username' => 'required|string|min:2|max:190',
            'password' => ['required', 'string', 'min:8', 'max:100', new StrongPassword()]
        ];
    }

    /**
    * Get custom attributes for validator errors.
    *
    * @return array
    */
    public function attributes()
    {
        return [
            'username' => __('username or e-mail address')
        ];
    }
}
