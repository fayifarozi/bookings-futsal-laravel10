@extends('master.layouts.main')

@section('title','Admin')

@section('content')
<div class="page-heading">
    <h3>Tambah Admin</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card p-3">
            <form action="{{ route('admin.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-4 mr-1" align="center">
                        <div class="card avatar photo-card border-0 rounded-circle mb-0" style="width:300px;">
                            <img src="{{ asset('/assets/img/team/team-1.jpg')}}" class="photo img-fluid" id="imgRead"/>
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
                                <input type="text" class="form-control mb-2" id="name" name="name" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="email">Email</label>
                                <input type="text" class="form-control mb-2" id="email" name="email" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid gap-2 pt-4">
                                <button type="submit" class="btn btn-primary rounded-pill" type="button">Tambahkan</button>
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
<script type='text/javascript'>
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