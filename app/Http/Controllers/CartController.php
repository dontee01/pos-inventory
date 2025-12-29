<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Item;
use App\Models\PendingOrder;
use App\Models\Cart;

use DB;
use App\Libraries\Custom;

class CartController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
        // $this->middleware('login');
    }

    public function index()
    {
        $result = [];
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
                $cat_name = Category::find($cart_item->categories_id)
                ->name;
                $item_name = $cat_name.' + '.$cart_item->i_name;
                $item_arr = [
                    'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 
                    'price_total' => $order->price_total, 'cart_session' => $order->cart_session
                ];
                array_push($result, $item_arr);
            }
        }
        else
        {
            // redirect if cart session does not exist
            session()->flash('flash_message', 'Cart is empty');
            return redirect('/order');
        }

        return view('cart', ['cart_items' => $result]);
    }

    public function add(Request $request)
    {
        $cust = $this->custom;
        $validate = $request->validate([
            // 'is_rgb' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
// dd($request);

        if ($request->quantity < 1)
        {
            $request->session()->flash('flash_message', 'Quantity cannot be zero');
            return redirect()->back();
        }

        $cart = new Cart;
        $cart->store_users_id = \Session::get('id');
        // $cart->i_name = strtoupper($request->item);
        $cart->item_id = $request->item_id;
        $cart->d_name = $request->driver;
        $cart->c_name = $request->customer;
        $cart->is_rgb = $request->is_rgb;
        $cart->price_unit = $request->price;
        $cart->price_total = $request->sub_total;
        $cart->transaction_ref = $request->transaction_ref;
      
        $cart->cart_session = \Session::get('cart_session');

// var_dump($request->quantity_bottle);exit;
        if ($request->is_rgb == 1)
        {
            $cart->qty_content = $request->quantity_content;
            $cart->qty_bottle = $request->quantity_bottle;
            $cart->qty = $request->quantity;
// var_dump($cart);exit;
            $qty_content = Item::where('id', $request->item_id)
            ->value('qty_content');
            $item_check = $qty_content - $request->quantity;
            if ($item_check < 0)
            {
                $request->session()->flash('flash_message', 'Stock is too low for this transaction!!');
                return redirect()->back();
            }

            $item = Item::where('id', $request->item_id)
                ->decrement('qty_content', $request->quantity);
        }
        if ($request->is_rgb == 0)
        {
            $cart->qty = $request->quantity;

            $qty = Item::where('id', $request->item_id)
            ->value('qty');
            $item_check = $qty - $request->quantity;
            if ($item_check < 0)
            {
                $request->session()->flash('flash_message', 'Stock is too low for this transaction!!');
                return redirect()->back();
            }

            $item = Item::where('id', $request->item_id)
                ->decrement('qty', $request->quantity);
        }

        $cart->save();


        $request->session()->flash('flash_message_success', 'Item added to cart');
        return redirect()->back();
    }


    public function checkout(Request $request)
    {
        if (!session()->has('cart_session'))
        {
            // redirect if cart session does not exist
            $request->session()->flash('flash_message', 'Cart is empty');
            return redirect('/order');
        }
        DB::transaction(function() use ($request)
        {
            $cart = Cart::where('cart_session', $request->cart_session)
                ->update(['is_confirmed' => 1]);

            // $cart_order = Cart::find($id);
            $cart_orders = Cart::where('cart_session', $request->cart_session)
            ->get();
            foreach ($cart_orders as $cart_order)
            {
                $p_order_data = [
                    'store_users_id' => $cart_order->store_users_id, 'item_id' => $cart_order->item_id,
                    'transaction_ref' => $cart_order->transaction_ref, 'd_name' => $cart_order->d_name,
                    'c_name' => $cart_order->c_name, 'is_rgb' => $cart_order->is_rgb, 'qty_content' => $cart_order->qty_content,
                    'qty_bottle' => $cart_order->qty_bottle, 'qty' => $cart_order->qty, 'returned_qty' => $cart_order->returned_qty,
                    'returned_bottle' => $cart_order->returned_bottle, 'price_unit' => $cart_order->price_unit,
                    'price_total' => $cart_order->price_total
                ];

                $p_order = PendingOrder::create($p_order_data);
                
            }


        });

        $cart_items = Cart::where('cart_session', $request->cart_session)
        ->get();

        $result = [];
        $total = 0;
        $transaction_ref = '';
        foreach ($cart_items as $item)
        {
            $transaction_ref = $item->transaction_ref;
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($item->item_id);
            $cat_name = Category::find($cart_item->categories_id)
            ->name;
            $item_name = $cat_name.'  '.$cart_item->i_name;
            $item_arr = [
                'id' => $item->id, 'i_name' => $item_name, 'qty' => $item->qty, 
                'price_total' => $item->price_total, 'cart_session' => $item->cart_session
            ];
            $total += $item->price_total;
            array_push($result, $item_arr);
        }

        \Session::forget('cart_session');
        \Session::forget('transaction_ref');

        $request->session()->flash('flash_message_success', 'Ensure to print the invoice before navigating away');
        return view('print-store', ['cart_items' => $result, 'price_total' => $total, 'transaction_ref' => $transaction_ref]);

    }



    public function show_checkout($id)
    {
        $result = [];
        if (session()->has('cart_session'))
        {
            $cart_session = \Session::get('cart_session');
            $order = Cart::where('id', $id)
                ->where('is_confirmed', 0)
                ->where('deleted', 0)
                ->first();
            // foreach ($orders as $order)
            // {
                // get categoriesId and item name using itemId from cart table
                $cart_item = Item::find($order->item_id);
                $cat_name = Category::find($cart_item->categories_id)
                ->name;
                $item_name = $cat_name.' + '.$cart_item->i_name;
                $result = [
                    'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 
                    'price_total' => $order->price_total, 'cart_session' => $order->cart_session
                ];
                // array_push($result, $item_arr);
            // }
        }

        return view('checkout-order', ['cart' => $result]);
    }


    public function delete(Request $request, $id)
    {
        DB::transaction(function() use ($id){

            $cart = Cart::find($id);
            if ($cart->is_rgb == 0)
            {
                $item = Item::where('id', $cart->item_id)
                    ->increment('qty', $cart->qty);
            }

            if ($cart->is_rgb == 1)
            {
                $item = Item::where('id', $cart->item_id)
                    ->increment('qty_content', $cart->qty);
            }

            Cart::destroy($id);

        });

        // var_dump($user);exit;
        $request->session()->flash('flash_message', 'Item Removed From Cart');
        // url()->current()
        return redirect()->back();
    }
}
