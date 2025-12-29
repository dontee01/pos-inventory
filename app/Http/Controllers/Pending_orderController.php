<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Item;
use App\Models\PendingOrder;

use DB;
use App\Libraries\Custom;

class Pending_orderController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
        // $this->middleware('login');
    }

    public function index()
    {
        $orders = PendingOrder::where('is_confirmed', 0)
                // ->groupBy('transaction_ref')
                ->get();
        $result = [];
        foreach ($orders as $order)
        {
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->value('name');
            $item_name = $cat_name.'  '.$cart_item->i_name;
            $item_arr = [
                'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 
                'price_total' => $order->price_total, 'transaction_ref' => $order->transaction_ref
            ];
            array_push($result, $item_arr);
        }

    	
        return view('pending-order', ['pending_orders' => $result]);
    }

    public function show_order($id)
    {
        $order = PendingOrder::where('id', $id)
                ->first();
        $result = [];
        // foreach ($orders as $order)
        // {
            // get categoriesId and item name using itemId from cart table
            $cart_item = Item::find($order->item_id);
                // print_r($cart_item);exit;
            $cat_name = Category::find($cart_item->categories_id)
            ->value('name');
            $item_name = $cat_name.'  '.$cart_item->i_name;
            $result = [
                'id' => $order->id, 'i_name' => $item_name, 'qty' => $order->qty, 
                'price_total' => $order->price_total, 'is_rgb' => $order->is_rgb
            ];
            // array_push($result, $item_arr);
        // }

        
        return view('pending-process', ['order' => $result]);
    }


    public function checkout(Request $request, $id)
    {
        $cust = $this->custom;

        $check_pending = PendingOrder::find($id)->is_confirmed;
        // var_dump($check_pending);exit;
        if ($check_pending > 0)
        {
            $request->session()->flash('flash_message', 'Order already processed');
            return redirect('pending');
        }
        if ($request->is_rgb == 1)
        {
            $validate = $request->validate([
                'quantity_bottle' => 'required|numeric',
                'quantity_content' => 'required|numeric',
            ]);
        }
        else
        {
            $validate = $request->validate([
                'qty' => 'required|numeric'
            ]);
        }
        DB::transaction(function() use ($id, $request)
        {
            $item_id = PendingOrder::where('id', $id)
            ->first();
            // ->value('item_id');
            $item = Item::find($item_id->item_id);

            if ($request->is_rgb == 1)
            {
                $qty_content = $item->qty_content + $request->quantity_content;
                $qty_bottle = $item->qty_bottle + $request->quantity_bottle;

                $data_item = [
                    'qty_content' => $qty_content, 'qty_bottle' => $qty_bottle
                ];
                // update items table
                $item_upd = Item::where('id', $item_id->item_id)
                ->update($data_item);

                // data for updating pending table with returned quantities
                $price_total = $item_id->price_unit * $request->quantity_bottle;
                $data = [
                    'returned_qty' => $request->quantity_content, 'returned_bottle' => $request->quantity_bottle, 
                    'is_confirmed' => 1, 'price_total' => $price_total
                ];
            }

            if ($request->is_rgb == 0)
            {
                $qty = $item->qty + $request->qty;
                
                $quantity = $item_id->qty - $request->qty;
                $price_total = $item_id->price_unit * $quantity;
                $data_item = [
                    'qty' => $qty
                ];
                // update items table
                $item_upd = Item::where('id', $item_id->item_id)
                ->update($data_item);

                // data for updating pending table with returned quantities
                $data = [
                    'returned_qty' => $request->qty, 'is_confirmed' => 1, 'price_total' => $price_total
                ];
            }
            // update pending order table
            $orders_upd = PendingOrder::where('id', $id)
                ->update($data);

        });

        $request->session()->flash('flash_message_success', 'Order Processed');
        return redirect('/pending');
    }

}
