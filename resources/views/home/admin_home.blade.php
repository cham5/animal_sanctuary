@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Navigation</div>
                <div class="card-body">
                    <a href="/animals/add" class="btn btn-primary">Add New Animal</a>
                    <a href="/animals/staff" class="btn btn-primary">View All Animals</a>
                    <a href="/requests/staff" class="btn btn-primary">View Completed Adoption Requests</a>
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
                <div class="card-header">Pending Adoption Requests</div>
                <div class="card-body">
                @if(count($adoptionRequests) == null)
                    <p>There are currently no pending adoption requests!</p>
                @else
                    <div class="table table-striped table-bordered table-hover">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> User </th>
                                    <th> Animal </th>
                                    <th colspan="2"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($adoptionRequests as $adoptionRequest)
                                    <?php
                                        $user = App\Models\User::find($adoptionRequest->user_id);
                                        $animal = App\Models\Animal::find($adoptionRequest->animal_id);
                                    ?>
                                    <tr>
                                        <td> {{ $user->name }} </td>
                                        <td> {{ $animal->name }} </td>
                                        <td>
                                            <form action="/home/staff" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" id="adoptionRequestId" name="adoptionRequestId" value="{{ $adoptionRequest->id }}">
                                                <button class="btn btn-success" name="status" type="submit" value="Approved">Approve</button>
                                                <button class="btn btn-danger" name="status" type="submit" value="Denied">Deny</button>
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
@endsection