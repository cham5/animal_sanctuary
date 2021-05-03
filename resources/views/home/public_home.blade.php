@extends('layouts.app')

@section('content')
<div class="container">
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
                                            <td><a href="{{route('animals.show', ['id' => $animal->id])}}"
                                            class="btn btn-primary">Details</a></td>
                                            <td>
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