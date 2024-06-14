@extends('pets.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">{{ $pet->name }}</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('pets.index') }}"><i class="fa fa-arrow-left"></i>
                Back</a>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            @foreach ($pet->images as $image)
                <img src="{{ asset('images/pets/' . $image->path) }}" alt="{{ $pet->name }}">
            @endforeach
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Species:</strong> <br />
                    {{ $pet->species }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Breed:</strong> <br />
                    {{ $pet->breed }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Age:</strong> <br />
                    {{ $pet->age }} Years
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Weight:</strong> <br />
                    {{ $pet->weight }} Kg
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h3>Owner Details</h3>
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

    </div>
</div>
<br>
<br>
@endsection