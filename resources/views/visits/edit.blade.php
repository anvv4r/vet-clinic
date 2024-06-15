@extends('pets.layout')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card mt-5">
    <h2 class="card-header">Edit Visit Log</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('pets.index') }}"><i class="fa fa-arrow-left"></i>
                Back</a>
        </div>
        <div>
            <h4>{{ $pet_name }}</h4>
        </div>
        <form action="{{ route('visits.update', ['visit' => $visit->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="owner_id" value="{{ $owner_id }}">
            <input type="hidden" name="pet_id" value="{{ $pet_id }}">

            <div class="mb-3">
                <label for="inputDate" class="form-label"><strong>Date:</strong></label>
                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                    value="{{ $date }}">
                @error('date')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputReport" class="form-label"><strong>Report:</strong></label>
                <textarea name="report" class="form-control @error('report') is-invalid @enderror"
                    id="inputReport">{{ $report }}</textarea>
                @error('report')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </form>

    </div>
</div>
<br>
<br>
@endsection