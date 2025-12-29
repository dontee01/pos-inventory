<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;

use DB;
use App\Libraries\Custom;

class StaffController extends Controller
{
	protected $custom;
    public function __construct()
    {
        // $this->middleware('login');
        $this->custom = new Custom();
    }

    public function index()
    {
    	$users = User::all();
        $result = [];
        foreach ($users as $user)
        {
            $level = '';
            switch ($user->level) {
                case '1':
                $level = 'Admin';
                    break;
                case '2':
                $level = 'Sales';
                    break;
                case '3':
                $level = 'Store';
                    break;
                
                default:
                $level = '----';
                    break;
            }
            $user_arr = [
                'id' => $user->id, 'name' => $user->name, 'password' => $user->password, 'level' => $level
            ];
            array_push($result, $user_arr);
        }
    	// print_r($result);exit;
    	return view('staff', ['users' => $result]);
    }

    public function show_add()
    {
    	return view('staff-add');
    }

    public function show_edit($id)
    {
    	$user = User::find($id);
    	return view('staff-edit', ['user' => $user]);
    }

    public function add(Request $request)
    {
    	$cust = $this->custom;
    	$validate = $request->validate([
	        'name' => 'required',
	        'password' => 'required',
	        'level' => 'required'
	    ]);

        $check = User::where('name', $request->name)
            ->first();

        if ($check)
        {
            $request->session()->flash('flash_message', 'User exists, choose another name');
            return redirect('/users')->withInput($request->all());
        }
    	$user = new User;
    	$user->name = $request->name;
    	$user->password = $request->password;
    	$user->level = $request->level;
    	
        $user->save();

		$request->session()->flash('flash_message_success', 'User Added');
	    return redirect('/users')->withInput($request->all());
    }

    public function edit(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required',
            'password' => 'required',
            'level' => 'required'
        ]);
    	$user = User::find($id);

        $user->name = $request->name;
        $user->password = $request->password;
        $user->level = $request->level;


	    $user->save();
		$request->session()->flash('flash_message_success', 'User Updated');
	    return redirect('/users')->withInput($request->all());
    }

    public function delete(Request $request, $id)
    {
    	User::destroy($id);

	    // var_dump($user);exit;
		$request->session()->flash('flash_message', 'User Deleted');
	    return redirect('/users');
    }
}
