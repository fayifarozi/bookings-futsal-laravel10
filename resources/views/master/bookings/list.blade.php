@extends('master.layouts.main')

@section('title','Lapangan')

@section('content')
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Page Booking</h3>
                        <p class="text-subtitle text-muted">List Booking Lapangan</p>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="row" id="basic-table">
                    <div class="col">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-lg">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Booking</th>
                                                    <th>Code</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach( $data as $row )
                                                <tr>
                                                    <td>{{ $row->booking_id }}</td>
                                                    <td>{{ $row->name }}</td>
                                                    <td>{{ $row->email ?? 'NULL' }}</td>
                                                    <td>{{ $row->phone ?? 'NULL' }}</td>
                                                    <td>{{ $row->tanggal ?? 'NULL' }}</td>
                                                    <td>{{ $row->order_code ?? 'NULL' }}</td>
                                                    <td>{{ $row->status ?? 'NULL' }}</td>
                                                    <td>
                                                        <a href="{{ route('detail.bookings', ['booking' => $row->booking_id]) }}" class="btn btn-primary">View</a>
                                                    </td>
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