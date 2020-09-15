<?php


/*namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Validator;
use App;
use Lang;

use App\Admin;

use DB;
//for password encryption or hash protected
use Hash;
//use App\Administrator;

//for authenitcate login data
use Auth;
use Session;
//for requesting a value 
use Illuminate\Http\Request;
*/

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Usergroup;
use Lang;
use DB;
use Redirect;


class UsergroupController extends Controller
{
    
    public function userForm(Request $request, $id='')
    {
    	$title 			  = 	array('pageTitle' => Lang::get("labels.user_group"));
    	$language_id      = 	'1';
		$result 		  =		array();
		
		$reportBase		  = 	$request->reportBase;		

        
        if ($id == "") { 
            $getparentName = DB::table('usergroups')->get();
            $result['getparentName'] = $getparentName;    
        } else { 
            $getparentName = DB::table('usergroups')->get();
            $result['getparentName'] = $getparentName;    
            $userGroup = Usergroup::findOrFail($id);
            $result['edituser'] = $userGroup;
        }
        

    	return view("admin.userGroupForm",$title,compact('result'));
    }

    public function usergroupList()
    { 
    	$title = array('pageTitle' => Lang::get("labels.user_group"));
    	   
        $usergroupList = DB::table('usergroups')->get();
         
  		return view('admin.usergroupList',$title,compact('usergroupList'));

    }


    public function saveUserGroup(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.user_group"));
	        if ($request->get('id')) { 
                
                $userGroup = DB::table('usergroups')->where('id','=',$request->get('id') )->update([
                    'typeName' => $request->get('typeName'),
                    'parentGroup'=> $request->get('parentGroup'),
                ]);
                
            } else {
                $userGroup = new Usergroup([
                    'typeName' => $request->get('typeName'),
                    'parentGroup'=> $request->get('parentGroup'),
                ]);    

                $userGroup->save();
           }
        
        
      return redirect('admin/usergroupList');

    }

    public function deleteUserGroup($id)
    {

       $userGroup123 = DB::table('usergroups')->where('parentGroup','=',$id)->update([
                    'parentGroup'=> 0,
                ]);

       $userGroup = DB::table('usergroups')->where('id', $id)->delete();

       
       return redirect('admin/usergroupList');
        
    }

    public function usergroupmultidelete(Request $request)
    {
        $pubid = $request->get('ids');
        $ids=explode(',', $pubid);
        $entries = Usergroup::whereIn('id', $ids)->get();
            foreach ($entries as $entry) {
                $entry->delete();
            }
        //return  response()->json(['url'=> route('admin.usergroupList')]);        

    }

   

}
