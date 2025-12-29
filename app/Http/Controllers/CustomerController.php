<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Customer;

use DB;
use App\Libraries\Custom;

class CustomerController extends Controller
{
	protected $custom;
    public function __construct()
    {
        // $this->middleware('login');
        $this->custom = new Custom();
    }

    public function index()
    {
    	$customers = Customer::all();
    	// print_r($result);exit;
    	return view('customer', ['customers' => $customers]);
    }

    public function show_add()
    {
    	return view('customer-add');
    }

    public function show_edit($id)
    {
    	
    	$customer = Customer::find($id);
    	return view('customer-edit', ['customer' => $customer]);
    }

    public function add(Request $request)
    {
    	$cust = $this->custom;
        $validate = $request->validate([
	        'c_name' => 'required',
	        'phone' => 'required|numeric',
	        'address' => 'required'
        ]);

        $check = Customer::where('c_name', $request->c_name)
            ->first();

        if ($check)
        {
            $request->session()->flash('flash_message', 'Customer exists, choose another name');
            return redirect()->back();
        }

    	$customer = new Customer;
    	$customer->c_name = ucwords($request->c_name);
    	$customer->phone = $request->phone;
    	$customer->address = $request->address;
    	
        $customer->save();

		$request->session()->flash('flash_message_success', 'Customer Added');
	    return redirect()->back();
    }

    public function edit(Request $request, $id)
    {
        $validate = $request->validate([
	        'c_name' => 'required',
	        'phone' => 'required|numeric',
	        'address' => 'required'
        ]);

    	$customer = Customer::find($id);

        $customer->c_name = ucwords($request->c_name);
        $customer->phone = $request->phone;
        $customer->address = $request->address;


	    $customer->save();
		$request->session()->flash('flash_message_success', 'Customer Updated');
	    return redirect('/customers');
    }

    public function delete(Request $request, $id)
    {
    	Customer::destroy($id);

	    // var_dump($customer);exit;
		$request->session()->flash('flash_message', 'Customer Deleted');
	    return redirect('/customers');
    }
}
