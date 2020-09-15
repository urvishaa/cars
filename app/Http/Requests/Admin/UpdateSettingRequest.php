<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'email' => 'nullable',
            'from_email' => 'nullable',
            'from_name' => 'nullable',
            'website' => 'nullable',
            'currency' => 'nullable',  
            'newsletter' => 'nullable',
            'address' => 'nullable',
            'phone' => 'nullable',
            'min_rate' => 'nullable',
            'max_rate' => 'nullable',
             'facebook_url' => 'nullable',  
            'instagram_url' => 'nullable',
            'twitter_url' => 'nullable',
            'youtube_url' => 'nullable',
            'copyright' => 'nullable',
             'instagram_link1' => 'nullable',
            'instagram_link2' => 'nullable',
            'instagram_link3' => 'nullable',
            'instagram_link4' => 'nullable',
        ];
    }
}