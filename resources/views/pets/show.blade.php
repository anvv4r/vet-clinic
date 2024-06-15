@extends('pets.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">{{ $pet->name }}</h2>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('pets.edit', $pet->id) }}"><i
                    class="fa-solid fa-pen-to-square"></i>
                Edit</a>
            <a class="btn btn-success btn-sm"
                href="{{ route('visits.create', ['owner_id' => $pet->owner->id, 'pet_id' => $pet->id]) }}">
                <i class="fa fa-plus"></i> Visit Log</a>
            <a class="btn btn-primary btn-sm" href="{{ route('pets.index') }}">Home</a>
        </div>
        <div class="card-body d-flex gap-3 flex-row justify-content-start align-items-start">
            <div style="max-width: 30%;">
                @foreach ($pet->images as $image)
                    <img src="{{ asset('images/pets/' . $image->path) }}" alt="{{ $pet->name }}" class="img-fluid">
                @endforeach
            </div>

            <div class="d-flex gap-3 flex-column justify-content-start align-items-start">

                <div class="d-flex gap-3 flex-row justify-content-start align-items-start">
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Species:</strong> <br />
                            {{ $pet->species }}
                        </div>
                        <div class="form-group">
                            <strong>Breed:</strong> <br />
                            {{ $pet->breed }}
                        </div>
                        <div class="form-group">
                            <strong>Age:</strong> <br />
                            {{ $pet->age }} Years
                        </div>
                        <div class="form-group">
                            <strong>Weight:</strong> <br />
                            {{ $pet->weight }} Kg
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Owner Name:</strong> <br />
                            {{ $pet->owner->first_name }} {{ $pet->owner->surname }}
                        </div>
                        <div class="form-group">
                            <strong>Owner Email:</strong> <br />
                            {{ $pet->owner && $pet->owner->email ? $pet->owner->email : 'No email' }}
                        </div>
                        <div class="form-group">
                            <strong>Owner Address:</strong> <br />
                            {{ $pet->owner && $pet->owner->address ? $pet->owner->address : 'No address' }}
                        </div>
                    </div>

                </div>
                <div class="col-12 col-sm-12 col-md-12">
                    <h4>Visit Records</h4>
                    @foreach($pet->visits as $visit)
                        <div class="form-group">
                            <strong>Date:</strong> {{ $visit->date }}<br />
                            <strong>Report:</strong><br />
                            {{ $visit->report }}

                            <a
                                href="{{ route('visits.edit', ['owner_id' => $visit->pet->owner->id, 'pet_id' => $visit->pet->id]) }}">Edit</a>
                            |
                            <a href="{{ route('visits.destroy', $visit->id) }}" onclick="event.preventDefault(); 
                                                                 if(confirm('Are you sure you want to delete this visit?')) {
                                                                     document.getElementById('delete-form-{{ $visit->id }}').submit();
                                                                 }">Delete</a>

                            <form id="delete-form-{{ $visit->id }}" action="{{ route('visits.destroy', $visit->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</div>
<br>
<br>
@endsection