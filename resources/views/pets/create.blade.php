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
    <h2 class="card-header">Add New Pet</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('pets.index') }}"><i class="fa fa-arrow-left"></i>
                Back</a>
        </div>

        <form action="{{ route('pets.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="inputName" class="form-label"><strong>Name:</strong></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputName"
                    placeholder="Name">
                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputSpecies" class="form-label"><strong>Species:</strong></label>
                <select name="species" id="inputSpecies" class="form-control">
                    @foreach($species as $specie)
                        <option value="{{ $specie->species }}">{{ $specie->species }}</option>
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
                        <option value="{{ $breed->breed }}">{{ $breed->breed }}</option>
                    @endforeach
                </select>
                @error('breed')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="inputAge" class="form-label"><strong>Age:</strong></label>
                <input type="text" name="age" class="form-control @error('age') is-invalid @enderror" id="inputAge"
                    placeholder="Age">
                @error('age')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Owner Details -->
            <h3>Owner Details</h3>
            <div class="form-group">
                <label for="owner_first_name">First Name:</label>
                <input type="text" name="owner[first_name]" id="owner_first_name" class="form-control">
            </div>

            <div class="form-group">
                <label for="owner_surname">Surname:</label>
                <input type="text" name="owner[surname]" id="surname" class="form-control">
            </div>

            <div class="form-group">
                <label for="owner_email">Email:</label>
                <input type="email" name="owner[email]" id="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="owner_phone">Phone:</label>
                <input type="text" name="owner[phone]" id="phone" class="form-control">
            </div>

            <div class="form-group">
                <label for="owner_address">Address:</label>
                <input type="text" name="owner[address]" id="address" class="form-control">
            </div>

            <!-- <div class="mb-3">
                <div class="form-group">
                    <label for="owner_first_name"><strong>Owner First Name:</strong></label>
                    <input type="text" name="owner[first_name]" id="owner_first_name" class="form-control"
                        placeholder="First Name">
                </div>
                @error('owner_first_name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="owner_first_surname"><strong>Owner First Surname:</strong></label>
                    <input type="text" name="owner[first_surname]" id="owner_first_surname" class="form-control"
                        placeholder="First Surname">
                </div>
                @error('owner_first_surname')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="owner_email"><strong>Owner Email:</strong></label>
                    <input type="text" name="owner[email]" id="owner_email" class="form-control" placeholder="Email">
                </div>
                @error('owner_email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="owner_phone"><strong>Owner Phone:</strong></label>
                    <input type="text" name="owner[phone]" id="owner_phone" class="form-control" placeholder="Phone">
                </div>
                @error('owner_phone')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="owner_address"><strong>Owner Address:</strong></label>
                    <input type="text" name="owner[address]" id="owner_address" class="form-control"
                        placeholder="Address">
                </div>
                @error('owner_address')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div> -->
            <br>

            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </form>

    </div>
</div>
<br>
<br>
@endsection