@extends('layouts.app')

@section('content')
    
    <div class="container">
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
                    <div class="card-header">Add a New Animal</div>
                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="/animals" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-8">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name">
                            </div>
                            <div class="col-md-8">
                                <label for="dob">Date of Birth:</label>
                                <input type="date" id="dob" name="dob">
                            </div>
                            <div class="col-md-8">
                                <label for="description">Description:</label>
                                <textarea rows="4" cols="50" id="description" name="description"></textarea>
                            </div>
                            <div class="col-md-8">
                                <label for="image">Image</label>
                                <input type="file" id="image" name="image">
                            </div>
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" value="Add Animal" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 