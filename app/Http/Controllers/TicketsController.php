<?php

namespace App\Http\Controllers;

use App\Event;
use App\Ticket;
use App\Rules\RowCount;
use App\Rules\SeatCount;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    // Middleware
    public function __construct()
    {
        // only Admins have access
        $this->middleware('admin');
    }    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ticket_create', array('events' => Event::orderBy('name')->pluck('name', 'id')));  
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $rules = $rules = array(
            'event' => 'required|exists:events,id',
            'row' => ['required','integer','min:0'],
            'seat' => ['required','integer','min:0'],
            'price' => 'required|numeric|min:0',
        );
        
        $this->validate($request, $rules);
        
        $event = Event::Find($data['event']);
        if ($data['row'] > $event->rows) {
            return redirect()->back()->with('message', 'There are only ' . $event->rows . ' rows for this event!')->withInput();
        }
        if ($data['seat'] > $event->seats) {
            return redirect()->back()->with('message', 'There are only ' . $event->seats . ' seats for this event!')->withInput();
        }
        if (($data['seat'] == $event->seats) and ($data['row'] == $event->rows)) {
            return redirect()->back()->with('message', 'This ticket already exists(Row: '. $data['row'] .', Seat: '. $data['seat'] .')')->withInput();
        }
        
        $ticket = new Ticket();
        $ticket->row = $data['row'];
        $ticket->seat = $data['seat'];
        $ticket->price = $data['price'];
        $ticket->event()->associate(Event::find($data['event']));
        $ticket->save();
        return redirect('admin')->with('message','Ticket added!');       
    }
}
