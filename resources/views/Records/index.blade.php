@extends('layouts.app')

@section('content')

<div class="container">
    <!-- Header -->
    <div class="row header">
        <div class="col-md">
            <h1>MY PAGE</h1>
        </div>
    </div>
    <!-- End Header -->

    <div class="row-inner">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
            CREATE
        </button>

        <!-- Month/Year pagination -->
        <div class="row justify-content-center">
            <div class="col-md-12" style="margin-bottom:20px">
                <div class="header text-center">
                    <a class="btn btn-success" href="../{{ $prev_month }}/{{ $prev_year }}"><<</a>
                    <span>{{ $month }} / {{ $year }}</span>
                    <a class="btn btn-success" href="../{{ $next_month }}/{{ $next_year }}">>></a>
                </div>
            </div>
        </div>
        <!-- End Month/Year pagination -->
    
        <!-- Table -->
        <table class="table" id="datatable" >
            <thead>
                <tr class="table_scope">
                    <th class="date" scope="col" width="20%">Date</th>
                    <th class="weight" scope="col" width="15%">Weight</th>
                    <th class="steps" scope="col" width="15%">Steps</th>
                    <th class="exercise" scope="col" width="15%">Exercise</th>
                    <th class="notes" scope="col" width="25%">Notes</th>
                    <th class="edit" scope="col" width="5%">Edit</th>
                    <th class="del" scope="col" width="5%"></th>
                </tr>
            </thead>

            <tbody>            
            @foreach ($records as $record)
                <tr class="table_data">
                    <th class="date" scope="row">{{ $record->date }}</th>
                    <td class="weight">{{ $record->weight }}kg</td>
                    <td class="step">{{ $record->step }}steps</td>
                    <td class="exercise">{{ $record->exercise }}</td>
                    <td class="note">{{ $record->note }}</td>
                    <td class="edit">
                        <a href="{{ route('records.edit', $record->id) }}" class="btn btn-primary edit">Edit</a>
                    </td>
                    <td class="del">
                        <form action="{{ route('records.destroy', $record->id) }}" method="POST"　onsubmit="return delete_confirm()">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Del" class="btn btn-danger">
                        </form>
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
      <form action="#" method="POST" autocomplete="off" id="editForm">
        @csrf
        @method('PUT')
        <div class="modal-body">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" id="datepicker" class="form-control" value="{{ old('date') }}">
                </div>
                <div class="form-group">
                    <label>Weight</label>
                    <input type="text" name="weight" id="weight" class="form-control" value="{{ old('weight') }}">
                </div>
                <div class="form-group">
                    <label>Steps</label>
                    <input type="text" name="step" id="step" class="form-control" value="{{ old('step') }}">
                </div>
                <div class="form-group">
                    <label>Exercise</label>
                        <select class="form-control" id="sel02" name="exercise" value="{{ old('exercise') }}">
                            <option selected>Yes</option>
                            <option>No</option>
                        </select>
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <input type="text" name="note" id="note" class="form-control">
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

<script type="text/javascript">

    $(document).ready(function () {

        var table = $('#datatable').DataTable();

        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            // $('#datepicker').val(data[1]);
            $('#weight').val(data[2]);
            // $('#step').val(data[3]);
            // $('#sel02').val(data[4]);
            // $('#note').val(data[5]);

            $('#editForm').attr('action', '/records/edit');
            $('#editModal').modal('show');


        });
    });


// function delete_confirm() {
//     var select = confirm("Are you sure you want to delete this item?");
//     return select;
// }
</script>

@endsection
