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
                    <!-- foreach($data as $row) -->
                        <form action="{{ route('fields.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="field_id" value="{{ $row->field_id }}">
                            <input type="hidden" name="image_old" value="{{ $row->image }}">
                            <input type="hidden" name="path_now" value="{{ $row->path }}">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card photo-card">
                                        @if ($row->image !== null)
                                            <img src="{{ asset('images/' . $row->image) }}"  class="photo img-fluid" id="imgRead" alt="...">
                                        @else
                                            <img src="/assets/img/cta-bg.jpg" class="photo img-fluid" id="imgRead" alt="...">
                                        @endif
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
                                    <input type="text" class="form-control mb-2" id="field_name" name="field_name" value="{{ $row->field_name }}"  required>
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
                                        placeholder="Input harga sewa per-jam.." name="price"  value="{{ $row->price }}" required>
                                    @error('price')
                                    <div class="valid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{ $row->description }}</textarea>
                                    @error('description')
                                    <div class="valid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="d-grid gap-2 mt-2">
                                    <button type="submit" class="btn btn-primary rounded-pill" type="button">Tambahkan</button>
                                </div>
                            </div>
                        </form>
                    <!-- endforeach -->
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