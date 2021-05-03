@extends('layouts.app')

<!--    Page that appears when public users go to see the adoption requests
        they've made. -->

@section('content')
    <div class="container">
        <a href="/home" class="btn btn-primary">Back to Home</a>
        <br><br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">My Adoption Requests</div>
                    <div class="card-body">
                    <!-- If the user hasn't made any adoption requests yet,
                        inform them on the page. If they have, then show
                        the table of their requests. -->
                    @if(count($adoptionRequests) == null)
                        <p>You haven't made any adoption requests yet!</p>
                    @else
                    <!-- Creating a table that lists the user's adoption requests - 
                        will display the animal's name and the status of the request. -->
                        <div class="table table-striped table-bordered table-hover">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Animal </th>
                                        <th> Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Getting the animal object associated with each of the 
                                        user's adoption requests so the names of the animals can 
                                        be shown on the page. -->
                                    @foreach($adoptionRequests as $adoptionRequest)
                                        <?php
                                            $animal = App\Models\Animal::find($adoptionRequest->animal_id);
                                        ?>
                                        <tr>
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