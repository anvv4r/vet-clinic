@extends('pets.layout')

@section('content')

<div class="d-flex justify-content-between mt-4">
    <form class="d-flex" action="{{ route('pets.index') }}" method="GET">
        <input class="form-control me-2" type="search" placeholder="Search Pet or Owner" aria-label="Search"
            name="search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    @if(request()->query('search'))
        <a class="btn btn-primary" href="{{ route('pets.index') }}"><i class="fa fa-arrow-left"></i> Pet Lists</a>
    @else
        <a class="btn btn-primary" href="{{ url('/') }}">Home</a>
    @endif
</div>

<div class="card mt-5">
    <h2 class="card-header">Pet List</h2>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
        @endif

        @if(Auth::check() && Auth::user()->role == 'admin')
            <!-- Show edit and delete buttons only for admin -->

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-success btn-sm" href="{{ route('pets.create') }}"> <i class="fa fa-plus"></i> New Pet</a>
            </div>

        @endif


        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th width="55px">ID</th>
                    <th>Name</th>
                    <th>Species</th>
                    <th>Breed</th>
                    <th>Age</th>
                    <th>Weight</th>
                    <th>Owner</th>
                    <th width="auto">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pets as $pet)
                    <tr>
                        <td>{{ $pet->id }}</td>
                        <td>{{ $pet->name }}</td>
                        <td>{{ $pet->species }}</td>
                        <td>{{ $pet->breed }}</td>
                        <td>{{ $pet->age }}</td>
                        <td>{{ $pet->weight }}</td>
                        <td>{{ $pet->owner ? $pet->owner->first_name . ' ' . $pet->owner->surname : 'No owner' }}</td>
                        <td>
                            <form id="delete-form-{{ $pet->id }}" action="{{ route('pets.destroy', $pet->id) }}"
                                method="POST">

                                <a class="btn btn-info btn-sm" href="{{ route('pets.show', $pet->id) }}"><i
                                        class="fa-solid fa-list"></i> Show</a>

                                @if(Auth::check() && Auth::user()->role == 'admin')
                                    <!-- Show edit and delete buttons -->


                                    <a class="btn btn-primary btn-sm" href="{{ route('pets.edit', $pet->id) }}"><i
                                            class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <a class="btn btn-success btn-sm"
                                        href="{{ route('visits.create', ['owner_id' => $pet->owner->id, 'pet_id' => $pet->id]) }}">
                                        <i class="fa fa-plus"></i> Visit Log</a>

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" onclick="event.preventDefault(); 
                                                                                                                    if(confirm('Are you sure you want to delete this pet record?')) {
                                                                                                                        document.getElementById('delete-form-{{ $pet->id }}').submit();
                                                                                                                    }">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>

                                @endif

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