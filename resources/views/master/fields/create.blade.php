@extends('master.layouts.main')

@section('title','Lapangan')

@section('content')
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Tambah Lapangan</h3>
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
                <div class="row">
                    <div class="col">
                    <div class="card p-3">
                        <form action="{{ route('fields.save')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card photo-card">
                                        <img src="/assets/img/cta-bg.jpg" class="photo img-fluid" id="imgRead" />
                                        <div class="photo-overlay">
                                            <i class="bi bi-cloud-arrow-up"></i>
                                            <div class="image-upload">
                                            <input type="file" id="image" name="image" accept="image/png, image/jpg, image/jpeg" onchange="previewFile()" />
                                            </div>
                                        </div>
                                    </div>
                                    @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="field_name">Lapangan</label>
                                    <input type="text" class="form-control mb-2" id="field_name" name="field_name" value="{{ old('field_name') }}" placeholder="Nama Lapangan" required>
                                    @error('field_name')
                                    <div class="valid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="price">Price</label>
                                    <input type="text" class="form-control" id="price"
                                        placeholder="Harga sewa per-jam.." name="price"  value="{{ old('price') }}" required>
                                    @error('price')
                                    <div class="valid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control"  name="description" id="description" cols="30" rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="valid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary rounded-pill" type="button">Tambahkan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </section>
        </div>

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
@endsection