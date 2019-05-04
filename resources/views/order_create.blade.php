@extends('layouts.app')
@section('content')
<div class="container">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Your Order</h4>                
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
                <h4>Enter order details</h4>
                <div class="col-sm">
                    {!! Form::open(array('action' => 'OrderController@store', 'class' => 'form-horizontal')) !!}
                    <div class='form-group'>
                    {!! Form::label('address', 'Shipping Address') !!}
                    {!! Form::text('address', '', ['class' => 'form-control '.($errors->has('address') ? ' is-invalid' : '') , 'placeholder' => 'University Of Latvia']) !!}
                    @if ($errors->has('address'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                    </div>
                    <div class='form-group'>
                    {!! Form::label('phone', 'Phone Number') !!}
                    {!! Form::text('phone', '', ['class' => 'form-control '.($errors->has('phone') ? ' is-invalid' : '')  , 'placeholder' => '23126126']) !!}
                    @if ($errors->has('phone'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('phone') }} Only 8 numbers are allowed.</strong>
                        </span>
                    @endif
                    </div>
                    <div class='form-group'>
                    {!! Form::submit('Place Order!', ['class' => 'btn btn-primary']); !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                </div>
            </div>
</div>
@endsection 