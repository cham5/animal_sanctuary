@extends('layouts.app')

<!-- Page that shows a list of all the animals in the system, which only staff 
    users are allowed to see. -->
@section('content')
    <div class="container">
        <!-- Button that allows user to go back to home page. -->
        <a href="/home" class="btn btn-primary">Back to Home</a>
        <br><br>
        <!-- display success message -->
        @if(\Session::has('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ \Session::get('success') }}</strong>
            </div>
            <br>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All Animals</div>
                        <div class="card-body">
                        <!-- If there are no animals in the system then inform the user,
                        else, display a table showing all the animals. -->
                        @if(count($animals) == null)
                            <p>There are currently no animals in the system!</p>
                        @else
                            <p>Click on details to see more information about each animal,
                            as well as options to edit or delete its entry.</p>
                            <div class="table table-striped table-bordered table-hover">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> Name </th>
                                            <th> Date of Birth </th>
                                            <th> Adoption Status </th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($animals as $animal)
                                            <tr>
                                                <td> {{ $animal->name }} </td>
                                                <td> {{ $animal->dob }} </td>
                                                <!-- If the animal is unavailable, get the user who has adopted it
                                                    so the relevant information about the animal's availability can
                                                    be displayed. -->
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
                                                <!-- Button next to each animal which users can click on to see
                                                    more details about the animal. -->
                                                <td><a href="{{route('animals.show', ['id' => $animal->id])}}"
                                                class="btn btn-primary">Details</a></td>
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