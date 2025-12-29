<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Item;
use App\Models\Cart;

use DB;
use App\Libraries\Custom;

class OrderController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
        // $this->middleware('login');
    }

    public function index()
    {
    	$customers = Customer::all();
        $items = Item::all();
        $result = [];
        foreach ($items as $item)
        {
            $cat_name = Category::where('id', $item->categories_id)
            ->value('name');
            $item_name = $cat_name.' + '.$item->i_name;
            $item_arr = [
                'id' => $item->id, 'i_name' => $item_name
            ];
            array_push($result, $item_arr);
        }
    	// print_r($categories);exit;
        return view('order', ['items' => $result, 'customers' => $customers]);
    	// return view('order', compact('items', 'customers') );
    	// ->with('categories', $categories);
    }

    public function populate($id)
    {
        $cust = $this->custom;
        $customers = Customer::all();
        $drivers = Driver::all();
    	$item_details = Item::find($id);
        if (empty($item_details))
        {
            return redirect('/order');
        }
        $category = Category::find($item_details->categories_id)->name;
        $items = Item::all();
        $result = [];
        $result_cart = [];
        $stock_low = 0;
        $stock_val = 0;

        if (session()->has('cart_session'))
        {
            $cart_session = \Session::get('cart_session');
            $orders = Cart::where('cart_session', $cart_session)
                ->where('is_confirmed', 0)
                ->where('deleted', 0)
                ->get();
            foreach ($orders as $order)
            {
                // get categoriesId and item name using itemId from cart table
                $cart_item = Item::find($order->item_id);
                    // print_r($cart_item);exit;
                $cat_name = Category::where('id', $cart_item->categories_id)
                ->value('name');
                $item_name = $cat_name.' + '.$cart_item->i_name;
                $item_arr = [
                    'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 
                    'price_total' => $order->price_total, 'cart_session' => $order->cart_session
                ];
                array_push($result_cart, $item_arr);
            }
        }
        
        if (! session()->has('cart_session'))
        {
            \Session::put('cart_session', time());
        }

        if (! session()->has('transaction_ref'))
        {
            $token_session = $cust->generate_session('test@random.pos', $cust->time_now());
            \Session::put('transaction_ref', $token_session);
        }

        foreach ($items as $item)
        {
            $cat_name = Category::where('id', $item->categories_id)
            ->value('name');
            $item_name = $cat_name.' + '.$item->i_name;
            $item_arr = [
                'id' => $item->id, 'i_name' => $item_name
            ];
            array_push($result, $item_arr);
        }


        if (!$item_details)
        {
            session()->flash('flash_message', 'No data to display');
            return view('order', ['items' => $result, 'details' => [], 
                'customers' => $customers, 'drivers' => $drivers, 'cart_items' => []]);
        }

        // check if stock is low
        if ($item_details->is_rgb == 0)
        {
            if ($item_details->qty < 10)
            {
                $stock_low = 1;
                $stock_val = $item_details->qty;
            }
        }
        if ($item_details->is_rgb == 1)
        {
            if ($item_details->qty_content < 10)
            {
                $stock_low = 1;
                $stock_val = $item_details->qty_content;
            }
        }
        // dd($item_details);

        if ($stock_low == 1)
        {
            session()->flash('flash_message', '('.$category.'+'.$item_details->i_name.') Stock is too low, Purchase more items');
        }
        return view('order-populate', ['items' => $result, 'details' => $item_details, 'category' => $category,
            'customers' => $customers, 'drivers' => $drivers, 'cart_items' => $result_cart]);
    }
}
