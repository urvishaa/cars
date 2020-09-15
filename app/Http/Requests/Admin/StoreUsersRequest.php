<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
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
            
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'gender' => 'nullable',
            'dob' => 'nullable',
            'email' => 'required|email|unique:users,email',
            'password' => 'required', 
            'country_id' => 'nullable',
            'citizenship' => 'nullable',
            'phone' => 'nullable'

        ];
    }
}
