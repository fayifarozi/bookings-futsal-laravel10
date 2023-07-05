@extends('master.layouts.main')

@section('title','Lapangan')

@section('content')
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Payments Notification</h3>
                        <p class="text-subtitle text-muted">List Payments Notification</p>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="row" id="basic-table">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-primary rounded-pill">Tambahkan</button>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-lg">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Code</th>
                                                    <th>Email</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach( $data as $row )
                                                <tr>
                                                    <td>{{ $row->payment_id }}</td>
                                                    <td>{{ $row->order_code }}</td>
                                                    <td>{{ $row->email ?? 'NULL' }}</td>
                                                    <td>{{ $row->amount?? 'NULL' }}</td>
                                                    <td>{{ $row->status ?? 'NULL' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection