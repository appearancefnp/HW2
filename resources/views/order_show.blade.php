@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                <h1 class="card-title">Your order</h1>                
                <div class="card-text">
                    <table class="table table-hover">
                        <thead><tr class="table-primary">
                            <th scope="col">Event</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">Location</th>
                            <th scope="col">Row</th>
                            <th scope="col">Seat</th>
                            <th scope="col">Price</th>
                        </tr></thead>
                        <tbody>
                        @foreach ( $tickets as $ticket )
                        <tr>
                            <td>{{ $ticket->event->name }}</td>
                            <td>{{ $ticket->event->formatTime() }}</td>
                            <td>{{ $ticket->event->location }}</td>
                            <td>{{ $ticket->row }}</td>
                            <td>{{ $ticket->seat }}</td>
                            <td>{{ $ticket->price }}</td>
                            </td>
                        </tr>
                        @endforeach 
                        <tr class="table-primary">
                            <td colspan="4"></td>
                            <td><b>Total:</b></td>
                            <td>{{ $total }}</td>
                        </tr>                        
                        </tbody>
                    </table>
                </div>
                <h3>Information about buyer:</h3>
                <h6>Name: <b>{{ $user->name }}</b></h6>
                <h6>E-mail: <b> {{ $user->email }} </b></h6>
                <h6>Address: <b> {{ $order->shipping_address }} </b></h6>
                <h6>Phone Number: <b> {{ $order->phone_number }} </b></h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 