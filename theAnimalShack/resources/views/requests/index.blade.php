@extends('layouts.app')
<!-- This blade.php page displays all requests to staff, and displays requests that the specific user has made to users-->
@section('content')

<!-- display the errors -->
@if ($errors->any())
<div class="alert alert-danger">
  <ul> @foreach ($errors->all() as $error)
    <li>{{ $error }}</li> @endforeach
  </ul>
</div><br /> @endif
<!-- display the success status -->
@if (\Session::has('success'))
<div class="alert alert-success">
  <p>{{ \Session::get('success') }}</p>
</div><br /> @endif
<!-- display the warning status -->
@if (\Session::has('warning'))
<div class="alert alert-warning">
  <p>{{ \Session::get('warning') }}</p>
</div><br /> @endif


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 ">
      <!-- below is code for displaying adoption request  -->

      @guest
      <div class="card">
        <div class="card-header">Error</div>
        <div class="card-body">
          <p>You do not have access to this page</p>
        </div>
      </div>
      @else

      @if(Auth::user()->role == 1)
      <div class="card">
        <div class="card-header">Display All Requests</div>
        <div class="card-body">
          <table class="table table-striped table-dark">
            <thead>
              <tr>
                <th>Adoption ID</th>
                <th>User ID</th>
                <th>Animal ID</th>
                <th>Animal Name</th>
                <th>Status</th>
                <th>Owner</th>
                <th>Details</th>
                <th colspan="2">Action</th>

              </tr>
            </thead>
            <tbody>
              @foreach($adoptRequests as $adoptRequest)
              @foreach($animals as $animal)
              @if($adoptRequest["animalID"]==$animal["id"])
              @foreach($users as $user)
              @if($adoptRequest["userid"]==$user["id"])

              <tr>
                <!--  edit below -->
                <td>{{$adoptRequest['id']}}</td>
                <td>{{$adoptRequest['userid']}}</td>
                <td>{{$adoptRequest['animalID']}}</td>
                <td>{{$animal['name']}}</td>
                <td>{{$adoptRequest['adoptionStatus']}}</td>
                <td>{{$user['name']}}</td>

                <!-- edit above -->
                <td><a href="{{action('AnimalController@show', $animal['id'])}}" class="btn
                  btn-primary">Details</a></td>


                  @if($adoptRequest['adoptionStatus'] == 'Pending')


                  <td><a href="{{action('AdoptRequestController@approveRequest', $adoptRequest['id'])}}" class="btn
                    btn-warning">Approve</a>
                  </td>


                  <td>
                    <a href="{{action('AdoptRequestController@denyRequest', $adoptRequest['id'])}}" class="btn
                    btn-danger">Deny</a>
                  </td>
                  @endif
                </tr>
                @endif
                @endforeach
                @endif
                @endforeach
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
        @else
        <!-- below is code for displaying users adoption requests  -->


        <div class="card">
          <div class="card-header">Display My Requests </div>
          <div class="card-body">
            <table class="table table-striped table-dark">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Species</th>
                  <th>DOB</th>
                  <th>Description</th>
                  <th>Status</th>


                </tr>
              </thead>
              <tbody>
                @foreach($adoptRequests as $adoptRequest)
                @if($adoptRequest["userid"]==Auth::user()->id)
                @foreach($animals as $animal)
                <!-- below allows to use animals table and requests table together, checks that we're looking at the same animal, the right one.  -->
                @if($adoptRequest["animalID"]==$animal["id"])



                <tr>
                  <!--  edit below -->
                  <td>{{$animal['name']}}</td>
                  <td>{{$animal['species']}}</td>
                  <td>{{$animal['dob']}}</td>
                  <td>{{$animal['description']}}</td>
                  <td>{{$adoptRequest['adoptionStatus']}}</td>
                  @if($adoptRequest['adoptionStatus'] == 'Pending')
                  <td>
                    <form action="{{action('AdoptRequestController@destroy', $adoptRequest['id'])}}"
                    method="post"> @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Remove Request</button>
                  </form>
                </td>
                @endif
              </tr>

              @endif
              @endforeach
              @endif
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
      @endguest
    </div>
  </div>
</div>
@endsection
