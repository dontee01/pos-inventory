<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;

use View;
use Input;
use Validator;
use Redirect;

use App\Libraries\Custom;
class UserController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = new Custom();
    }
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(\Session::has('id'))
    {
      return redirect('home');
    }
    // $users = User::all();
    return view('login');
  }

  public function login(Request $request)
  {
    $req_all = $request->all();
    // print_r($req_all);exit;
    $validate = $request->validate([
        'username' => 'required|max:255',
        'password' => 'required|min:4|max:32'
    ]);
    
    // $this->validate($request, [
    //     'username' => 'required|max:255',
    //     'password' => 'required|min:4|max:32'
    // ]);

    // $validator = Validator::make($request->all(), [
    //     'username' => 'required|max:255',
    //     'password' => 'required|min:4|max:32'
    // ]);
    // if ($validator->fails()) {
    //     // return response()->json(['errors' => $validator->errors()], 422);
    //     $request->session()->flash('flash_message', 'Login Failed!');
    //     return redirect('/');
    // }
    
    $user = User::where('name', $request->username)
      ->where('password', $request->password)
      ->first();
    // dd($user);exit;
    if ($user)
    {
      $request->session()->put('id', $user->id);
      $request->session()->put('name', strtoupper($user->name) );
      $request->session()->put('level', $user->level);
    // dd(session()->all());exit;
      return redirect('home');
    }
    else
    {
      $request->session()->flash('flash_message', 'Login Failed!');
      return redirect('/');
      // ->withInput($request->all());
    }
  }

  public function logout(Request $request)
  {
    $custom = $this->custom;
    if (session()->has('purchase_cart_session'))
    {
        // revert transaction if purchase cart session exists
        // $request->session()->flash('flash_message', 'Cart is empty');
        // return redirect('/purchase');
        $cart_session = \Session::get('purchase_cart_session');
        $custom->revert_purchases($cart_session);
    }
    if (session()->has('sales_cart_session'))
    {
        // revert transaction if sales cart session exists
        $cart_session = \Session::get('sales_cart_session');
        $custom->revert_sales($cart_session);
    }
    if (session()->has('cart_session'))
    {
        // revert transaction if sales cart session exists
        $cart_session = \Session::get('cart_session');
        $custom->revert_orders($cart_session);
    }
    \Session::flush();
    return redirect('/');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return View::make('users.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    $input = Input::all();
    $validation = Validator::make($input, User::$rules);

    if ($validation->passes())
    {
        User::create($input);

        return Redirect::route('users.index');
    }

    return Redirect::route('users.create')
        ->withInput()
        ->withErrors($validation)
        ->with('message', 'There were validation errors.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $user = User::find($id);
    if (is_null($user))
    {
        return Redirect::route('users.index');
    }
    return View::make('users.edit', compact('user'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $input = Input::all();
    $validation = Validator::make($input, User::$rules);
    if ($validation->passes())
    {
        $user = User::find($id);
        $user->update($input);
        return Redirect::route('users.show', $id);
    }
	return Redirect::route('users.edit', $id)
	        ->withInput()
	        ->withErrors($validation)
	        ->with('message', 'There were validation errors.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    User::find($id)->delete();
    return Redirect::route('users.index');
  }
  
}