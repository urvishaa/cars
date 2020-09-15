<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppartmentRequest extends FormRequest
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
            'eduid' => 'required',
            'app_name' => 'required',
            'app_desc' => 'nullable',
            'rent' => 'nullable',
            'host_name' => 'nullable',
            'host_email' => 'nullable',
            'app_address' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'bed' => 'nullable',
            'guest' => 'nullable',
            'facilities' => 'nullable',
            'housing_type' => 'nullable',
            'doc_info' => 'nullable',
            'bedroom' => 'nullable',
            'bathroom' => 'nullable',
            'furnished' => 'nullable',
            'app_image' => 'nullable',
            'app_image1' => 'nullable',
            'app_image2' => 'nullable',
            'app_image3' => 'nullable',
            'app_image4' => 'nullable',
            'app_image5' => 'nullable',
            'app_image6' => 'nullable',
            'app_image7' => 'nullable',
             'published' => 'nullable',
            
        ];
    }
}
