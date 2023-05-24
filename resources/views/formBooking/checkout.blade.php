@extends('layouts.index')

@section('title','CakStore | Admin')

@section('content')

<div id="main" class="container" data-aos="fade-up">
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
                <div class="d-flex justify-content-end">
                    <p>Total: $300</p>
                </div>
                <hr>
                <div class="d-grid gap-2">
                    <button type="button" id="pay-button" class="btn btn-primary rounded-pill">Bayar</button>
                </div>
                <div class="text-center">
                    <p>Thank you for your business!</p>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection

@section('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            snap.pay('{{ $booking->details->payment_token ?? NULL }}',{
                onSuccess: function(result){
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    windows.location.reload();
                },
                onPending: function(result){
                    windows.location.reload();
                },
                onError: function(result){
                    windows.location.reload();
                }
            });
        });
    </script>
@endsection