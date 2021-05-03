@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="/home" class="btn btn-primary">Back to Home</a>
        <br><br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Completed Adoption Requests</div>
                    <div class="card-body">
                        @if(count($adoptionRequests) == null)
                            <p>There are currently no completed adoption requests!</p>
                        @else
                            <div class="table table-striped table-bordered table-hover">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> User </th>
                                            <th> Animal </th>
                                            <th> Status </th>
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
                                                <td> {{ $adoptionRequest->status }} </td>
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