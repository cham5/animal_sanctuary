<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\AdoptionRequest;

class AnimalController extends Controller
{
    public function __construct() {
        // ensuring users have to be signed in.
        $this->middleware('auth');
    }

    // only users with admin rights will be able to see the list of ALL animals
    public function index() {
        if(Gate::allows('admin-check')) {
            return view('animals.index', ['animals' => Animal::all()]);
        } else {
            abort(403);
        }
    }

    public function availableAnimals() {
        // getting all the available animals to show on a public user's home page
        if(Gate::denies('admin-check')) {
            return view('home.public_home', ['animals' => Animal::where('Availability', 'Available')->get()]);
        }
    }
    
    // showing the details of an individual animal
    // showing a different view depending on the type of user
    public function show($id) {
        if(Gate::allows('admin-check')) {
            return view('animals.admin_show', ['animal' => Animal::findOrFail($id)]);
        } else {
            return view('animals.public_show', ['animal' => Animal::findOrFail($id)]);
        }

    }

    // returns a view containing a form that allows users with
    // admin rights to add a new animal to the system
    public function create() {
        // checking that the user has admin rights
        // if not then show http exception
        if(Gate::allows('admin-check')) {
            return view('animals.create');
        } else {
            abort(403);
        }
    }

    // storing the animal entry in the system.
    public function store(Request $request) {
        // form validation
        $this->validate($request, [
            'name' => 'required',
            'dob' => 'required|before:tomorrow',
            'description' => 'required',
            'picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500'
        ],
        // custom error messages for the validations
        [
            'dob.before' => 'The date of birth cannot be a future date.'
        ]);

        if($request->hasFile('image')) {
            //Getting the filename + extension
            $filenameAndExt = $request->file('image')->getClientOriginalName();
            //Getting the filename on its own
            $filename = pathinfo($filenameAndExt, PATHINFO_FILENAME);
            //Getting the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Creating the filename that will be stored
            //Including current time value when added to differentiate between duplicate images
            $storedFilename = $filename.'_'.time().'.'.$extension;
            //Storing the file
            $request->file('image')->storeAs('public/images', $storedFilename);
        } else {
            $storedFilename = 'noimage.jpg';
        }

        // creating new animal object
        $animal = new Animal();
        // assigning the properties of the animal
        $animal->name = $request->input('name');
        $animal->dob = $request->input('dob');
        $animal->description = $request->input('description');
        $animal->picture = $storedFilename;
        // saving the animal object to the database
        $animal->save();
        // notify of a successful new addition
        return back()->with('success', 'Animal has been added.');
    }

    public function destroy($id) {
        // finding the associated animal object
        $animal = Animal::findOrFail($id); 
        // finding if there's any pending adoption requests for this animal
        $adoptionRequests = AdoptionRequest::where('animal_id', $id)->where('status', 'Pending')->get();
        // if the animal is unavailable then it has been adopted, return with error
        // informing the animal entry cannot be deleted as a result
        if($animal->availability == 'Unavailable') {
            return back()->withErrors(['errors' => 'Cannot delete an animal that has been adopted!']);
        // if there are pending adoption requests, then notify user that the animal cannot be deleted
        // while there are still pending adoption requests
        } elseif (count($adoptionRequests) != null) {
            return back()->withErrors(['errors' => 'Cannot delete an animal while there are still pending 
            adoption requests for it!']);
        // else condition - animals with no requests or denied requests can be deleted 
        // denied requests related to this animal will be deleted due to cascading
        } else {
            $animal->delete();
            return redirect('/animals/staff')->with('success', 'Animal succesfully deleted!');
        }
    }

    // checks whether or not the user has admin rights. (staff users)
    // only staff users will be able to edit an animal entry.
    public function edit($id) {
        if(Gate::allows('admin-check')) {
            $animal = Animal::findOrFail($id);
            return view('animals.edit', ['animal' => $animal]);
        } else {
            abort(403);
        }
    }

    // updating the animal entry with new information.
    public function update(Request $request) {
        // finding the associated animal object
        $animal = Animal::findOrFail(request('animalId'));
        // validation
        $this->validate($request, [
            'name' => 'required',
            'dob' => 'required|before:tomorrow',
            'description' => 'required',
            'picture' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500'
        ],
        // custom error messages for the validations
        [
            'dob.before' => 'The date of birth cannot be a future date.'
        ]);

        // assigning the new properties of the animal
        $animal->name = $request->input('name');
        $animal->dob = $request->input('dob');
        $animal->description = $request->input('description');
        
        // if a new picture is added
        if($request->hasFile('image')) {
            //Getting the filename + extension
            $filenameAndExt = $request->file('image')->getClientOriginalName();
            //Getting the filename on its own
            $filename = pathinfo($filenameAndExt, PATHINFO_FILENAME);
            //Getting the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Creating the filename that will be stored
            //Including current time value when added to differentiate between duplicate images
            $storedFilename = $filename.'_'.time().'.'.$extension;
            //Storing the file
            $request->file('image')->storeAs('public/images', $storedFilename);

            // assign the property
            $animal->picture = $storedFilename;
        } 
        
        // saving the animal object to the database
        $animal->save();
        // notify of a successful new addition
        return redirect('/animals/'.request('animalId'))->with('success', 'Animal has been updated.');
    }

    


}
