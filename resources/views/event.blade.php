@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">{{ $event->name }}, {{$event->category->name}}</h4>
                <p class="card-text">{{ $event->description }}</p>
                <p class="card-text">Start time: {{ $event->formatTime() }}</p>
                <p class="card-text">Category: {{ $event->category->name }}</p>
                <p class="card-text">Rating: {{ $event->rating }}</p>
                <p class="card-text">Location: {{ $event->location }}</p>
                    @if(session()->has('message'))
                     <div class="alert alert-danger">
                        {{ session()->get('message') }}
                     </div>
                    @endif 
                <div class="card-text">
                    @php
                        $tickets = $event->tickets;
                    @endphp
                    @if(count($tickets) == $event->rows * $event->seats)
                    <table>
                        <tr>
                            <td></td>
                            @for ($s = 1; $s <= $event->seats; $s++)
                            <td>{{ $s }}.</td>  
                            @endfor
                        </tr>
                    @for ($r = 1; $r <= $event->rows; $r++)
                        <tr><td>{{ $r }}.</td> 
                        @for ($s = 1; $s <= $event->seats; $s++) 
                        <td title="Row {{ $r }} Seat {{ $s }}"><a
                            @if($tickets->get(($r-1)*($event->seats)+$s-1)->available))    
                                class="btn btn-outline-primary btn-sm"
                            @else
                                class="btn btn-outline-danger btn-sm"
                            @endif
                        href='{{ url('cart/add', $tickets->get(($r-1)*($event->seats)+$s-1)->id) }}'>{{$tickets->get(($r-1)*($event->seats)+$s-1)->price}}&euro;</a>
                        @endfor
                        </tr>
                    @endfor
                    </table>
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 