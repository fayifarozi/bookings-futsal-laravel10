@extends('master.layouts.main')

@section('title','Admin')

@section('content')
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Page Schedule</h3>
                        <p class="text-subtitle text-muted">List Schedule Open</p>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="row">
                    <div class="col">
                        <div class="card p-3">
                            <div class="card-header">
                                <h1>Masukan Jam Buka</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('schedules.setOpenTime') }}" method="post" id="new-hours">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <input type="text" class="form-control @error('start_time') invalid @enderror" id="start-time" name="start_time" placeholder="Jam Buka">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control @error('end_time') invalid @enderror" id="end-time" name="end_time" placeholder="Jam Tutup">
                                        </div>
                                    </div>
                                    <p>Note : Menambahkan jam buka baru, maka semua data jam buka lama akan tergantikan dengan yang baru.</p>
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-primary rounded-pill" onclick="addNewOpenTime()">Tambahkan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="basic-table">
                    <div class="col">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="d-flex justify-content-end gap-3">
                                        <button type="button" class="btn icon icon-left btn-primary" onclick="activatedTime()">
                                            <i class="bi bi-eye"></i> active
                                        </button>
                                        <button type="button" class="btn icon icon-left btn-primary" onclick="nonActivatedTime()">
                                            <i class="bi bi-eye-slash"></i> non-active
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-lg">
                                            <thead>
                                                <tr>
                                                    <th>
                                                    <div class="checkbox checkbox-shadow checkbox-sm">
                                                        <input type="checkbox" id="checkedAll" class='form-check-input'>
                                                        <label for="checkedAll"></label>
                                                    </div>
                                                    </th>
                                                    <th>Hours</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach( $data as $row )
                                                <tr>
                                                    <td>
                                                        <div class="checkbox checkbox-shadow checkbox-sm">
                                                            <input type="checkbox" class="form-check-input select-checkbox" name="selectID[]" value="{{ $row->id }}">
                                                        </div>
                                                    </td>
                                                    <td>{{ $row->hours }}</td>
                                                    
                                                    <td>
                                                        @if( $row->status == 1)
                                                            <span class="badge bg-success">active</span>
                                                        @else
                                                            <span class="badge bg-danger">non-active</span>
                                                        @endif
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

@section('script')
<script>
    $("#checkedAll").change(() => {
        const isChecked = $("#checkedAll").prop("checked");
        $('input[type="checkbox"][name="selectID[]"]').each(function() {
            if (isChecked) {
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", false);
            }
        });
    })

    function addNewOpenTime() {
        Swal.fire({
            title: "Confirmation",
            text: "Are you sure you want add new Open Time ?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("new-hours").submit();
            }
        });
    }
    
    function activatedTime() {
        Swal.fire({
            title: "Confirmation",
            text: "Are you sure you want to activate the time?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                let status = 'active'; 
                sendAjaxRequest(status);
            }
        });
    }

    function nonActivatedTime() {
        Swal.fire({
            title: "Confirmation",
            text: "Are you sure you want to deactivate the time?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                let status = 'non-active'; 
                sendAjaxRequest(status);
            }
        });
    }

    function sendAjaxRequest(value) {
        let selectedID = $('input[name="selectID[]"]:checked').map(function() {
            return this.value;
        }).get();
        
        $.ajax({
            url: "{{ route('schedules.updateOpenTime')}}",
            method: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                select_id: selectedID,
                status: value
            },
            success: function(response) {
                window.location.reload();
            },
            error: function(error) {
                window.location.reload();
            }
        });
    }
</script>
@endsection