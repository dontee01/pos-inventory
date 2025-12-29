<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Driver;

use DB;
use App\Libraries\Custom;

class DriverController extends Controller
{
	protected $custom;
    public function __construct()
    {
        // $this->middleware('login');
        $this->custom = new Custom();
    }

    public function index()
    {
    	$drivers = Driver::all();
    	// print_r($result);exit;
    	return view('driver', ['drivers' => $drivers]);
    }

    public function show_add()
    {
    	return view('driver-add');
    }

    public function show_edit($id)
    {
    	
    	$driver = Driver::find($id);
    	return view('driver-edit', ['driver' => $driver]);
    }

    public function add(Request $request)
    {
    	$cust = $this->custom;
        $validate = $request->validate([
	        'd_name' => 'required',
	        'phone' => 'required|numeric',
	        'address' => 'required'
	    ]);

        $check = Driver::where('d_name', $request->d_name)
            ->first();

        if ($check)
        {
            $request->session()->flash('flash_message', 'Driver exists, choose another name');
            return redirect()->back();
        }

    	$driver = new Driver;
    	$driver->d_name = ucwords($request->d_name);
    	$driver->phone = $request->phone;
    	$driver->address = $request->address;
    	
        $driver->save();

		$request->session()->flash('flash_message_success', 'Driver Added');
	    return redirect('/drivers')->withInput($request->all());
    }

    public function edit(Request $request, $id)
    {
        $validate = $request->validate([
            'd_name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required'
        ]);
    	$driver = Driver::find($id);

        $driver->d_name = ucwords($request->d_name);
        $driver->phone = $request->phone;
        $driver->address = strtoupper($request->address);


	    $driver->save();
		$request->session()->flash('flash_message_success', 'Driver Updated');
	    return redirect('/drivers')->withInput($request->all());
    }

    public function delete(Request $request, $id)
    {
    	Driver::destroy($id);

	    // var_dump($driver);exit;
		$request->session()->flash('flash_message', 'Driver Deleted');
	    return redirect('/drivers');
    }
}
