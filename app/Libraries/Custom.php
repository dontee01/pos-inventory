<?php
namespace App\Libraries;

use DateTime;

use App\Models\Item;
use App\Models\Cart;
use App\Models\CartPurchase;

use DB;
/**
* 
*/
class Custom
{
	// function __construct(argument)
	// {
		
	// }

    function generate_session($email, $time)
    {
        $newtoken = $this->hashh($email, $time);
        return  $newtoken;
    }
    
    function time_now()
    {
        $main = date('Y-m-d H:i:s');
        return $main;
    }
    
    /**
     * 
     * @param date Current datetime
     * @return date <b>Yesterday</b>
     */
    function yesterday()
    {
        $time = $this->time_now();
        $date = strtotime($time.' -1 day');
    
        return date('Y-m-d', $date);
    }
    
    /**
     * 
     * @return date <b>Today</b>
     */
    function today()
    {
//        $date = strtotime($time.' -'.$diff.' minute');
    
        return date('Y-m-d');
    }
    
    /**
     * 
     * @param date Current datetime
     * @return date <b>Tomorrow</b>
     */
    function tomorrow()
    {
        $time = $this->time_now();
        $date = strtotime($time.' +1 day');
    
        return date('Y-m-d', $date);
    }
    
    function time_diff($time, $diff)
    {
        $date = strtotime($time.' -'.$diff.' year');
        
        return date('Y-m-d H:i:s', $date);
    }
    
    function minute_diff($time, $diff)
    {
        $date = strtotime($time.' -'.$diff.' minute');
    
        return date('Y-m-d H:i:s', $date);
    }
    
    function second_diff($time, $diff)
    {
        $date = strtotime($time.' -'.$diff.' second');
    
        return date('Y-m-d H:i:s', $date);
    }

    function timeout($time, $diff)
    {
        $date = strtotime($time.' +'.$diff.' second');
    
        return date('Y-m-d H:i:s', $date);
    }

    function hashh($em,$date)
    {
        $sto = "AGLRSTabcUVWXYZdefBCDEFghijkmnopqHIJKrstuvwxyz1023MNOPQ456789";
        $str_em = substr(md5($em.$sto), 1,9);
        srand((double)microtime()*1000000);
        $a = explode(":", $date);
        $o =  $a[1].$a[2];
        $p = $a[2].$a[1];
        $q = abs($o - $p);
        $q = substr(md5($q), 1, 8);
        $i = 1;
        $confirm = '' ;
        while ($i <= 15) {
            $num = rand() % 33;
            $temp = substr($sto, $num, 1);
            $confirm = $confirm . $temp;
            $i++;
    
        }
        $confirm = $str_em.$q.$confirm;
        return $confirm;
    }
    
    public function validate_time($time)
    {
        try {
            $date = new DateTime($time);
        } catch (Exception $e) {
            // For demonstration purposes only...
//             print_r(DateTime::getLastErrors());
        
            // The real object oriented way to do this is
            // echo $e->getMessage();
            if ($e->getMessage())
            {
                return 'err';
            }
        }
    }
    
    public function explode_del_multi($string, $delimiters = [',', ':', ';'])
    {
        if ( ! is_array($delimiters)) $delimiters = (array) $delimiters;
    
        if ( ! count($delimiters)) return $string;
    
        // build escaped regex like /(delimiter_1|delimiter_2|delimiter_3)/
        $regex = '/(';
        $regex .= implode('|', array_map(function ($delimiter) {
            return preg_quote($delimiter);
        }, $delimiters));
            $regex .= ')/';
    
            return preg_split($regex, $string);
    }
    
    public function replace_multi($string, $find, $replace)
    {
//         $find = array(",","---");
//         $replace = array("");
//         $arr = 'some,thing---to:xplode444asd';
        $replaced = str_replace($find,$replace,$string);
        return $replaced;
    }
    
    public function process_mobile($mobile, $countryCode = "234")
    {
        $new_num = "";
        $len_fone = strlen($mobile);
        if ($len_fone == 13 || $len_fone == 11)
        {
            if ($len_fone == 13)
            {
                $cclen = strlen($countryCode);
                $numcode = substr($mobile, 0, $cclen);
                $number = substr($mobile, $cclen);
                $num = $number;
        
                if (strcmp($numcode, $countryCode) == 0 && strlen($number) == 10 && ctype_digit($number))
                {
                    $new_num = $countryCode.$number;
//                     echo $new_num;
                    //                array_push($param_null, 'mobile');
                }
                else
                {
                    $new_num = "";
//                     array_push($param_null, 'mobile');
                }
            }
            if ($len_fone == 11)
            {
                $sub = $mobile[0];
                $number = substr($mobile, 1);
                if ($sub == "0" && strlen($number) == 10 && ctype_digit($number))
                {
                    $new_num = $countryCode.$number;
//                     echo $new_num;
                }
                else
                {
                    $new_num = "";
//                     array_push($param_null, 'mobile');
                }
            }
        }
        //             consider
        else
        {
            $new_num = "";
//             array_push($param_null, 'mobile');
        }
        return $new_num;
    }
    
    function validate_date($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function format_date($date, $format = 'Y-m-d')
    {
        // $d = DateTime::createFromFormat($format, $date);
        $date = date_create($date);
        return date_format($date, $format);
    }
    
    function get_empty_bottle_val($val)
    {
        $res = $val / 24;
        $res = round($res, 3);
        return $res;
    }

    function store_empty_bottle_val($val)
    {
        $res = round($val * 24);
        return $res;
    }

    function get_empty_bottle($val)
    {
        $val = $this->store_empty_bottle_val($val);
        $res = floor($val / 24);
        $mod = $val % 24;

    }

    function get_empty_bottle_info($val)
    {
        $val = $this->store_empty_bottle_val($val);
        $res = floor($val / 24);
        $mod = $val % 24;

        if ($res < 2)
        {
            $crate = 'Crate';
        }
        if ($res > 1)
        {
            $crate = 'Crates';
        }

        if ($mod < 2)
        {
            $bottle = 'Bottle';
        }
        if ($mod > 1)
        {
            $bottle = 'Bottles';
        }

        $result = $res.' '.$crate.' and '.$mod.' '.$bottle;
        return $result;
    }

    public function revert_purchases($cart_session)
    {
        $check_cart = CartPurchase::where('cart_session', $cart_session)
            ->where('store_users_id', \Session::get('id'))
            ->where('is_confirmed', 0)
            ->get();

        if (empty($check_cart))
        {
            return 0;
        }
        DB::transaction(function() use ($cart_session){

            $carts = CartPurchase::where('cart_session', $cart_session)
                ->where('store_users_id', \Session::get('id'))
                ->where('is_confirmed', 0)
                ->get();
// var_dump($carts->toArray());exit;
            
            foreach ($carts as $cart)
            {
                $quantity_rebate = 0;
                // check for rebate
                if ($cart->is_rebate == 1)
                {
                    $quantity_rebate = $cart->qty_rebate;
                }

                // add up rebate (rebate value will be zero if no rebate on product)
                $quantity = $quantity_rebate + $cart->qty;

                if ($cart->is_rgb == 0)
                {
                    $item = Item::where('id', $cart->item_id)
                        ->decrement('qty', $quantity);
                }

                if ($cart->is_rgb == 1 && $cart->no_exchange == 1 )
                {

                    $item = Item::where('id', $cart->item_id)
                    ->decrement('qty_content', $quantity);

                    $item = Item::where('id', $cart->item_id)
                    ->increment('qty_bottle', $quantity);
                }

                if ($cart->is_rgb == 1 && $cart->no_exchange == 0 )
                {
                    $item = Item::where('id', $cart->item_id)
                        ->decrement('qty_content', $quantity);
                }

                CartPurchase::destroy($cart->id);
            }

        });
    }

    public function revert_sales($cart_session)
    {
        $check_cart = Cart::where('cart_session', $cart_session)
            ->where('sales_users_id', \Session::get('id'))
            ->where('is_confirmed', 0)
            ->get();

        if (empty($check_cart))
        {
            return 0;
        }

        DB::transaction(function() use ($cart_session){

            $carts = Cart::where('cart_session', $cart_session)
                ->where('sales_users_id', \Session::get('id'))
                ->where('is_confirmed', 0)
                ->get();

            foreach ($carts as $cart)
            {

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

                Cart::destroy($cart->id);
            }

        });
        
    }


    public function revert_orders($cart_session)
    {
        $check_cart = Cart::where('cart_session', $cart_session)
            ->where('store_users_id', \Session::get('id'))
            ->where('is_confirmed', 0)
            ->get();

        if (empty($check_cart))
        {
            return 0;
        }

        DB::transaction(function() use ($cart_session){

            $carts = Cart::where('cart_session', $cart_session)
                ->where('store_users_id', \Session::get('id'))
                ->where('is_confirmed', 0)
                ->get();
            
            foreach ($carts as $cart)
            {
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

                Cart::destroy($cart->id);
            }

        });
        
    }


}

