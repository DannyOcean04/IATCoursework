@extends('layouts.app')
<!-- This blade.php page shows one specific animal from the list-->
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 ">
      @guest
      <div class="card">
        <div class="card-header">Error</div>
        <div class="card-body">
          <p>You do not have access to this page</p>
        </div>
      </div>
      @else
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
      <div class="card">
        <div class="card-header">Animals</div>
        <div class="card-body">
          <table class="table table-striped table-dark" border="1" >
            <tr> <td> <b>Name </th> <td> {{$animal['name']}}</td></tr>
              <tr> <th>Species </th> <td>{{$animal->species}}</td></tr>
              <tr> <th>DOB </th> <td>{{$animal->dob}}</td></tr>
              <tr> <th>Description</th> <td style="max-width:150px;" >{{$animal->description}}</td></tr>
              <tr> <td colspan='2' ><img style="width:100%;height:100%"
                src="{{ asset('storage/images/'.$animal->image)}}"></td></tr>
              </table>
              <table><tr>
                <td><a href="../animals" class="btn btn-primary" role="button">Back to the list</a></td>

                @if (Auth::user()->role == 0)
                <td><a href="{{action('AdoptRequestController@submitRequest', $animal['id'])}}" class="btn btn-success" role="button">Submit Adoption Request</a></td>
                @endif
                @if (Auth::user()->role == 1)
                <td><a href="{{action('AnimalController@edit', $animal['id'])}}" class="btn btn-warning">Edit</a></td>
                <td><form action="{{action('AnimalController@destroy', $animal['id'])}}"
                  method="post"> @csrf
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form></td>
                @endif
              </tr></table>
            </div>
          </div>
          @endguest
        </div>
      </div>
    </div>
    @endsection
