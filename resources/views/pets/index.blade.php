@extends('pets.layout')

@section('content')

<div class="d-flex justify-content-between mt-4">
    <form class="d-flex" action="{{ route('pets.index') }}" method="GET">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    @if(request()->query('search'))
        <a class="btn btn-primary" href="{{ route('pets.index') }}">Home</a>
    @endif

</div>

<div class="card mt-5">
    <h2 class="card-header">Pet List</h2>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
        @endif

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('pets.create') }}"> <i class="fa fa-plus"></i> Submit
                New Pet</a>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Name</th>
                    <th>Species</th>
                    <th>Breed</th>
                    <th>Age</th>
                    <th>Owner</th>
                    <th width="250px">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pets as $pet)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $pet->name }}</td>
                        <td>{{ $pet->species }}</td>
                        <td>{{ $pet->breed }}</td>
                        <td>{{ $pet->age }}</td>
                        <td>{{ $pet->owner ? $pet->owner->first_name : 'No owner' }}</td>
                        <td>
                            <form action="{{ route('pets.destroy', $pet->id) }}" method="POST">

                                <a class="btn btn-info btn-sm" href="{{ route('pets.show', $pet->id) }}"><i
                                        class="fa-solid fa-list"></i> Show</a>

                                <a class="btn btn-primary btn-sm" href="{{ route('pets.edit', $pet->id) }}"><i
                                        class="fa-solid fa-pen-to-square"></i> Edit</a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                                    Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">There are no data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {!! $pets->links() !!}
    </div>

</div>
<br>
<br>
@endsection