<?php

namespace App\Http\Controllers;

use Gate;
use Auth;
use Illuminate\Http\Request;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Models\User;

class AdoptionRequestController extends Controller
{
    public function __construct() {
        // ensuring users have to be signed in.
        $this->middleware('auth');
    }

    // displaying all the pending adoption requests to the staff user's home page.
    public function display() {
        // performing a check to see if the user has admin rights.
        if (Gate::allows('admin-check')) {
            $adoptionRequests = AdoptionRequest::where('status', 'Pending')->get();
            return view('home.admin_home', ['adoptionRequests' => $adoptionRequests]);
        } else {
            abort(403);
        }
    }

    // checks if user has admin rights, gets requests that have either been accepted
    // or denied and then returns them with the view.
    // return with http exception if user isn't authorised
    public function getCompletedAdoptionRequests() {
        if (Gate::allows('admin-check')) {
            $adoptionRequests = AdoptionRequest::where('status','!=','Pending')->get();
            return view('requests.admin_index', ['adoptionRequests' => $adoptionRequests]);
        } else {
            abort(403);
        }
    }

    // getting all the adoption requests specific to the user.
    public function getUserAdoptionRequests() {
        // checks to see if the user is a normal public user, then returns
        // the appropriate view and data.
        if (Gate::denies('admin-check')) {
            // due to defining a one-to-many relationship between a user and
            // adoption requests, it's possible to retrieve a specifc user's
            // requests like so
            $adoptionRequests = User::find(Auth::id())->adoptionRequests;
            return view('requests.index', ['adoptionRequests' => $adoptionRequests]);
        }
    }

    // storing the adoption request in the system.
    public function store() {
        // check to see if user has already sent an adoption request for this animal
        // that is still pending
        $adoptionRequests = AdoptionRequest::where('user_id', Auth::id())
        ->where('animal_id', request('animalId'))->where('status', 'Pending')->get();
        if(count($adoptionRequests) == null) {
            // create new adoption request object
            $adoptionRequest = new AdoptionRequest();
            // make sure the current user's id is associated
            $adoptionRequest->user_id = Auth::id();
            // associate the animal's id (taken from the hidden input) with the adoption request
            $adoptionRequest->animal_id = request('animalId');
            // save the adoption request
            $adoptionRequest->save();
            // notify with a successful adoption request
            return back()->with('success', 'Adoption request has been made.');
        // else - we know that the user has therefore already made an adoption request that is still
        // pending, so inform the user with an error.
        } else {
            return back()->withErrors(['errors' => 'You already have a pending request for this animal!']);
        }
    }

    // updating the information of an adoption request - more specifically its status
    // which only staff users can do.
    public function update() {
        // retrieving the associated adoption request & animal
        $adoptionRequest = AdoptionRequest::findOrFail(request('adoptionRequestId'));
        $animal = Animal::findOrFail($adoptionRequest->animal_id);
        // if the animal is available, and there is a request to approve the adoption request
        if (($animal->availability == 'Available') && (request('status') == 'Approved')) {
            // change the adoption request's status to approved, and make the animal
            // unavailable so future adoption requests for this animal can't be approved
            $adoptionRequest->status = request('status');
            $animal->availability = 'Unavailable';
            // update the objects accordingly
            $adoptionRequest->update();
            $animal->update();
            // notify a successful approve action
            return back()->with('success', 'Adoption request approved!');
        // else if the animal is unavailable, and there is a request to approve the adoption request
        } elseif (($animal->availability == 'Unavailable') && (request('status') == 'Approved')) {
            // notify with an error stating that the approve action can't be done
            return back()->withErrors(['errors' => 'Adoption request cannot be approved for an unavailable animal!']);
        // else statement for remaining conditions involving a request to deny adoption request
        } else {
            // change adoption request's status to denied and update accordingly
            $adoptionRequest->status = request('status');
            $adoptionRequest->update();
            // notify a successful denied action
            return back()->with('success', 'Adoption request denied!');
        }
    }
}
