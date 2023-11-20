@extends('master.layouts.main')

@section('title','Admin')

@section('content')
<div class="page-heading">
    <h3>Update Admin</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card p-3">
            <form class="edit-profile" method="post" action="{{ route('admin.update', ['user' => $admin->user_id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="image_old" value="{{ $admin->image }}">
                <div class="row">
                    <div class="col-12 col-md-4" align="center">
                        <div class="card avatar photo-card border-0 rounded-circle mb-0" style="width:300px;">
                            @if($admin->image != null)
                                <img src="{{ asset('images/profiles/' . $admin->image) }}" class="photo img-fluid" id="imgRead" />
                                @else
                                <img src="{{ asset('/assets/img/team/team-1.jpg') }}" class="photo img-fluid" id="imgRead"/>
                            @endif
                            <div class="photo-overlay">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <div class="image-upload">
                                <input type="file" id="image" name="image" accept="image/png, image/jpg, image/jpeg" onchange="previewFile()" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control mb-2" id="name" name="name" value="{{ $admin->name }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="email">Email</label>
                                <input type="text" class="form-control mb-2" id="email" name="email" value="{{ $admin->email }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="level">Level Access</label>
                                @if(Session::get('level') == 'admin')
                                    <select class="form-select" id="level" name="level" aria-label="Default select example" value="{{ $admin->level }}">
                                        <option value="admin" {{ $admin->level == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="employee" {{ $admin->level == 'employee' ? 'selected' : '' }}>Employee</option>
                                    </select>
                                @else
                                    <input type="text" class="form-control mb-2 disable" id="level" name="level" disabled value="{{ $admin->level }}" >
                                @endif
                            </div>
                            <div class="col-12 mb-3">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="" placeholder="Masukan Password baru jika ingin Merubah" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary rounded-pill" type="button">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

@endsection()
@section('script')
<script>
    function previewFile() {
        const preview = document.querySelector("#imgRead");
        const file = document.querySelector("input[type=file]").files[0];
        const reader = new FileReader();

        reader.addEventListener(
            "load",
            () => {
                preview.src = reader.result;
            },
            false
        );

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection()