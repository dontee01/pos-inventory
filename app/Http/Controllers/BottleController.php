<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Driver;
use App\Models\User;
use App\Models\Item;
use App\Models\BottleDebtor;

use DB;
use App\Libraries\Custom;

class BottleController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
        // $this->middleware('login');
    }
    
    public function bottle_show()
    {
        $cust = $this->custom;
        
        $suppliers = Supplier::all();
        $customers = Customer::all();
        $drivers = Driver::all();
        $users = User::all();
        $items = Item::where('is_rgb', 1)->get();
        $result = [];
        $result_cart = [];

        foreach ($items as $item)
        {
            $cat_name = Category::find($item->categories_id)
            ->name;
            $item_name = $cat_name.' + '.$item->i_name;
            $item_arr = [
                'id' => $item->id, 'i_name' => $item_name
            ];
            array_push($result, $item_arr);
        }

        $token_session = $cust->generate_session('test@random.pos', $cust->time_now());
        \Session::put('transaction_ref', $token_session);
        return view('bottle-log', ['items' => $result, 'suppliers' => $suppliers, 'customers' => $customers, 'drivers' => $drivers, 'users' => $users, 'details' => [] ]);
    }


    public function bottle_log(Request $request)
    {
        $cust = $this->custom;
        
        $validate = $request->validate([
            // 'is_rgb' => 'required',
            'quantity' => 'required|numeric',
            'amount_paid' => 'required|numeric',
        ]);
        
        $item =  Item::findOrFail($request->item_id);
        $cat_name = Category::find($item->categories_id)
            ->name;
        $item_name = $cat_name.' + '.$item->i_name;

        $cart = new BottleDebtor;
        $cart->users_id = \Session::get('id');
        $cart->i_name = strtoupper($item_name);
        
        $cart->item_id = $request->item_id;
        // also handles expired products
        $cart->error_type = $request->type;

        if ($request->is_rgb_staff)
        {
            $cart->d_name = $request->staff;
        }
        else
        {
            $cart->d_name = $request->driver;
        }
        
        $cart->comment = $request->comment;
        $cart->is_rgb_content = $request->is_rgb_content;
        // $cart->price_unit = $request->price;
        $cart->amount_paid = round($request->amount_paid, 2);
        $cart->transaction_ref = $request->transaction_ref;
      
        // $cart->cart_session = \Session::get('purchase_cart_session');
        
        DB::transaction(function() use ($request, $cart, $cust){
            // divide quantity by 24
        	$quantity = $cust->get_empty_bottle_val($request->quantity);
                // no-exchange<==>0
                // $qty_content = $item->qty_content + $request->quantity_content;
            // bottles broken with liquid
        	if (!empty($request->is_rgb_content) )
        	{
	            $item = Item::where('id', $request->item_id)
	            ->decrement('qty_content', $quantity);
        	}
        	else if (empty($request->is_rgb_content))
        	{
                // empty bottles broken
	            $item = Item::where('id', $request->item_id)
	            ->decrement('qty_bottle', $quantity);
        	}

            $cart->qty_bottle = $request->quantity;
            $cart->save();

        });

        \Session::forget('transaction_ref');

        $request->session()->flash('flash_message_success', 'Transaction successful');
        return redirect()->back();
    }

}
