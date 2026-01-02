<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Driver;
use App\Models\Item;
use App\Models\CartPurchase;
use App\Models\PendingOrder;
use App\Models\PurchaseLog;

use DB;
use App\Libraries\Custom;

class PurchaseController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
        // $this->middleware('login');
    }

    public function index()
    {
        $suppliers = Supplier::all();
        $items = Item::all();
        $result = [];
        $result_cart = [];

        if (\Session::has('purchase_cart_session'))
        {
            $cart_session = \Session::get('purchase_cart_session');
            $orders = CartPurchase::where('cart_session', $cart_session)
                ->where('is_confirmed', 0)
                ->where('deleted', 0)
                ->get();
            foreach ($orders as $order)
            {
                // get categoriesId and item name using itemId from cart table
                $cart_item = Item::find($order->item_id);
                    // print_r($cart_item);exit;
                $cat_name = Category::find($cart_item->categories_id)
                ->name;
                $item_name = $cat_name.' + '.$cart_item->i_name;
                $item_arr = [
                    'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 
                    'price_total' => $order->price_total, 'cart_session' => $order->cart_session
                ];
                array_push($result_cart, $item_arr);
            }
        }
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
        return view('purchase', ['items' => $result, 'suppliers' => $suppliers, 'details' => [], 'cart_items' => $result_cart]);
    }



    public function populate($id)
    {
        $cust = $this->custom;
        $suppliers = Supplier::all();
        // $drivers = Driver::all();
        $item_details = Item::find($id);
        if (empty($item_details))
        {
            return redirect('/order');
        }
        $category = Category::find($item_details->categories_id)->name;
        $items = Item::all();
        $result = [];
        $result_cart = [];
        // var_dump(session()->get('purchase_cart_session'));exit;

        // populate cart array if sales cart exists
        if (\Session::has('purchase_cart_session'))
        {
            $cart_session = \Session::get('purchase_cart_session');
            $orders = CartPurchase::where('cart_session', $cart_session)
                ->where('is_confirmed', 0)
                ->where('deleted', 0)
                ->get();
            foreach ($orders as $order)
            {
                // get categoriesId and item name using itemId from cart table
                $cart_item = Item::find($order->item_id);
                    // print_r($cart_item);exit;
                $cat_name = Category::find($cart_item->categories_id)
                ->name;
                $item_name = $cat_name.' + '.$cart_item->i_name;
                $item_arr = [
                    'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 
                    'price_total' => $order->price_total, 'cart_session' => $order->cart_session
                ];
                array_push($result_cart, $item_arr);
            }
        }
        
        if (! session()->has('purchase_cart_session'))
        {
            \Session::put('purchase_cart_session', time());
        }

        if (! session()->has('transaction_ref'))
        {
            $token_session = $cust->generate_session('test@random.pos', $cust->time_now());
            \Session::put('transaction_ref', $token_session);
        }

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
        // dd($item_details);

        return view('purchase', ['items' => $result, 'details' => $item_details, 'category' => $category, 
            'suppliers' => $suppliers, 'cart_items' => $result_cart]);
    }



    public function cart_add(Request $request)
    {
        $cust = $this->custom;
        
        $validate = $request->validate([
            // 'is_rgb' => 'required',
            'quantity' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'price' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $is_rebate = $request->is_discount;
        $quantity_rebate = $request->quantity_rebate;

        $cart = new CartPurchase;
        $cart->store_users_id = \Session::get('id');
        $cart->i_name = strtoupper($request->item_name);
        $cart->item_id = $request->item_id;
        $cart->s_name = $request->supplier;
        if ($request->is_rgb == 1) {
            $cart->no_exchange = $request->purchase_type;
        }
        $cart->is_rgb = $request->is_rgb;
        $cart->cost_price = $request->cost_price;
        $cart->price_unit = $request->price;
        $cart->price_total = $request->sub_total;
        $cart->transaction_ref = $request->transaction_ref;
        $cart->amount_paid = $request->amount;

        // check if rebate checkbox is checked or not
        if (empty($is_rebate))
        {
            $cart->is_rebate = 0;
            $cart->qty_rebate = 0;
            $quantity_rebate = 0;
        }
        else if (!empty($is_rebate))
        {
            if (empty($quantity_rebate))
            {
                $request->session()->flash('flash_message', 'Rebate field is required');
                return redirect()->back();
            }
            if (!is_numeric($quantity_rebate))
            {
                $request->session()->flash('flash_message', 'Rebate field is invalid, number expected');
                return redirect()->back();
            }
            $cart->is_rebate = 1;
            $cart->qty_rebate = $quantity_rebate;
        }
      
        $cart->cart_session = \Session::get('purchase_cart_session');
        

        DB::transaction(function() use ($request, $cart, $is_rebate, $quantity_rebate){
            $item_prc = Item::where('id', $request->item_id)
            ->first();

            if ($request->is_rgb == 1 && $request->purchase_type == 0)
            {
                // no-exchange<==>0

                // add up rebate (rebate value will be zero if no rebate on product)
                $quantity = $quantity_rebate + $request->quantity;
                // $qty_content = $item->qty_content + $request->quantity_content;
                $item = Item::where('id', $request->item_id)
                ->increment('qty_content', $quantity);
            }
            else if ($request->is_rgb == 1 && $request->purchase_type == 1)
            {
                // exchange-bottle<==>1
                $qty_content = $item_prc->qty_content + $request->quantity + $quantity_rebate;
                $qty_bottle = $item_prc->qty_bottle - $request->quantity - $quantity_rebate;

                if ($qty_bottle < 0)
                {
                    $request->session()->flash('flash_message', 'You need to purchase more empty bottles to perform this task');
                    return redirect('/purchase');
                }

                // add up rebate (rebate value will be zero if no rebate on product)
                $quantity = $quantity_rebate + $request->quantity;

                // increase value of bottles with content
                $item = Item::where('id', $request->item_id)
                ->increment('qty_content', $quantity);

                // decrement empty bottle value
                $item = Item::where('id', $request->item_id)
                ->decrement('qty_bottle', $quantity);
            }
            else if ($request->is_rgb == 0)
            {
                // add up rebate (rebate value will be zero if no rebate on product)
                $quantity = $quantity_rebate + $request->quantity;
                $item = Item::where('id', $request->item_id)
                ->increment('qty', $quantity);
            }
            $cart->qty = $request->quantity;
            $cart->save();


        });


        $request->session()->flash('flash_message_success', 'Item added to cart');
        return redirect()->back();
    }



    public function bottle_add(Request $request)
    {
        $cust = $this->custom;

        $validate = $request->validate([
            // 'is_rgb' => 'required',
            'quantity' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $item = Item::findOrFail($request->item_id);
        $cat_name = Category::find($item->categories_id)
            ->name;
        $item_name = $cat_name.' + '.$item->i_name;

        $cart = new PurchaseLog;
        // $cart->store_users_id = \Session::get('id');
        // $cart->i_name = strtoupper($request->item);
        $cart->i_name = strtoupper($item_name);
        $cart->item_id = $request->item_id;
        $cart->s_name = $request->supplier;
        // $cart->no_exchange = $request->purchase_type;
        $cart->is_bottle = 1;
        $cart->is_rgb = 1;
        $cart->cost_price = $request->cost_price;
        $cart->price_unit = $request->price;
        $cart->price_total = round($request->sub_total, 2);
        $cart->amount_paid = round($request->amount_paid, 2);
        $cart->transaction_ref = $request->transaction_ref;
      
        // $cart->cart_session = \Session::get('purchase_cart_session');
        

        DB::transaction(function() use ($request, $cart){

                // no-exchange<==>0
                // $qty_content = $item->qty_content + $request->quantity_content;
            $item = Item::where('id', $request->item_id)
            ->increment('qty_bottle', $request->quantity);

            $cart->qty = $request->quantity;
            $cart->save();

        });

        \Session::forget('transaction_ref');

        $request->session()->flash('flash_message_success', 'Transaction successful');
        return redirect()->back();
    }

    public function bottle_show()
    {
        $cust = $this->custom;

        $suppliers = Supplier::all();
        $items = Item::where('is_rgb', 1)
            ->get();
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
        return view('purchase-bottle', ['items' => $result, 'suppliers' => $suppliers, 'details' => [] ]);
    }


    public function cart_show()
    {
        $result = [];
        if (session()->has('purchase_cart_session'))
        {
            $cart_session = \Session::get('purchase_cart_session');
            $orders = CartPurchase::where('cart_session', $cart_session)
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
                    'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 'qty_rebate' => $order->qty_rebate, 'amount_paid' => $order->amount_paid, 
                    'price_total' => $order->price_total, 'cart_session' => $order->cart_session
                ];
                array_push($result, $item_arr);
            }
        }
        else
        {
            // redirect if cart session does not exist
            session()->flash('flash_message', 'Cart is empty');
            return redirect('/purchase');
        }

        return view('purchase-cart', ['cart_items' => $result]);
    }



    public function cart_checkout(Request $request)
    {
        $transaction_ref = $request->transaction_ref;

        // $orders = Cart_purchase::where('transaction_ref', $transaction_ref)
        //         ->get();
        //         var_dump($transaction_ref);
        //         print_r($orders);exit;
        if (!session()->has('purchase_cart_session'))
        {
            // redirect if cart session does not exist
            $request->session()->flash('flash_message', 'Cart is empty');
            return redirect('/purchase');
        }
        DB::transaction(function() use ($request)
        {

            // $cart_order = Cart::find($id);
            $cart_orders = CartPurchase::where('cart_session', $request->purchase_cart_session)
            ->where('is_confirmed', 0)
            ->get();
            foreach ($cart_orders as $cart_order)
            {
                // print_r($cart_order->item_id);exit;
                $p_order_data = [
                    'item_id' => $cart_order->item_id,
                    'transaction_ref' => $cart_order->transaction_ref, 's_name' => $cart_order->s_name,
                    'i_name' => $cart_order->i_name, 'is_rgb' => $cart_order->is_rgb, 'is_bottle' => $cart_order->is_bottle,
                    'qty_bottle' => $cart_order->qty_bottle, 'qty' => $cart_order->qty, 'no_exchange' => $cart_order->no_exchange, 'qty_rebate' => $cart_order->qty_rebate, 'amount_paid' => $cart_order->amount_paid, 'is_rebate' => $cart_order->is_rebate,
                    'price_unit' => $cart_order->price_unit, 'cost_price' => $cart_order->cost_price,
                    'price_total' => $cart_order->price_total, 'is_confirmed' => 1
                ];
// var_dump($p_order_data);exit;
                $p_order = PurchaseLog::create($p_order_data);

                // update item with current purchase cost price and unit selling price
                $item = Item::findOrFail($cart_order->item_id);
                $item->cost_price = $cart_order->price_unit;
                $item->price_unit = $cart_order->price_unit;
                
                $item->save();

            }
            $cart = CartPurchase::where('cart_session', $request->purchase_cart_session)
                ->update(['is_confirmed' => 1]);


        });

        // $orders = Purchase_log::groupBy('transaction_ref')
        $orders = CartPurchase::where('transaction_ref', $transaction_ref)
                ->get();
        $result = [];
        $total = 0;
        foreach ($orders as $order)
        {
            $total += $order->price_total;
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->name;
            $item_name = $cat_name.'  '.$cart_item->i_name;
            $item_arr = [
                'id' => $order->id, 'i_name' => $item_name, 's_name' => $order->s_name, 'qty' => $order->qty, 
                'price_total' => $order->price_total, 'transaction_ref' => $order->transaction_ref, 'cost_price' => $order->cost_price
            ];
            array_push($result, $item_arr);
        }



        \Session::forget('purchase_cart_session');
        \Session::forget('transaction_ref');
        $request->session()->flash('flash_message_success', 'Transaction successful');
        return redirect('/purchase');
        // return view('print-purchase', ['cart_items' => $result, 'price_total' => number_format($total, 2), 'transaction_ref' => $transaction_ref]);
        // return view('purchase', ['pending_orders' => $result]);

    }




    public function cart_delete(Request $request, $id)
    {
        DB::transaction(function() use ($id){

            $cart = CartPurchase::find($id);
            $quantity_rebate = 0;

            if ($cart->is_rebate == 1)
            {
                $quantity_rebate = $cart->qty_rebate;
            }

            if ($cart->is_rgb == 0)
            {
                // add up rebate (rebate value will be zero if no rebate on product)
                $quantity = $quantity_rebate + $cart->qty;
                $item = Item::where('id', $cart->item_id)
                    ->decrement('qty', $quantity);
            }

            if ($cart->is_rgb == 1 && $cart->no_exchange == 1 )
            {
                // add up rebate (rebate value will be zero if no rebate on product)
                $quantity = $quantity_rebate + $cart->qty;

                $item = Item::where('id', $cart->item_id)
                ->decrement('qty_content', $quantity);

                $item = Item::where('id', $cart->item_id)
                ->increment('qty_bottle', $quantity);
            }

            if ($cart->is_rgb == 1 && $cart->no_exchange == 0 )
            {
                // add up rebate (rebate value will be zero if no rebate on product)
                $quantity = $quantity_rebate + $cart->qty;

                $item = Item::where('id', $cart->item_id)
                    ->decrement('qty_content', $quantity);
            }

            CartPurchase::destroy($id);

        });

        // var_dump($user);exit;
        $request->session()->flash('flash_message', 'Item Removed From Cart');
        // url()->current()
        return redirect()->back();
    }

}
