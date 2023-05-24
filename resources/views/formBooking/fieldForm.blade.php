@extends('layouts.index')

@section('title','CakStore | Admin')

@section('content')

<div id="main" class="container" data-aos="fade-up">
    <section id="order-list">
        <div class="row row-cols-auto mt-3">
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
                        <a href="{{ route('BookingTime',['path' => $field->path ])}}" class="btn btn-primary">Booking</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection