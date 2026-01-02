<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Item;
use App\Models\Category;

use DB;
use App\Libraries\Custom;

class ItemController extends Controller
{
	protected $custom;
    public function __construct()
    {
        // $this->middleware('login');
        $this->custom = new Custom();
    }

    public function index()
    {
        $cust = $this->custom;
    	$items = Item::all();
    	$result = [];
    	foreach ($items as $item)
    	{
	    // print_r($item);exit;
    		// $cat_name = Category::where('id', $item->categories_id)
    		// ->value('name');
            $cat_name = Category::find($item->categories_id)
            ->name;

			$total_item_rgb_empty = $cust->get_empty_bottle_info($item->qty_bottle);
			$total_item_rgb_content = $cust->get_empty_bottle_info($item->qty_content);
    		$item_arr = [
    			'id' => $item->id, 'category' => $cat_name, 'i_name' => $item->i_name, 'is_rgb' => $item->is_rgb, 'qty' => $item->qty, 'qty_bottle' => $total_item_rgb_empty, 
    			'qty_content' => $total_item_rgb_content, 'cost_price' => $item->cost_price, 'price_unit' => $item->price_unit, 'date' => $item->created_at
    		];
    		array_push($result, $item_arr);
    	}
    	// $orders = DB::table('categories')
    	// ->get();
    	// print_r($result);exit;
    	return view('item', ['items' => $result]);
    }

    public function show_add()
    {
    	$categories = Category::all();
    	return view('item-add', ['categories' => $categories]);
    }

    public function show_edit($id)
    {
        $cust = $this->custom;
    	$item = Item::find($id);
		$cat_name = Category::where('id', $item->categories_id)
		->value('name');
		
		$total_item_rgb_empty = $cust->get_empty_bottle_info($item->qty_bottle);
		$total_item_rgb_content = $cust->get_empty_bottle_info($item->qty_content);
		$result = [
			'id' => $item->id, 'category' => $cat_name, 'i_name' => $item->i_name, 'is_rgb' => $item->is_rgb, 'qty' => $item->qty, 'qty_bottle' => $item->qty_bottle, 
			'qty_content' => $item->qty_content, 'cost_price' => $item->cost_price, 'price_unit' => $item->price_unit, 'rgb_qty_bottle' => $total_item_rgb_empty, 'rgb_qty_content' => $total_item_rgb_content, 'date' => $item->created_at
		];
    	return view('item-edit', ['item' => $result]);
    }

    public function add(Request $request)
    {
    	$cust = $this->custom;
		$validate = $request->validate([
			'category' => 'required',
			'item' => 'required|min:4',
			// 'is_rgb' => 'required',
			// 'qty' => 'numeric',
			// 'qty_bottle' => 'numeric',
			// 'qty_content' => 'numeric',
			'cost_price' => 'required|numeric',
			'price' => 'required|numeric',
		]);

		if($request->has('is_rgb'))
		{
			$validate = $request->validate([
				// 'category' => 'required',
				// 'item' => 'required|min:4',
				// 'is_rgb' => 'required',
				// 'qty' => 'numeric',
				'qty_bottle' => 'numeric',
				'qty_content' => 'numeric',
				// 'price' => 'required|numeric',
			]);
		}

    	$item = new Item;
    	$users_id = \Session::get('id');
    	$categories_id = $request->category;
    	$i_name = strtoupper($request->item);
    	$is_rgb = $request->is_rgb;
    	$qty = $request->qty;
    	$qty_content = $request->qty_content;
    	$qty_bottle = $request->qty_bottle;
    	$cost_price = $request->cost_price;
    	$price_unit = $request->price;

        $unique_check = Item::where('categories_id', $categories_id)
        ->where('i_name', $i_name)
        ->first();
        if ($unique_check)
        {
            $request->session()->flash('flash_message', 'Item Exists');
            return redirect()->back();
        }

    	$item_arr = [
    	'users_id' => $users_id, 'categories_id' => $categories_id, 'i_name' => $i_name, 'is_rgb' => 0, 'qty' => $qty, 'cost_price' => $cost_price, 'price_unit' => $price_unit
    	];

    	// if ($is_rgb == 1)
    	if ($is_rgb)
    	{
	    	$item_arr = [
	    	'users_id' => $users_id, 'categories_id' => $categories_id, 'i_name' => $i_name, 'is_rgb' => 1, 'qty_bottle' => $qty_bottle, 'qty_content' => $qty_content, 'cost_price' => $cost_price, 'price_unit' => $price_unit, 'created_at' => $cust->time_now()
	    	];
	    }
	    $item_ins = DB::table('items')
	    ->insert($item_arr);

		$request->session()->flash('flash_message_success', 'Item Added');
	    // return $this->index();
	    return redirect('/items')->withInput();
	    // print_r($item_arr);exit;
    	// return view('item', ['items' => $items]);
    }

    public function edit(Request $request, $id)
    {
    	// $items = Item::all();

    	$item = Item::find($id);
    	$users_id = \Session::get('id');
    	// $categories_id = $request->category;
    	// $i_name = strtoupper($request->item);
    	$is_rgb = $request->is_rgb;
    	$qty = $request->qty;
    	$qty_content = $request->qty_content;
    	$qty_bottle = $request->qty_bottle;
    	$cost_price = $request->cost_price;
    	$price_unit = $request->price;

		$item->i_name = strtoupper($request->item);
    	if ($is_rgb == 0)
    	{
	    	$item->users_id = $users_id;
	    	$item->qty = $qty;
	    	$item->price_unit = $price_unit;
	    }

    	if ($is_rgb)
    	{

	    	$item->users_id = $users_id;
	    	$item->qty_bottle = $qty_bottle;
	    	$item->qty_content = $qty_content;
	    	$item->price_unit = $price_unit;
	    }
	    // var_dump($item);exit;

		$item->cost_price = $cost_price;
	    $item->save();
		$request->session()->flash('flash_message_success', 'Item Updated');
	    // return $this->index();
	    return redirect('/items');
        // return redirect()->route('contact')->with('info', trans('texts.contact.sent_success'));
    }

    public function delete(Request $request, $id)
    {
    	// $item = Item::find($id);
    	// $users_id = \Session::get('id');

    	// $item->delete();
    	Item::destroy($id);

	    // var_dump($item);exit;
		$request->session()->flash('flash_message', 'Item Deleted');
	    return redirect('/items');
	    // return $this->index();
    }
}
