<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class AdminController extends Controller
{
    // Middleware
    public function __construct() {
        // only Admin have access
        $this->middleware('admin');
    }
    
    public function __invoke() {
        return view('admin');
    }
    
    public function orders() {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('orders_all', ['orders' => $orders]);
    }
    
    public function fulfill($id) {
        $order = Order::Find($id);
        if ($order->fulfilled == '0') {
            $order->fulfilled = '1';
        } else {
            $order->fulfilled = '0';
        }
        $order->save();
        return redirect()->action('AdminController@orders');
    }
}
