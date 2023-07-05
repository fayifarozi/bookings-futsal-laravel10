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
                                <img src="{{ asset('images/' . $futsalFields->image) }}" class="card-img" alt="...">
                            @else
                                <img src="/assets/img/cta-bg.jpg" class="card-img" alt="...">
                            @endif
                            <div class="card-body">
                                <h1>{{ $futsalFields->field_name }}</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, quod! Sed, repudiandae! Perferendis, numquam odit odio harum officiis illum perspiciatis doloribus sapiente, rerum fugit cupiditate consequatur adipisci autem deleniti ad?</p>
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
                            <label for="phone" class="form-label">Nomer WA</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="text" onfocus="(this.type = 'date')" class="form-control" id="tanggal" name="tanggal">
                            <div id=" tangalHelp" class="form-text">Catatan : Harap pilih tanggal terlebih dahulu sebelum memilih waktu.
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="captcha">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <div class="form-group mb-4">
                                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                            </div>
                        </div>

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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).on("click", "#reload", function () {
        $.ajax({
            type: 'GET',
            url: "{{ route('reloadCaptcha')}}",
            success: function (response) {
                $(".captcha span").html(response.captcha);
            }
        });
    });

    $(document).on("click", ".card-time", function () {
        var checkbox = $(this).find('input[type="checkbox"]');
        if (checkbox.is(":checked")) {
            checkbox.closest(".card-time").addClass("active");
        } else {
            checkbox.closest(".card-time").removeClass("active");
        }
    });

    $(document).ready(() => {
        $("#tanggal").change(() => {
            let selectedField = $('#field_id').val();
            let selectedDate = $('#tanggal').val();
            $.ajax({
                url: "{{ route('timeRequest') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    lapangan: selectedField,
                    tanggal: selectedDate
                },
                success: function(response) {
                    console.log(response.data);
                    if (response.data) {
                        $('input[type="checkbox"]').prop('checked', false);
                        $('.card-time').removeClass('active');
                        
                        $('input[type="checkbox"]').each(function() {
                            let $element = $(this).val();
                            if ($.inArray($element, response.data) != -1) {
                                $(this).prop('disabled', false);
                                $(this).closest(".card-time").closest(".card-time").removeClass("disabled");
                            } else {
                                $(this).prop('disabled', true);
                                $(this).closest(".card-time").closest(".card-time").addClass("disabled");
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