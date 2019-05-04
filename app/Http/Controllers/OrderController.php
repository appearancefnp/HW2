<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Order;
use App\Ticket;
use App\TicketOrder;
use App\User;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $total = 0.0;
        $display_result = array();
        
        $current_cart =  $request->session()->get('cart', array());
        
        foreach ($current_cart as $id => $count)
        {
            if ($count > 0)
            {
                $ticket = Ticket::findOrFail($id);
                $total += $ticket->price;                
                $display_result[] = $ticket;
            }
        }
        
        return view('order_create', array('total' => $total, 'tickets' => $display_result));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = $rules = array(
            'address' => 'required|string|min:4|max:191',
            'phone' => 'required|regex:/[0-9]{8}/',
        );
            
        $this->validate($request, $rules);   
            
        $order = new Order();
        $order->shipping_address = $data['address'];
        $order->phone_number = $data['phone'];
        $order->user_id = Auth::id();
        $order->save();
        $order_id = $order->id;
        
        $current_order =  $request->session()->get('cart', array());
        foreach ($current_order as $id => $count)
        {
            if ($count > 0)
            {
                $TicketOrder = new TicketOrder();
                $TicketOrder->order_id = $order_id;
                $TicketOrder->ticket_id = $id;
                $TicketOrder->save();
            }
        }
        Session::forget('cart');
        return redirect()->action('OrderController@show', ['id' => $order_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tickets = array();
        $order = Order::FindOrFail($id);
        $user_id = Auth::id();
        if ($order->user_id != $user_id) {
            return abort(404);
        }
        $total = 0.0;
        $user = User::Find($user_id);
        $ticketOrders = TicketOrder::where('order_id','=',$id)->get();
        foreach ($ticketOrders as $ticketOrder) {
            $ticket = Ticket::find($ticketOrder->ticket_id);
            $tickets[] = $ticket;
            $total += $ticket->price;
        }
        return view('order_show', ['order' => $order, 'user' => $user, 'tickets' => $tickets, 'total' => $total]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
