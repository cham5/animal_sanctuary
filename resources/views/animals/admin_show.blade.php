@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="/animals/staff" class="btn btn-primary">Back to All Animals</a>
        <br><br>
        <!-- display success message -->
        @if(\Session::has('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ \Session::get('success') }}</strong>
            </div>
            <br>
        @endif
        <!-- display errors -->
        @if($errors->any())
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <br>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Details for {{ $animal->name }}</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr><th>Date of Birth</th><td>{{ $animal->dob }}</td></tr>
                            <tr><th>Description</th><td>{{ $animal->description }}</td></tr>
                            <tr><th>Availability</th>
                            @if($animal->availability == 'Unavailable')
                                <?php
                                    $adoptionRequest = App\Models\AdoptionRequest::where('animal_id', $animal->id)
                                    ->where('status', 'Approved')->first();
                                    $adopter = App\Models\User::find($adoptionRequest->user_id);
                                ?>
                                <td> Adopted by: {{ $adopter->name }} </td>
                            @else
                                <td> {{ $animal-> availability }} </td>
                            @endif
                            </tr>
                            <tr><td colspan="2"><img style="width:100%;height:100%" 
                            src="{{asset('storage/images/'.$animal->picture)}}"></td></tr>
                        </table>
                        <a href="{{route('animals.edit', ['id' => $animal->id])}}" class="btn btn-primary">Edit Animal</a>
                        <br> <br>
                        <form action="/animals/{{ $animal->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete Animal Entry</button>
                        </form>
                        <br>
                        <p>*Note: Successfully deleting an animal entry will also delete any denied
                        adoption requests associated with it!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
