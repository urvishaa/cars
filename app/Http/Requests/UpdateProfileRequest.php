<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            
            'u_type' => 'required',
            'name' => 'required',
            'username' => 'nullable',
            'email' => 'required',
            'dob' => 'nullable',
            'password' => 'nullable',
            'image' => 'nullable',
            'remember_token' => 'nullable',
           
        ];
    }
}