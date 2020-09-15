<?php 

namespace App\Http\Controllers\Admin;

use App\ContactUs;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\Admin\ShowRoomAdminRequest;
use App\Http\Requests\Admin\updateAdminPassword;
use App\Http\Requests\Admin\updateShowRoomAdminRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Lang;
use Hash;
use Session;
use DB;

class ContactUsController extends Controller
{
    
    public function create()
    {   
        $contact = ContactUs::get();
        if(!count($contact)){
            $contact = new ContactUs;
        }
        else{
            $contact = $contact->first();
        }
        // ->first();
        // echo "<pre>";print_r($contact);exit;
        return view('admin.contact.create',compact('contact'));
    }

   

    public function save()
    {

        $request = Request::instance();
        $contactUs = $request->input('id') ? ContactUs::find($request->input('id')) : new ContactUs;
        $contactUs->description = $request->input('description');
        $contactUs->title = $request->input('title');
        $contactUs->phone = $request->input('phone');
        $contactUs->address = $request->input('address');
        $contactUs->email = $request->input('email');
        $contactUs->save();
        return redirect()->route('contact.create')->with('message', 'Contact us edit successfully');

    }

}
