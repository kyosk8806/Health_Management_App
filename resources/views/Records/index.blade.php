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
            <a class="btn" href="../{{ $month }}/{{ $year }}" role="button" style="color:white;background-color:#00b3b3">
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
        <!-- Table -->
        <table class="table" id="datatable"> 
            <thead>
                <tr class="table_scope">
                    <th scope="col" width="20%">Date</th>
                    <th scope="col" width="15%">Weight</th>
                    <th scope="col" width="15%">Steps</th>
                    <th scope="col" width="15%">Exercise</th>
                    <th scope="col" width="25%">Notes</th>
                    <th scope="col" width="5%">Action</th>
                    <th scope="col" width="5%"></th>
                </tr>
            </thead>

            <tbody>         
            @foreach ($records as $record)
                <tr class="table_data">
                    <th>{{ $record->date }}</th>
                    <td>{{ $record->weight }} kg</td>
                    <td>{{ $record->step }} steps</td>
                    <td>{{ $record->exercise }}</td>
                    <td>{{ $record->note }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" 
                            data-edit_uri="{{ route('records.update', $record->id) }}"
                            data-date="{{ $record->date }}"
                            data-weight="{{ $record->weight }}"
                            data-step="{{ $record->step }}"
                            data-exercise="{{ $record->exercise }}"
                            data-note="{{ $record->note }}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-delete_uri="{{ route('records.destroy', $record->id) }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- End Table -->
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
                <label>Target Weight</label>
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


