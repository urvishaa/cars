<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
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
            
            // 'u_type' => 'required',
            'name' => 'required',
            'username' => 'required|unique:Property,username,'.$this->route('user'),
             'gender' => 'nullable',
            'dob' => 'nullable',
            'email' => 'required|email|unique:Property,email,'.$this->route('user'),
            'password' => 'nullable', 

        ];
    }
}
