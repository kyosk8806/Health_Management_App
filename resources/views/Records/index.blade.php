@extends('layouts.app')

@section('content')

<!-- Header -->
<div class="container">
    <div class="row header">
        <div class="col-md">
            <h1>MY PAGE</h1>
        </div>
    </div>

    <!-- Top -->
    <div class="row top h-auto">
        <div class="col-md">{{ $month }} / </div>
        <a href="./{{ $prev_month }}"> 
            <h4><< {{ $prev_month }}</h4>
        </a>
        <a href="./{{ $next_month }}">
            <h4>{{ $next_month }}>></h4>
        </a>
    </div>

    <div class="row-inner">
        <!-- Input Form -->
        <div class="form">
            <h2>Please Enter</h2>
            <form action="{{ route('records.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-row" style="margin-bottom:20px">
                    <div class="col">
                        <input type="date" name="date" id="datepicker" class="form-control" placeholder="Date" value="{{ old('date') }}">
                    </div>
                    <div class="col">
                        <input type="text" name="weight" class="form-control" placeholder="Weight" value="{{ old('weight') }}">
                        @error('weight')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col">
                        <input type="text" name="step" class="form-control" placeholder="Steps" value="{{ old('step') }}">
                    </div>
                    <div class="col">
                        <select class="form-control" id="sel01" name="exercise" placeholder="Exercise" value="{{ old('exercise') }}">
                            <option selected>Exercise</option>
                            <option>Yes</option>
                            <option>No</option>
                        </select>
                    </div>
                    <div class="col">
                        <input type="text" name="note" class="form-control" placeholder="Note">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    
        <!-- Tab -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
            <a href="#" class="nav-link active" data-toggle="tab">MY DATA</a>
            </li>
            <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="tab">GRAPH</a>
            </li>
        </ul>
    
        <!-- Tab content -->
        <div class="tab-content">
            <div id="tab1" class="tab-pane active">
                <table class="table">
                    <thead>
                        <tr class="table_scope">
                            <th class="date" scope="col">Date</th>
                            <th class="weight" scope="col">Weight</th>
                            <th class="steps" scope="col">Steps</th>
                            <th class="exercise" scope="col">Exercise</th>
                            <th class="notes" scope="col">Notes</th>
                            <th class="edit" scope="col">Del</th>
                        </tr>
                    </thead>

                    <tbody>            
                    @foreach ($records as $record)
                        <tr class="table_data">
                            <th class="date" scope="row">{{ $record->date }}</th>
                            <td class="weight">{{ $record->weight }}kg</td>
                            <td class="steps">{{ $record->step }}steps</td>
                            <td class="exercise">{{ $record->exercise }}</td>
                            <td class="notes">{{ $record->note }}</td>
                            <td class="edit"> 
                                <form action="{{ route('records.destroy', $record->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="DEL" class="btn btn-danger">
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection