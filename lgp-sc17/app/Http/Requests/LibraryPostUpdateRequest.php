<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LibraryPostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */


    public function authorize(): bool
    {
        return Auth::user()->is_admin;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['string', 'nullable'],
            'body_content' => ['required', 'string'],
            'public' => ['boolean']
        ];
    }
}
