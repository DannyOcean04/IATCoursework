@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      @guest
      Cannot Access
      @else
      <div class="card">
        <div class="card-header">My Profile</div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <?php
          $user = Auth::user()->name;
          print "Hello " . $user . ". Welcome to your homepage" . "<br />";
          ?>
          This is Aston Animal Sanctuary. Take a look and adopt yourself a pet today.
        </div>
      </div>
      @if(Auth::user()->role == 1)

      <div class="card">
        <div class="card-header">Display All Pending Requests</div>
        <div class="card-body">
          <table class="table table-striped table-dark">
            <thead>
              <tr>
                <th>Adoption ID</th>
                <th>User ID</th>
                <th>Animal ID</th>
                <th>Animal Name</th>
                <th>Status</th>
                <th>Details</th>
                <th colspan="2">Action</th>

              </tr>
            </thead>
            <tbody>
              @foreach($adoptRequests as $adoptRequest)
              @foreach($animals as $animal)
              @if($adoptRequest["animalID"]==$animal["id"])
              @if($adoptRequest["adoptionStatus"]==("Pending"))


              <tr>
                <!--  edit below -->
                <td>{{$adoptRequest['id']}}</td>
                <td>{{$adoptRequest['id']}}</td>
                <td>{{$adoptRequest['animalID']}}</td>
                <td>{{$animal['name']}}</td>
                <td>{{$adoptRequest['adoptionStatus']}}</td>
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
                  <!-- edit above -->
                  @endif
                  @endif
                </tr>
                @endforeach
                @endforeach

              </tbody>
            </table>
          </div>
        </div>


        @else
        <div class="card">
          <div class="card-header">Here are the pets you have adopted.</div>
          <div class="card-body">
            <table class="table table-striped table-dark">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Species</th>
                  <th>DOB</th>

                  <th>Description</th>
                  <th>Image</th>

                </tr>
              </thead>
              <tbody>
                @foreach($adoptRequests as $adoptRequest)
                @if($adoptRequest["userid"]==Auth::user()->id)
                @foreach($animals as $animal)
                @if($adoptRequest["animalID"]==$animal["id"])
                @if($adoptRequest["adoptionStatus"]=='Accepted')
                <tr>

                  <td>{{$animal['name']}}</td>
                  <td>{{$animal['species']}}</td>
                  <td>{{$animal['dob']}}</td>
                  <td>{{$animal['description']}}</td>
                  <td><img style="width:100%;height:100%"
                    src="{{ asset('storage/images/'.$animal['image'])}}"></td>

                    @endif
                    @endif
                    @endforeach
                    @endif
                    @endforeach
                  </div>
                </div>

                @endif
                @endguest
              </div>
            </div>
          </div>
          @endsection
