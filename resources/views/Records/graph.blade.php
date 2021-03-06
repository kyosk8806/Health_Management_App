@extends('layouts.app')

@section('content')

<link href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" rel="stylesheet">

<div class="container">
    <!-- Header -->
    <div class="row header">
        <div class="col-md">
            <h1>MY PAGE</h1>
        </div>
    </div>
    <div class="content-wrapper" style="padding-bottom:20px;">
        <div class="row" style="margin:auto">
            <div class="col-lg-3 col-4 text-white">
                <!-- small box -->
                <div class="shadow p-1 mb-4 rounded bg-primary">
                    <div class="inner" style="padding-left:5px;">
                        <p>Weight</p>
                        <h3>{{ $latest_record }} kg</h3>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-4 text-white">
                <!-- small box -->
                <div class="shadow p-1 mb-4 rounded bg-success">
                    <div class="inner" style="padding-left:5px;">
                        <p>BMI</p>    
                        <h3>{{ $bmi }} : <span style="font-size : small">{{ $msg }}</spam></h3>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-4">
                <!-- small box -->
                <div class="shadow p-1 mb-4 rounded bg-warning">
                    <div class="inner text-black" style="padding-left:5px;">
                        <p>Goal</p>
                        <h3>{{ $target }} kg</h3>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-4 text-white">
                <!-- small box -->
                <div class="shadow p-1 mb-4 rounded bg-info">
                    <div class="inner" style="padding-left:5px;">
                        <p>Goal Until</p>
                        <h3>{{ $latest_record - $target }} kg</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header -->

    <!-- Button trigger modal -->
    <div class="d-flex justify-content-between" style="margin-bottom:10px">
        <div class="col-md-12 align-self-left">
            <button type="button" class="btn" data-toggle="modal" data-target="#createModal" style="color:white;background-color:#1a1aff">
                CREATE
            </button>
            <a class="btn" href="/{{ $month }}/{{ $year }}" role="button" style="color:white;background-color:#00b3b3">
                TABLE
            </a>
            <a class="btn" href="/graph/{{ $month }}/{{ $year }}" role="button" style="color:white;background-color:#1a1aff">
                GRAPH
            </a>
            <button type="button" class="btn" data-toggle="modal" data-target="#profileModal" style="color:white;background-color:#00b3b3"
                data-edit_uri="{{ route('records.profileUpdate', $user_data['id']) }}"
                data-name="{{ $user_data['name'] }}"
                data-age="{{ $user_data['age'] }}"
                data-height="{{ $user_data['height'] }}"
                data-target_weight="{{ $user_data['target_weight'] }}">
                PROFILE
            </button>
            <a class="btn" href="/csv/{{ $month }}/{{ $year }}" role="button" style="color:white;background-color:#1a1aff">
                CSV
            </a>
        </div>
    </div>

    <!-- Month/Year pagination -->
    <div class="d-flex justify-content-between" style="margin-bottom:20px">
        <div class="col-md-12 align-self-center">
            <div class="header text-center">
                <a class="btn btn-success" href="../{{ $prev_month }}/{{ $prev_year }}"><i class="fas fa-angle-double-left"></i></a>
                <span>{{ $month }} / {{ $year }}</span>
                <a class="btn btn-success" href="../{{ $next_month }}/{{ $next_year }}"><i class="fas fa-angle-double-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row-inner" style="width: 100%; height: 700px; overflow-y:scroll;">
        <div class="chart-container" style="position: relative; width: 100%; height: 500px;">
            <!-- Graph-->
            <canvas id="myChart"></canvas>
            <script>
                window.onload = function() {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'bar',// graph type
                        data: {
                            labels: @json($date),
                            datasets: [{
                                type: 'line',
                                label: 'Weight',
                                data: @json($weight),
                                borderColor: "rgb(54, 162, 235)",
                                borderWidth: 3,
                                fill: false,
                                yAxisID: "y-axis-1",
                            }, {
                                type: 'bar',
                                label: 'Step',
                                data: @json($step),
                                borderColor: "rgb(255, 99, 132)",
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                yAxisID: "y-axis-2",
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            scales: {
                                yAxes: [{
                                    id: "y-axis-1",
                                    type: "linear",
                                    position: "left",
                                    ticks: {
                                        max: @json($target + 5),
                                        min: @json($target - 1),
                                        stepSize: 0.5
                                    }
                                }, {
                                    id: "y-axis-2",
                                    type: "linear",
                                    position: "right",
                                    gridLines: {
                                        drawOnChartArea: false,
                                    }
                                }]
                            },
                            annotation: {
                                annotations:[
                                    {
                                        type: 'line', // 線分を指定
                                        drawTime: 'afterDatasetsDraw',
                                        id: 'a-line-1', // 線のid名を指定（他の線と区別するため）
                                        mode: 'horizontal', // 水平を指定
                                        scaleID: 'y-axis-1', // 基準とする軸のid名
                                        value: @json($target), // 引きたい線の数値（始点）
                                        endValue: @json($target), // 引きたい線の数値（終点）
                                        borderColor: 'red', // 線の色
                                        borderWidth: 3, // 線の幅（太さ）
                                        borderDash: [2, 2],
                                        borderDashOffset: 1,
                                        label: { // ラベルの設定
                                            backgroundColor: 'rgba(255,255,255,0.8)',
                                            bordercolor: 'rgba(200,60,60,0.8)',
                                            borderwidth: 2,
                                            fontSize: 10,
                                            fontStyle: 'bold',
                                            fontColor: 'rgba(200,60,60,0.8)',
                                            xPadding: 10,
                                            yPadding: 10,
                                            cornerRadius: 3,
                                            position: 'left',
                                            xAdjust: 0,
                                            yAdjust: 0,
                                            enabled: true,
                                            content: 'Goal'
                                        }
                                    }
                                ]
                            }
                        }
                    })
                };
            </script>
        </div>
        <!-- End Graph -->
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Record Your Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('records.store') }}" method="POST" autocomplete="off" >
        @csrf　
        <div class="modal-body">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" id="datepicker" class="form-control" value="{{ old('date') }}">
                </div>
                <div class="form-group">
                    <label>Weight</label>
                    <input type="text" name="weight" class="form-control" value="{{ old('weight') }}">
                </div>
                <div class="form-group">
                    <label>Steps</label>
                    <input type="text" name="step" class="form-control" value="{{ old('step') }}">
                </div>
                <div class="form-group">
                    <label>Exercise</label>
                        <select class="form-control" id="sel01" name="exercise" value="{{ old('exercise') }}">
                            <option selected>Yes</option>
                            <option>No</option>
                        </select>
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <input type="text" name="note" class="form-control">
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Create Modal -->

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure? You want to delete data.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Your Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form" action="" method="POST" autocomplete="off">
        @csrf
        @method('PATCH')
        <div class="modal-body">
            <div class="form-group">
                <label>Date</label>
                <input class="form-control" id="date" type="date" name="date" value="" readonly>
            </div>
            <div class="form-group">
                <label>Weight</label>
                <input class="form-control" id="weight" type="text" name="weight" value="">
            </div>
            <div class="form-group">
                <label>Steps</label>
                <input class="form-control" id="step" type="text" name="step" value="">
            </div>
            <div class="form-group">
                <label>Exercise</label>
                <select class="form-control" id="exercise" name="exercise" value="">
                    <option selected>Yes</option>
                    <option>No</option>
                </select>
            </div>
            <div class="form-group">
                <label>Notes</label>
                <input class="form-control" id="note" type="text" name="note" value="">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Edit Modal -->

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel">Edit Your Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form" action="" method="POST" autocomplete="off">
        @csrf
        @method('PATCH')
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" id="name" type="text" name="name" value="">
            </div>
            <div class="form-group">
                <label>Age</label>
                <input class="form-control" id="age" type="text" name="age" value="">
            </div>
            <div class="form-group">
                <label>Height (m)</label>
                <input class="form-control" id="height" type="text" name="height" value="">
            </div>
            <div class="form-group">
                <label>Target Weight (kg)</label>
                <input class="form-control" id="target_weight" type="text" name="target_weight" value="">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Profile Modal -->
@endsection

<!-- jQueryをCDNから読み込み -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.7/chartjs-plugin-annotation.min.js'></script>
<script src="{{ asset('js/modal.js') }}"></script>


