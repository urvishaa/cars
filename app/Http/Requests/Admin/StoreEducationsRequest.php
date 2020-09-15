<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationsRequest extends FormRequest
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
            'edu_type' => 'required',
            'name' => 'required',
            'logo' => 'nullable',
            'address' => 'required',
            'apply_regi' => 'required',            
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'country_name' => 'nullable',            
            'description' => 'nullable',
            'overview' => 'nullable',
            'vision' => 'nullable',
            'mission' => 'nullable',
            'philosophy' => 'nullable',
            'accreditation' => 'nullable',
            'tution_fees' => 'required',
            'tour_desc' => 'nullable',
            'info_apply' => 'nullable',
            'email' => 'required',
            'phone_number' => 'required',
            'website_url' => 'required',
            'ranking' => 'required',
            'facebook_url' => 'nullable',
            'twitter_url' => 'nullable',
            'published' => 'required',

        ];
    }
}
     
 
