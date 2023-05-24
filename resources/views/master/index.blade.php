@extends('master.layouts.main')

@section('title','CakStore | Admin')

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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-primary rounded-pill">Tambahkan</button>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <canvas id="myChart" style="widht='400px'; height='100px';"></canvas>
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
    $(function () {
        var ctx = document.getElementById("myChart").getContext("2d");
        var json_url = "{{ route('dasboard.grupby-mounts') }}";
        
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Booking",
                        fill: false,
                        lineTension: 0.2,
                        borderColor: "rgba(242, 87, 134,1)",
                        backgroundColor: "rgba(242, 87, 134, 0.4)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 3,
                        pointHoverRadius: 5,
                        pointBorderColor: "rgba(66, 173, 245, 0.5)",
                        pointHoverBackgroundColor: "rgba(242, 87, 134, 1)",
                        pointHoverBorderColor: "rgba(242, 87, 134, 1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: [],
                        spanGaps: false,
                    }
                ]
            },
            options: {
                tooltips: {
                    mode: 'index',
                    intersect: true
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                    }
                }
            }
        });

        ajax_chart(myChart, json_url);

        function ajax_chart(chart, url, data) {
            var data = data || [];
            $.getJSON(url, data).done(function(response) {
                chart.data.labels = response.labels;
                chart.data.datasets[0].data = response.quantity;
                chart.update(); 
            });
        }
    });
</script>
 
@endsection