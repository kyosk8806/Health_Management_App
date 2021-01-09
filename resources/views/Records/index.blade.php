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
                    <a class="btn btn-outline-success" href="../{{ $prev_month }}/{{ $prev_year }}"><i class="fas fa-angle-double-left"></i></a>
                    <span>{{ $month }} / {{ $year }}</span>
                    <a class="btn btn-outline-success" href="../{{ $next_month }}/{{ $next_year }}"><i class="fas fa-angle-double-right"></i></a>
                </div>
            </div>
        </div>
        <!-- End Month/Year pagination -->
    
        <!-- Table -->
        <table class="table" id="datatable" >
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
                    <td>{{ $record->weight }}kg</td>
                    <td>{{ $record->step }}steps</td>
                    <td>{{ $record->exercise }}</td>
                    <td>{{ $record->note }}</td>
                    <td>
                        <a href="{{ route('records.edit', $record->id) }}" class="btn btn-outline-primary edit"><i class="fas fa-edit"></i></a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i>
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
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('records.destroy', $record->id) }}" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" name="_method" value="DELETE"/>
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


<!-- Edit Modal -->
<!-- <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
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
</div> -->
<!-- End Edit Modal -->


<!-- <script>
function delete_confirm() {
    var select = confirm("Are you sure you want to delete this item?");
    return select;
}
</script> -->

@endsection
