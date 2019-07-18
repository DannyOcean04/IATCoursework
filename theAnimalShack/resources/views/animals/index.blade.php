@extends('layouts.app')
<!-- This blade.php page displays all animals to staff, and displays all available animals to users-->
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 ">
      #@guest
      <div class="card">
        <div class="card-header">Error</div>
        <div class="card-body">
          <p>You do not have access to this page</p>
        </div>
      </div>
      @else
      @if(Auth::user()->role == 1)
      <div class="card">
        <div class="card-header">Display all Animals</div>
        <div class="card-body">
          <table class="table table-striped table-dark">
            <thead>
              <tr>
                <th>Name</th>
                <th>Species</th>
                <th>DOB</th>
                <th>Image</th>

                <th colspan="3">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($animals as $animal)
              <tr>

                <td>{{$animal['name']}}</td>
                <td>{{$animal['species']}}</td>
                <td>{{$animal['dob']}}</td>
                <td><img style="width:50%;height:50%"
                  src="{{ asset('storage/images/'.$animal['image'])}}"></td>

                  <td><a href="{{action('AnimalController@show', $animal['id'])}}" class="btn
                    btn-primary">Details</a></td>

                    @if (Auth::user()->role == 1)

                    <td><a href="{{action('AnimalController@edit', $animal['id'])}}" class="btn
                      btn-warning">Edit</a>
                    </td>

                    <td>
                      <form action="{{action('AnimalController@destroy', $animal['id'])}}"
                      method="post"> @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                  </td>

                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @else


        <div class="card">
          <div class="card-header">Display Available Animals</div>
          <div class="card-body">
            <table class="table table-striped table-dark">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Species</th>
                  <th>DOB</th>

                  <th>Image</th>

                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($animals as $animal)
                @if($animal["adoptionStatus"] == 0)

                <tr>

                  <td>{{$animal['name']}}</td>
                  <td>{{$animal['species']}}</td>
                  <td>{{$animal['dob']}}</td>

                  <td><img style="width:100%;height:100%"
                    src="{{ asset('storage/images/'.$animal['image'])}}"></td>

                    <td><a href="{{action('AnimalController@show', $animal['id'])}}" class="btn
                      btn-primary">Details</a></td>

                      @endif
                      @endforeach
                      @endif

                    </div>
                  </div>
                  @endguest
                </div>
                @endsection
