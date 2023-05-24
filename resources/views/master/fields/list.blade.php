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
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Layout Default</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="row" id="basic-table">
                    <div class="col">
                        <div class="card p-3">
                            <div class="card-header">
                                <a href="{{ route('fields.create') }}"class="btn btn-primary rounded-pill">Tambahkan</a>
                            </div>
                            <div class="card-body">
                                <div class="row row-cols-auto justify-content-start">
                                    @foreach($data as $row)
                                    <div class="col p-3">
                                        <div class="card shadow" style="width: 18rem;">
                                            @if ($row->image !== null)
                                                <img src="{{ asset('images/' . $row->image) }}" class="card-img-top" alt="...">
                                            @else
                                                <img src="/assets/img/cta-bg.jpg" class="card-img-top" alt="...">
                                            @endif
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <h3 class="card-title" id="field">{{ $row->field_name }}</h4>
                                                        <h4 class="card-text" id="price"><sup>Rp</sup>{{ $row->price }}</h4>
                                                    </div>
                                                    <div class="col-4">
                                                        @if( $row->status == 'active')
                                                            <span class="badge bg-success">{{$row->status}}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{$row->status}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-center gap-1" >
                                                <a href="{{ route('fields.edit', ['path' => $row->path]) }}" class="btn btn-primary">Edit</a>
                                                <form method="POST" action="{{ route('fields.updateStatus')}}" id="updateStatus">
                                                    @csrf
                                                    <input type="hidden" name="field_id" value="{{ $row->field_id}}">
                                                    @if( $row->status == 'active')
                                                    <input type="hidden" name="status" value="deactive">
                                                    <button type="button" class="btn btn-danger" onclick="deleteConfirm()">Deactive</button>
                                                    @else
                                                    <input type="hidden" name="status" value="active">
                                                    <button type="button" class="btn btn-danger" onclick="deleteConfirm()">Active</button>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
@section('script')
<script>
    function deleteConfirm() {
        Swal.fire({
            title: "Confirmation",
            text: "Are you sure you want to change status ?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("updateStatus").submit();
            }
        });
    }

</script>
@endsection

