<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Animal;
use App\adoptRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdoptRequestController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $animals = Animal::all()->toArray();
    $adoptRequests = adoptRequest::all()->toArray();
    $users = User::all()->toArray();

    return view('requests.index', compact('animals','adoptRequests','users'));
  }

  /**
  * Creates a adoption request from the user for an animal
  *
  * @param  bigInteger  $animalID
  * @return \Illuminate\Http\Response
  */

  public function submitRequest($animalID)
  {
    //below creates an array of the table data and... tl;dr if both userid and animal id are the same as a pair, then it will error. if userid is same but animal id is diff, then is ok.
    //create variable name, based on the model, and essentially creates an array of all the data in the table
    $requests=adoptRequest::all()->toArray();
    foreach($requests as $request)
    {
      if($request["userid"]==Auth::user()->id)
      {
        if($request["animalID"]==$animalID)
        {
          return back()->withErrors("Request has already been made.");
        }
      }
    }


    // create a Animal object and set its values from the input
    $adoptRequest = new adoptRequest;

    $adoptRequest->userid = Auth::user()->id;
    $adoptRequest->animalID = $animalID;
    $adoptRequest->dateSubmitted = now();
    $adoptRequest->created_at = now();

    $adoptRequest->save();
    // generate a redirect HTTP response with a success message
    return back()->with('success', 'Request has been made');
  }
  /**
  * Rejects an adoption request from the staff for an animal
  *
  * @param  bigInteger  $AdoptionID
  * @return \Illuminate\Http\Response
  */


  public function denyRequest($AdoptionID){

    $adoptRequest = adoptRequest::find($AdoptionID);

    $adoptRequest->updated_at = now();
    $adoptRequest->adoptionStatus = ('Rejected');

    $adoptRequest->save();

    return back()->with('success', 'Rejected');
  }

  /**
  * Approves an adoption request from the staff for an animal
  *
  * @param  bigInteger  $AdoptionID
  * @return \Illuminate\Http\Response
  */

  public function approveRequest($AdoptionID){

    //When a request matches the specified route Uniform Resource Identifier (as defined in the web.php file), the approve method on the  AdoptionRequestController class will be executed.
    if(Auth::user()->role == 1) {
      // If the user is an Admin, allow them to approve a user's adoption request.
      $adoptionRequest = adoptRequest::find($AdoptionID);
      $animal = animal::find($adoptionRequest->animalID);
      if ($animal->adoptionStatus == 0){
        $animal->adoptionStatus = 1;
        $adoptionRequest->adoptionStatus = ('Accepted');
        $animal->ownerID = $adoptionRequest->userid;
        $adoptionRequest->updated_at = now();
        $animal->save();
        $adoptionRequest->save();
        return back()->with('success', 'Adoption Request has been approved');
      }else {
        $adoptionRequest->adoptionStatus = ('Rejected');
        $adoptionRequest->updated_at = now();
        $animal->save();
        $adoptionRequest->save();
        return back()->with('warning', 'Adoption Request has already been Accepted. So Request Has Been Rejected');
      }

      // generate a redirect HTTP response with a success message
    }
    return "Error: You do not have the proper permissions to carry out this action.";

  }
  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($AdoptionID){

    $adoptRequests = adoptRequest::find($AdoptionID);
    $requests=adoptRequest::all()->toArray();
    $adoptedAnimals = animal::all()->toArray();

    foreach($adoptedAnimals as $animal){
      if($adoptRequests["animalID"]==$animal["id"]){
        if($adoptRequests["userid"]==$animal["ownerID"]){
          $adoptedAnimal->adoptionStatus = (0);
          $adoptedAnimal->ownerID = nullable;


        }
      }
    }
    $adoptRequests->delete();
    return back()->with('success', 'Request has been deleted');
  }
}
