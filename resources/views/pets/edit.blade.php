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
    <h2 class="card-header">Edit Pet</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('pets.index') }}"><i class="fa fa-arrow-left"></i>
                Back</a>
        </div>


        <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="inputName" class="form-label"><strong>Name:</strong></label>
                <input type="text" name="name" value="{{ $pet->name }}"
                    class="form-control @error('name') is-invalid @enderror" id="inputName">
                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputSpecies" class="form-label"><strong>Species:</strong></label>
                <select name="species" id="inputSpecies" class="form-control">
                    @foreach($species as $specie)
                        <option value="{{ $specie->species }}" {{ $pet->species == $specie->species ? 'selected' : '' }}>
                            {{ $specie->species }}
                        </option>
                    @endforeach
                </select>
                @error('species')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputBreed" class="form-label"><strong>Breed:</strong></label>
                <select name="breed" id="inputBreed" class="form-control @error('breed') is-invalid @enderror">
                    @foreach($breeds as $breed)
                        <option value="{{ $breed->breed }}" {{ $pet->breed == $breed->breed ? 'selected' : '' }}>
                            {{ $breed->breed }}
                        </option>
                    @endforeach
                </select>
                @error('breed')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputAge" class="form-label"><strong>Age:</strong></label>
                <input type="text" name="age" value="{{ $pet->age }}"
                    class="form-control @error('age') is-invalid @enderror" id="inputAge">
                @error('age')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputWeight" class="form-label"><strong>Weight:</strong></label>
                <input type="text" name="weight" value="{{ $pet->weight }}"
                    class="form-control @error('weight') is-invalid @enderror" id="inputWeight">
                @error('weight')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputImage" class="form-label"><strong>Image:</strong></label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                    id="inputImage">
                @error('image')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Owner Details -->
            <h3>Owner Details</h3>
            <div class="mb-3">
                <label for="owner_first_name"><strong>First Name:</strong></label>
                <input type="text" name="owner[first_name]" id="owner_first_name" class="form-control"
                    value="{{ $pet->owner->first_name }}">
            </div>

            <div class="mb-3">
                <label for="owner_surname"><strong>Surname:</strong></label>
                <input type="text" name="owner[surname]" id="surname" class="form-control"
                    value="{{ $pet->owner->surname }}">
            </div>

            <div class="mb-3">
                <label for="owner_email"><strong>Email:</strong></label>
                <input type="email" name="owner[email]" id="email" class="form-control"
                    value="{{ $pet->owner->email }}">
            </div>

            <div class="mb-3">
                <label for="owner_phone"><strong>Phone:</strong></label>
                <input type="text" name="owner[phone]" id="phone" class="form-control" value="{{ $pet->owner->phone }}">
            </div>

            <div class="mb-3">
                <label for="owner_address"><strong>Address:</strong></label>
                <input type="text" name="owner[address]" id="address" class="form-control"
                    value="{{ $pet->owner->address }}">
            </div>
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
        </form>


    </div>
</div>
@endsection