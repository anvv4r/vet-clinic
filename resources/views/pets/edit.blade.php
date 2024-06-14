@extends('pets.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Edit Pet</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('pets.index') }}"><i class="fa fa-arrow-left"></i>
                Back</a>
        </div>

        <form action="{{ route('pets.update', $pet->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="inputName" class="form-label"><strong>Name:</strong></label>
                <input type="text" name="name" value="{{ $pet->name }}"
                    class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Name">
                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputSpecies" class="form-label"><strong>Species:</strong></label>
                <input type="text" name="species" value="{{ $pet->species }}"
                    class="form-control @error('species') is-invalid @enderror" id="inputSpecies" placeholder="Species">
                @error('species')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputBreed" class="form-label"><strong>Breed:</strong></label>
                <input type="text" name="breed" value="{{ $pet->breed }}"
                    class="form-control @error('breed') is-invalid @enderror" id="inputBreed" placeholder="Breed">
                @error('breed')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputAge" class="form-label"><strong>Age:</strong></label>
                <input type="text" name="age" value="{{ $pet->age }}"
                    class="form-control @error('age') is-invalid @enderror" id="inputAge" placeholder="Age">
                @error('age')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputOwner" class="form-label"><strong>Owner:</strong></label>
                <input type="text" name="owner" value="{{ $pet->owner->first_name }}"
                    class="form-control @error('owner') is-invalid @enderror" id="inputOwner" placeholder="Owner">
                @error('owner')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
        </form>

    </div>
</div>
@endsection