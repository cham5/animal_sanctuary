@extends('layouts.app')

<!-- Home page for public users. They will be able to see all the animals
    available for adoption. -->
@section('content')
<div class="container">
    <!-- A navigation section so a public user can click on a button to 
        see the adoption requests that they have made. -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Navigation</div>
                <div class="card-body">
                    <a href="/requests/public" class="btn btn-primary">My Adoption Requests</a>
                </div>
            </div>
        </div>
    </div>
    <br>
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
                <div class="card-header">Available Animals</div>
                    <div class="card-body">
                    <!-- If there are no available animals, inform the user.
                        If there is, then display the table containing the animals. -->
                        @if(count($animals) == null)
                        <p>There are currently no available animals!</p>
                        @else
                        <p>Click on details to see more information about each animal
                        including a description and pictures.</p>
                        <div class="table table-striped table-bordered table-hover">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Name </th>
                                        <th> Date of Birth </th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($animals as $animal)
                                        <tr>
                                            <td> {{ $animal->name }} </td>
                                            <td> {{ $animal->dob }} </td>
                                            <!-- For each animal displayed on the table there will also be a button next
                                                to it in which users can click to see more details about the animal.
                                                The button takes them to a page showing all the details for the specific animal. -->
                                            <td><a href="{{route('animals.show', ['id' => $animal->id])}}"
                                            class="btn btn-primary">Details</a></td>
                                            <td>
                                            <!-- Users will also be able to adopt an animal via a form button that will show
                                                next to each of the animals on the table. -->
                                                <form action="/requests" method="post">
                                                    @csrf
                                                    <input type="hidden" id="animalId" name="animalId" value="{{$animal->id}}">
                                                    <button class="btn btn-primary" type="submit">Adopt</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection