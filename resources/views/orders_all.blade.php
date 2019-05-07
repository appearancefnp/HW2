@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                <h1 class="card-title">All User Orders</h1>                
                <div class="card-text">
                    <table class="table table-hover">
                        <thead class="thead-light"><tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Bought at</th>
                            <th scope="col">Ordered by</th>
                            <th scope="col">Mark as done</th>
                            <th scope="col"></th>
                        </tr></thead>
                        <tbody>
                        @foreach ( $orders as $order )
                        @if ($order->fulfilled)
                        <tr class="table-success">
                        @else
                        <tr class="table-danger">
                        @endif
                        
                            <td>{{ $order->id }}</td>
                            <td>{{ date('d F Y G:i', strtotime($order->created_at)) }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>
                                @if (!($order->fulfilled))
                                <button class="btn btn-danger" onclick="fulfillOrder({{ $order->id }})">MARK</button>
                                @else
                                <button class="btn btn-success" onclick="fulfillOrder({{ $order->id }})">UNMARK</button>
                                @endif
                            </td>
                            <td><button class='btn btn-secondary' onclick='goToOrder({{ $order->id }})'>Go to order!</button></td>
                        </tr>
                        @endforeach 
                        <tr class="table-light">
                            <td colspan="5"></td>
                        </tr>                        
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function goToOrder(id) {
        window.location.href = '/orders/' + id;
    }
    function fulfillOrder(id) {
        window.location.href = '/admin/fulfill/' + id;
    }
</script>
@endsection 