@extends('layouts.app')

<!-- Home page for users that have admin rights (staff users).
    Here they will be able to see all the pending adoption requests
    that they must complete by either accepting or denying. -->
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <!-- Navigation section in which staff users can visit pages that will allow
                them to create a new animal, view all animals, and view the completed
                adoption requests. -->
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
                <!-- If there are no pending adoption requests then inform the user.
                    If there are then display a table containing all pending adoption requests. -->
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
                                    <!-- Getting the associated user and animal entries associated
                                        with each pending adoption request so their names can be displayed on the table. -->
                                    <?php
                                        $user = App\Models\User::find($adoptionRequest->user_id);
                                        $animal = App\Models\Animal::find($adoptionRequest->animal_id);
                                    ?>
                                    <tr>
                                        <td> {{ $user->name }} </td>
                                        <td> {{ $animal->name }} </td>
                                        <td>
                                        <!-- Form buttons next to each adoption request displayed on the table so
                                            staff users can either approve or deny the request. -->
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