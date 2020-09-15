<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShowRoomAdminRequest extends FormRequest
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
            
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:administrators,email',
            'address' => 'required',
            'city' => 'required',
            'country' => 'nullable',
            'state' => 'nullable',
            'password' => 'required', 
            're_password' => 'required|same:password', 
            'phone' => 'nullable'

        ];
    }
}
