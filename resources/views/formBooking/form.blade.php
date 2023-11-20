@extends('layouts.index')

@section('title','CakStore | Admin')

@section('content')

<div id="main" class="container" data-aos="fade-up">
    <section id="order-list">
        
        <div class="row row-cols-auto mt-3">
            <div class="col-12">
                <h1>PILIH LAPANGAN</h1>
            </div>
            @foreach( $futsalFields as $field)
            <div class="col p-3">
                <div class="card shadow text-center" style="width: 18rem;">
                    @if ($field->image !== null)
                        <img src="{{ asset('images/' . $field->image) }}" class="card-img-top" alt="...">
                    @else
                        <img src="/assets/img/cta-bg.jpg" class="card-img-top" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title" id="field">{{ $field->field_name }}</h5>
                        <p class="card-text" id="price"><sup>Rp</sup> {{ $field->price }}</p>
                        <!-- <a href="{{ route('BookingTime',['path' => $field->path ])}}" class="btn btn-primary">Booking</a> -->
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
        <form action="{{ route('StoreBooking')}}" method="post">
            @csrf
            <div class="row p-3">
                <div class="col-lg-12">
                    <div class="row p-3">
                        <div class="col-6">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="valid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label for="phone" class="form-label">Nomer WA</label>
                            <input type="text" class="form-control" id="phone" name="phone"  value="{{ old('phone') }}">
                            @error('phone')
                            <div class="valid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"  value="{{ old('email') }}">
                            @error('email')
                            <div class="valid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="text" onfocus="(this.type = 'date')" class="form-control" id="tanggal" name="tanggal">
                            <div id=" tangalHelp" class="form-text">Catatan : Harap pilih tanggal terlebih dahulu sebelum memilih waktu.
                            </div>
                            @error('tanggal')
                            <div class="valid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                        <!-- <div class="col-6 mb-3">
                            <div class="captcha">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>
                        </div> -->
<!--                         
                        <div class="col-6 mb-3">
                            <div class="form-group mb-4">
                                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                            </div>
                        </div> -->

                        <div class=" col-12 mb-3">
                            <div class="row row-col-auto">
                                <label class="form-label">Jam Booking</label>
                                @foreach($times as $index => $time)
                                <div class="col-3 p-2">
                                    <div class="card card-time disabled">
                                        <label class="form-check-label" for="time-{{ $loop->iteration }}">
                                        <input class="form-check-input" type="checkbox" value="{{ $time }}" disabled id="time-{{ $loop->iteration }}" name="time[]">
                                            <div class="card-body text-center">
                                                {{ $time }}
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary">Pesan</button>
                </div>
            </div>
        </form>
        </div>
    </section>
</div>
@endsection