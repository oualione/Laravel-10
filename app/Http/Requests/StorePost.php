<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
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
            'title' => 'required|min:3|max:100',
            'content' => 'required|min:10|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Adjust allowed types and max file size as needed

        ];
    }
}
