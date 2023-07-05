@extends('master.layouts.main')

@section('title','Lapangan')

@section('content')

<section id="order-list">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <img src="/assets/img/clients/client-2.png" alt="Invoice Logo" class="img-fluid">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Invoice Number: {{ $booking->order_code ?? NULL }}</h5>
                        <p>Name : {{ $booking->name ?? NULL }}</p>
                        <p>Contact : {{ $booking->phone ?? NULL }}</p>
                        <p>{{ $booking->tanggal ?? NULL }} - {{ $booking->status ?? NULL }}</p>
                    </div>
                </div>
                <hr></hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Lapangan</th>
                            <th>Durasi</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Sewa PerJam</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $booking->details->fields->field_name ?? NULL }}</td>
                            <td>{{ $booking->details->duration ?? NULL }}</td>
                            <td>{{ $booking->details->start_time ?? NULL }}</td>
                            <td>{{ $booking->details->end_time ?? NULL }}</td>
                            <td>{{ $booking->details->price ?? NULL }}</td>
                            <td>{{ $booking->details->amount ?? NULL }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
