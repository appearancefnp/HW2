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
}
