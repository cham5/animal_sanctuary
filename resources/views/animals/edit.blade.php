@extends('layouts.app')

<!-- Page in which staff users can edit the information of an animal entry. -->

@section('content')    
    <div class="container">
        <!-- Button that lets the user go back to the previous page being the
            animal's details. -->
        <a href="/animals/{{$animal->id}}" class="btn btn-primary">Back to Animal Details</a>
        <br><br>
        <!-- display success message -->
        @if(\Session::has('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ \Session::get('success') }}</strong>
            </div>
            <br>
        @endif
        <!-- Display any errors -->
        @if($errors->any())
            <div class="alert alert-danger">
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
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Edit and Update Animal</div>
                    <div class="card-body">
                    <!-- Form that staff users can fill in with info to update the animal's information. -->
                        <form class="form-horizontal" method="post" action="/animals/{{$animal->id}}/edit" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-8">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" value="{{$animal->name}}">
                            </div>
                            <div class="col-md-8">
                                <label for="dob">Date of Birth:</label>
                                <input type="date" id="dob" name="dob" value="{{$animal->dob}}">
                            </div>
                            <div class="col-md-8">
                                <label for="description">Description:</label>
                                <textarea rows="4" cols="50" id="description" name="description">{{ $animal->description }}</textarea>
                            </div>
                            <div class="col-md-8">
                                <label for="image">Image:</label>
                                <input type="file" id="image" name="image" value="{{$animal->picture}}"> 
                            </div>
                            <div class="col-md-6 col-md-offset-4">
                            <!-- Hidden value containing the animal's ID which will be used by update method
                                in the Animal Controller. -->
                                <input type="hidden" value="{{$animal->id}}" name="animalId">
                                <input type="submit" value="Update Animal" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 