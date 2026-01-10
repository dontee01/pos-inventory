<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Driver;
use App\Models\Item;
use App\Models\Cart;
use App\Models\PendingOrder;
use App\Models\SalesLog;
use App\Models\BottleSale;

use DB;
use App\Libraries\Custom;

class SalesController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
        // $this->middleware('login');
    }

    public function index()
    {
        $orders = PendingOrder::where('is_confirmed', 1)
                // ->groupBy('transaction_ref')
                ->get();
        // $orders = PendingOrder::selectRaw('MAX(id) as id, transaction_ref')
        //     ->where('is_confirmed', 1)
        //     ->groupBy('transaction_ref')
        //     ->get();
        $result = [];
        foreach ($orders as $order)
        {
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // var_dump(session()->get('sales_cart_session'));exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->name;
            $item_name = $cat_name.'  '.$cart_item->i_name;
            $item_arr = [
                'id' => $order->id, 'i_name' => $item_name, 'd_name' => $order->d_name, 'qty' => $order->qty, 
                'price_total' => $order->price_total, 'transaction_ref' => $order->transaction_ref
            ];
            array_push($result, $item_arr);
        }

    	
        return view('pending-sales', ['pending_orders' => $result]);
    }

    public function show_order($transaction_ref)
    {
        $cust = $this->custom;
        $orders = PendingOrder::where('transaction_ref', $transaction_ref)
                ->where('is_confirmed', 1)
                ->get();
        $result = [];
        $total = 0;
        $d_name = '';
        foreach ($orders as $order)
        {
            $d_name = $order->d_name;
            $returned_qty = $order->returned_qty;
            $returned_bottle = $order->returned_bottle;
            if (empty($returned_qty))
            {
                $returned_qty = 0;
            }
            if (empty($returned_bottle))
            {
                $returned_bottle = 0;
            }

            if ($order->is_rgb == 0)
            {
                $quantity = $order->qty - $returned_qty;
            }
            if ($order->is_rgb == 1)
            {
                $quantity = $order->qty - $returned_qty;
            }
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->name;
            $item_name = $cat_name.'  '.$cart_item->i_name;

            $item_id = $order->item_id;
            $item_arr = [
                'id' => $order->id, 'item_id' => $item_id, 'i_name' => $item_name, 'qty' => $quantity, 'd_name' => $order->d_name,
                'price_total' => $order->price_total, 'is_rgb' => $order->is_rgb, 'transaction_ref' => $order->transaction_ref
            ];
            $total += $order->price_total;
            array_push($result, $item_arr);
        }

        if (count($result) != 0)
        {
            $print_session = $cust->generate_session('test@random.pos', $cust->time_now());
            \Session::put('print_session', $print_session);
        }

        // var_dump(number_format($total, 2));exit;
        return view('sales-process', ['orders' => $result, 'price_total' => $total, 'transaction_ref' => $transaction_ref, 'd_name' => $d_name]);
    }


    public function checkout(Request $request, $transaction_ref)
    {
        $validate = $request->validate([
            'amount' => 'required|numeric'
        ]);
        if (! session()->has('print_session'))
        {
            // redirect if print session does not exist
            $request->session()->flash('flash_message', 'No order to process');
            return redirect('/sales');
        }

        if ($request->payment_method =='cash_bank_transfer')
        {
            $validate = $request->validate([
                'cash' => 'required|numeric',
                'bank' => 'required|numeric'
            ]);
            // if ($validate->fails())
            // {
            //     $request->session()->flash('flash_message', 'Payment details are invalid');
            //     return redirect()->backWithErrors($validate)->withInput();
            // }
        }
        
        $orders = PendingOrder::where('transaction_ref', $transaction_ref)
                ->where('is_confirmed', 1)
                ->get();
        $result = [];
        $total = 0;
        $d_name = '';
        $difference = 0;
        $is_discount = $request->discount;
        $name = ucfirst($request->name);
        $amount_paid = $request->amount;
        // generate receipt
        $receipt = $this->generateReceipt();
        foreach ($orders as $order)
        {
            $d_name = $order->d_name;
            $returned_qty = $order->returned_qty;
            $returned_bottle = $order->returned_bottle;
            if (empty($returned_qty))
            {
                $returned_qty = 0;
            }
            if (empty($returned_bottle))
            {
                $returned_bottle = 0;
            }

            if ($order->is_rgb == 0)
            {
                $quantity = $order->qty - $returned_qty;
            }
            if ($order->is_rgb == 1)
            {
                $quantity = $order->qty - $returned_qty;
            }
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->name;
            $item_name = $cat_name.'  '.$cart_item->i_name;
            
            $item_id = $order->item_id;
            $item_arr = [
                'id' => $order->id, 'i_name' => $item_name, 'qty' => $quantity, 'd_name' => $order->d_name,
                'price_total' => number_format($order->price_total, 2), 'is_rgb' => $order->is_rgb, 'transaction_ref' => $order->transaction_ref
            ];
            $total += $order->price_total;
            array_push($result, $item_arr);
        }
        // check for discount or debtor
        if (!empty($is_discount))
        {
            $difference = $total - $amount_paid;
        }

        if (empty($is_discount))
        {
            $is_discount = 0;
        }

        DB::transaction(function() use ($transaction_ref, $total, $amount_paid, $difference, $is_discount, $receipt, $request)
        {
            $sales = new SalesLog;
            $sales->users_id = $request->session()->get('id');
            $sales->d_name = $request->d_name;
            $sales->transaction_ref = $transaction_ref;
            $sales->total = $total;
            $sales->amount_paid = $amount_paid;
            $sales->payment_method = $request->payment_method;
            $sales->receipt = $receipt;
            $sales->name = ucfirst($request->name);
            $sales->is_debtor_discount = $is_discount;
            $sales->difference = $difference;

            // if ($request->payment_method =='cash_bank_transfer')
            // {
                $sales->amount_paid_cash = $request->cash ?? 0;
                $sales->amount_paid_bank = $request->bank ?? 0;
            // }

            $sales->save();


            $data = [
                    'is_confirmed' => 2
                ];
            // update pending order table
            $orders_upd = PendingOrder::where('transaction_ref', $transaction_ref)
                ->where('is_confirmed', 1)
                ->update($data);

        });

        // remove print session to avoid duplicate sales table update on page reload
        session()->forget('print_session');

        $request->session()->flash('flash_message_success', 'Sales Processed. Ensure to print this receipt before navigating away');
        // return view('print-sales', ['cart_items' => $result, 'price_total' => number_format($total, 2), 'transaction_ref' => $transaction_ref, 'receipt' => $receipt, 'r_name' => $name, 'amount_paid' => number_format($amount_paid, 2), 'is_discount' => $is_discount, 'difference' => number_format($difference, 2)]);
        return redirect('/sales/receipt/'.$transaction_ref);
    }

    public function receipt(Request $request, $ref)
    {
        // if (! session()->has('print_session'))
        // {
        //     // redirect if print session does not exist
        //     $request->session()->flash('flash_message', 'No order to process');
        //     return redirect('/sales');
        // }
        
        $sales = SalesLog::where('transaction_ref', $ref)
            ->orWhere('receipt', $ref)
            ->first();

        if (!$sales)
        {
            $request->session()->flash('flash_message', 'No transaction found');
            return redirect('/sales');
        }
        
        // $d_name = $sales->d_name;
        $difference = $sales->difference;
        $is_discount = $sales->is_debtor_discount;
        $amount_paid = $sales->amount_paid;
        $name = $sales->name;
        $total = $sales->total;
        $receipt = $sales->receipt;
        $transaction_ref = $sales->transaction_ref;

        $orders = PendingOrder::where('transaction_ref', $transaction_ref)
            ->where('is_confirmed', 2)
            ->get();
        if ($orders->isEmpty())
        {
            $request->session()->flash('flash_message', 'An error occurred with this transaction. Contact support.');
            return redirect('/sales');
        }
        $result = [];

        foreach ($orders as $order)
        {
            $d_name = $order->d_name;
            $returned_qty = $order->returned_qty;
            $returned_bottle = $order->returned_bottle;
            if (empty($returned_qty))
            {
                $returned_qty = 0;
            }
            if (empty($returned_bottle))
            {
                $returned_bottle = 0;
            }

            if ($order->is_rgb == 0)
            {
                $quantity = $order->qty - $returned_qty;
            }
            if ($order->is_rgb == 1)
            {
                $quantity = $order->qty - $returned_qty;
            }
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->name;
            $item_name = $cat_name.'  '.$cart_item->i_name;
            
            $item_id = $order->item_id;
            $item_arr = [
                'id' => $order->id, 'i_name' => $item_name, 'qty' => $quantity, 'd_name' => $order->d_name,
                'price_total' => number_format($order->price_total, 2), 'is_rgb' => $order->is_rgb, 'transaction_ref' => $order->transaction_ref
            ];
            // $total += $order->price_total;
            array_push($result, $item_arr);
        }

        // remove print session to avoid duplicate sales table update on page reload
        // session()->forget('print_session');

        // var_dump(number_format($amount_paid, 2));exit;
        $request->session()->flash('flash_message_success', 'Sales Processed. Ensure to print this receipt before navigating away');
        return view('print-sales', ['cart_items' => $result, 'price_total' => number_format($total, 2), 'transaction_ref' => $transaction_ref, 'receipt' => $receipt, 'r_name' => $name, 'amount_paid' => number_format($amount_paid, 2), 'is_discount' => $is_discount, 'difference' => number_format($difference, 2)]);
    }

    // ///////////////////INDIVIDUAL SALES/////////////////////


    public function individual()
    {
        $customers = Customer::all();
        $items = Item::all();
        $result = [];
        $result_cart = [];

        if (\Session::has('sales_cart_session'))
        {
            $cart_session = \Session::get('sales_cart_session');
            $orders = Cart::where('cart_session', $cart_session)
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
        return view('sales-direct', ['items' => $result, 'customers' => $customers, 'details' => [], 'cart_items' => $result_cart]);
    }


    public function populate($id)
    {
        $cust = $this->custom;
        $customers = Customer::all();
        // $drivers = Driver::all();
        $item_details = Item::find($id);
        $category = Category::find($item_details->categories_id)->name;
        $items = Item::all();
        $result = [];
        $result_cart = [];
        // var_dump(session()->get('sales_cart_session'));exit;

        // populate cart array if sales cart exists
        if (\Session::has('sales_cart_session'))
        {
            $cart_session = \Session::get('sales_cart_session');
            $orders = Cart::where('cart_session', $cart_session)
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
        
        if (! session()->has('sales_cart_session'))
        {
            \Session::put('sales_cart_session', time());
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

        return view('sales-direct', ['items' => $result, 'details' => $item_details, 'category' => $category,
            'customers' => $customers, 'cart_items' => $result_cart]);
    }


    public function cart_show(Request $request)
    {
        $result = [];
        if (session()->has('sales_cart_session'))
        {
            $cart_session = \Session::get('sales_cart_session');
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
            $request->session()->flash('flash_message', 'Cart is empty');
            // return redirect('/order');
            // experimental, may return to [redirect('/order')]
            return redirect()->back();
        }

        return view('sales-cart', ['cart_items' => $result]);
    }


    public function cart_add(Request $request)
    {
        $cust = $this->custom;
        $validate = $request->validate([
            // 'is_rgb' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $cart = new Cart;
        $cart->sales_users_id = \Session::get('id');
        $cart->i_name = strtoupper($request->item_name);
        $cart->item_id = $request->item_id;
        $cart->d_name = $request->driver;
        $cart->c_name = $request->customer;
        $cart->is_rgb = $request->is_rgb;
        $cart->price_unit = $request->price;
        $cart->price_total = $request->sub_total;
        $cart->transaction_ref = $request->transaction_ref;
      
        $cart->cart_session = \Session::get('sales_cart_session');

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
            if ($item_check < 1)
            {
                $request->session()->flash('flash_message', 'Stock is too low for this transaction!!');
                return redirect()->back();
            }

            $item = Item::where('id', $request->item_id)
                ->decrement('qty_content', $request->quantity);

            // increment empty bottles since this is a direct sales operation
            $item = Item::where('id', $request->item_id)
                ->increment('qty_bottle', $request->quantity);
        }
        if ($request->is_rgb == 0)
        {
            $cart->qty = $request->quantity;

            $qty = Item::where('id', $request->item_id)
            ->value('qty');
            $item_check = $qty - $request->quantity;
            if ($item_check < 1)
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



    public function cart_checkout(Request $request)
    {
        if (!session()->has('sales_cart_session'))
        {
            // redirect if cart session does not exist
            $request->session()->flash('flash_message', 'Cart is empty');
            return redirect('/sales');
        }
        DB::transaction(function() use ($request)
        {
            $cart = Cart::where('cart_session', $request->sales_cart_session)
                ->update(['is_confirmed' => 1]);

            // $cart_order = Cart::find($id);
            $cart_orders = Cart::where('cart_session', $request->sales_cart_session)
            ->get();
            foreach ($cart_orders as $cart_order)
            {
                $p_order_data = [
                    'sales_users_id' => $cart_order->sales_users_id, 'item_id' => $cart_order->item_id,
                    'transaction_ref' => $cart_order->transaction_ref, 'd_name' => $cart_order->d_name,
                    'c_name' => $cart_order->c_name, 'is_rgb' => $cart_order->is_rgb, 'qty_content' => $cart_order->qty_content,
                    'qty_bottle' => $cart_order->qty_bottle, 'qty' => $cart_order->qty, 'returned_qty' => $cart_order->returned_qty,
                    'returned_bottle' => $cart_order->returned_bottle, 'price_unit' => $cart_order->price_unit,
                    'price_total' => $cart_order->price_total, 'is_confirmed' => 1
                ];

                $p_order = PendingOrder::create($p_order_data);
                
            }


        });

        $orders = PendingOrder::where('is_confirmed', 1)
                // ->groupBy('transaction_ref')
                ->get();
        
        // $orders = PendingOrder::selectRaw('MAX(id) as id, transaction_ref')
        //     ->where('is_confirmed', 1)
        //     ->groupBy('transaction_ref')
        //     ->get();

        $result = [];
        foreach ($orders as $order)
        {
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->name;
            $item_name = $cat_name.'  '.$cart_item->i_name;
            $item_arr = [
                'id' => $order->id, 'i_name' => $item_name, 'd_name' => $order->d_name, 'qty' => $order->qty, 
                'price_total' => $order->price_total, 'transaction_ref' => $order->transaction_ref
            ];
            array_push($result, $item_arr);
        }



        \Session::forget('sales_cart_session');
        \Session::forget('transaction_ref');
        return view('pending-sales', ['pending_orders' => $result]);

    }



    public function bottle_add(Request $request)
    {
        $cust = $this->custom;

        $validate = $request->validate([
            // 'is_rgb' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $item =  Item::findOrFail($request->item_id);
        $cat_name = Category::find($item->categories_id)
            ->name;
        $item_name = $cat_name.' + '.$item->i_name;

        $cart = new BottleSale;
        $cart->store_users_id = \Session::get('id');
        $cart->i_name = strtoupper($item_name);
        $cart->item_id = $request->item_id;
        // $cart->s_name = $request->supplier;
        $cart->c_name = $request->customer;
        $cart->d_name = $request->driver;
        $cart->comment = $request->comment;
        // $cart->is_bottle = 1;
        $cart->price_unit = $request->price;
        $cart->price_total = round($request->sub_total, 2);
        $cart->transaction_ref = $request->transaction_ref;
      
        // $cart->cart_session = \Session::get('purchase_cart_session');

        // Check for plastic crates and process
        if ($item->is_rgb > 1)
        {
            $cart->qty_bottle_content = $request->quantity;
            $check_item = Item::find($request->item_id)->qty;
            if ( ($check_item - $request->quantity) < 0)
            {
                $request->session()->flash('flash_message', 'Stock is too low for this transaction!!');
                return redirect()->back();
            }
            DB::transaction(function() use ($request, $cart){
                $item = Item::where('id', $request->item_id)
                ->decrement('qty', $request->quantity);

                $cart->qty_bottle_content = $request->quantity;
                $cart->save();

            });
            \Session::forget('transaction_ref');

            $request->session()->flash('flash_message_success', 'Transaction successful');
            return redirect()->back();
        }
        
        $check_item = Item::find($request->item_id)->qty_bottle;
        // var_dump($check_item);exit;
        if ( ($check_item - $request->quantity) < 0)
        {
            $request->session()->flash('flash_message', 'You need to purchase more empty bottles to perform this task');
            return redirect()->back();
        }

        DB::transaction(function() use ($request, $cart){

                // no-exchange<==>0
                // $qty_content = $item->qty_content + $request->quantity_content;
            $item = Item::where('id', $request->item_id)
            ->decrement('qty_bottle', $request->quantity);

            $cart->qty_bottle_content = $request->quantity;
            $cart->save();

        });

        \Session::forget('transaction_ref');

        $request->session()->flash('flash_message_success', 'Transaction successful');
        return redirect()->back();
    }

    public function bottle_show()
    {
        $cust = $this->custom;

        // $suppliers = Supplier::all();
        $customers = Customer::all();
        $drivers = Driver::all();
        $items = Item::where('is_rgb', '>=', 1)
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
        // return view('sales-bottle', ['items' => $result, 'suppliers' => $suppliers, 'customers' => $customers, 'drivers' => $drivers, 'details' => [] ]);
        return view('sales-bottle', ['items' => $result, 'customers' => $customers, 'drivers' => $drivers, 'details' => [] ]);
    }



    public function cart_delete(Request $request, $id)
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

                // decrement empty bottles since this is a direct sales operation
                $item = Item::where('id', $cart->item_id)
                    ->decrement('qty_bottle', $cart->qty);
            }

            Cart::destroy($id);

        });

        // var_dump($user);exit;
        $request->session()->flash('flash_message', 'Item Removed From Cart');
        // url()->current()
        return redirect()->back();
    }



    public function test(Request $request, $transaction_ref = '25579e811079016d9CCgEDYBeFABamLB')
    {
        // $this->validate($request, [
        //     'amount' => 'required|numeric'
        // ]);

        $orders = PendingOrder::where('transaction_ref', $transaction_ref)
                ->where('is_confirmed', '>=', 1)
                ->get();
        $result = [];
        $total = 0;
        $d_name = '';
        $name = ucfirst('testco');
        $amount_paid = 20000;
        // generate receipt
        $receipt = rand(11111111, 99999999);
        foreach ($orders as $order)
        {
            $d_name = $order->d_name;
            $returned_qty = $order->returned_qty;
            $returned_bottle = $order->returned_bottle;
            if (empty($returned_qty))
            {
                $returned_qty = 0;
            }
            if (empty($returned_bottle))
            {
                $returned_bottle = 0;
            }

            if ($order->is_rgb == 0)
            {
                $quantity = $order->qty - $returned_qty;
            }
            if ($order->is_rgb == 1)
            {
                $quantity = $order->qty - $returned_qty;
            }
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->name;
            $item_name = $cat_name.'  '.$cart_item->i_name;
            $item_arr = [
                'id' => $order->id, 'i_name' => $item_name, 'qty' => $quantity, 'd_name' => $order->d_name,
                'price_total' => $order->price_total, 'is_rgb' => $order->is_rgb, 'transaction_ref' => $order->transaction_ref
            ];
            $total += $order->price_total;
            array_push($result, $item_arr);
        }

        // remove print session to avoid duplicate sales table update on page reload
        // session()->forget('print_session');

        $request->session()->flash('flash_message_success', 'Sales Processed. Ensure to print the receipt before navigating away');
        return view('welcome', ['cart_items' => $result, 'price_total' => $total, 'transaction_ref' => $transaction_ref, 'receipt' => $receipt, 'r_name' => $name, 'amount_paid' => $amount_paid]);
        // return redirect('/sales');
    }

    public function generateReceipt()
    {
        $receipt = 10000000;
        $sales = SalesLog::latest()->first();
        // var_dump($sales);exit;
        if ($sales)
        {
            $last_receipt = $sales->receipt;
            $receipt = $last_receipt + 1;
        }
        return $receipt;
    }

}
