@extends('layouts.index')

@section('title','CakStore | Admin')

@section('content')

<div id="main" class="container" data-aos="fade-up">
    <section id="order-list">
        <form action="{{ route('StoreBooking')}}" method="post">
            @csrf
            <input type="hidden" id="field_id" name="field_id" value="{{ $futsalFields->field_id }}">
            <input type="hidden" id="fieldPrice" name="fieldPrice" value="{{ $futsalFields->price }}">
            <div class="row p-3">
                <div class="col-lg-6">
                    <div class="card border-0">
                        <div class="card-content">
                            @if ($futsalFields->image !== null)
                                <img src="{{ asset('images/' . $futsalFields->image) }}" class="card-img-top" alt="...">
                            @else
                                <img src="/assets/img/cta-bg.jpg" class="card-img-top" alt="...">
                            @endif
                            <div class="row">
                                <div class="col-12">
                                    <h1>Lorem ipsum dolor sit.</h1>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, quod! Sed, repudiandae! Perferendis, numquam odit odio harum officiis illum perspiciatis doloribus sapiente, rerum fugit cupiditate consequatur adipisci autem deleniti ad?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row p-3">
                        <div class="col-6">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                            <div id=" tangalHelp" class="form-text">Note : Please Select the Futsal field before entering the date.
                            </div>
                        </div>
                        <div class=" col-12 mb-3">
                            <div class="row row-col-auto">
                                <label class="form-label">Jam Booking</label>
                                @foreach($times as $time)
                                <div class="col-2 p-2">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <input class="form-check-input" type="checkbox" value="{{ $time }}" disabled id="time-{{ $loop->iteration }}" name="time[]">
                                            <label class="form-check-label" for="time-{{ $loop->iteration }}">
                                                {{ $time }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    <!-- <div class="col-12 d-flex justify-content-end">
                    </div> -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(() => {
        $("#tanggal").change(() => {
            let selectedField = $('#field_id').val();
            let selectedDate = $('#tanggal').val();
            $.ajax({
                url: "{{ route('timeRequest')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    lapangan: selectedField,
                    tanggal: selectedDate
                },
                success: function(response) {
                    console.log(response.data);
                    if (response.data) {
                        //tambahkan kelas disable pada input type checkbox
                        $('input[type="checkbox"]').each(function() {
                            let $element = $(this).val();
                            if ($.inArray($element, response.data) != -1) {
                                $(this).prop('disabled', false);
                            } else {
                                $(this).prop('disabled', true);
                            }
                        });
                    } else {
                        console.log("data doesn't exists");
                    };
                },
                error: function(response) {
                    console.log(response);
                }
            });
        })
    })
</script>
@endsection