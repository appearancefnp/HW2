@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                <h1 class="card-title">User orders</h1>                
                <div class="card-text">
                    <table class="table table-hover">
                        <thead><tr class="table-primary">
                            <th scope="col">Order ID</th>
                            <th scope="col">Bought at</th>
                            <th scope="col"></th>
                            <th scope="col">Ordered by</th>
                        </tr></thead>
                        <tbody>
                        @foreach ( $orders as $order )
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ date('d F Y G:i', strtotime($order->created_at)) }}</td>
                            <td><button class='btn btn-primary' onclick='goToOrder({{ $order->id }})'>Go to order!</button></td>
                            <td>{{ $order->user->name }}</td>
                        </tr>
                        @endforeach 
                        <tr class="table-primary">
                            <td colspan="4"></td>
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
</script>
@endsection 