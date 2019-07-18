@extends('layouts.app')
<!-- This blade.php page creates the animal object-->
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10 ">
      @guest
      <div class="card">
        <div class="card-header">Error</div>
        <div class="card-body">
          <p>You do not have access to this page</p>
        </div>
      </div>
      @else
      @if(Auth::user()->role==1)
      <div class="card">
        <div class="card-header">Create an new animal</div>
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
        <!-- define the form -->
        <div class="card-body">
          <form class="form-horizontal" method="POST"
          action="{{url('animals') }}" enctype="multipart/form-data">
          @csrf
          <div class="col-md-8">
            <label >Name</label>
            <input type="text" name="name"
            placeholder="name" />
          </div>
          <div class="col-md-8">
            <label>Species</label>
            <select name="species" >
              <option value="cat">Cat</option>
              <option value="dog">Dog</option>
              <option value="hamster">Hamster</option>
              <option value="goldfish">GoldFish</option>
              <option value="mouse">Mouse</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="col-md-8">
            <label >DOB</label>
            <input type="date" name="dob"
            placeholder="dob" />
          </div>
          <div class="col-md-8">
            <label >Description</label>
            <textarea rows="4" cols="50" name="description"> Notes
              about the animal </textarea>
            </div>
            <div class="col-md-8">
              <label>Image</label>
              <input type="file" name="image"
              placeholder="Image file" />
            </div>
            <div class="col-md-6 col-md-offset-4">
              <input type="submit" class="btn btn-primary" />
              <input type="reset" class="btn btn-primary" />
            </div>
          </form>
        </div>
      </div>
      @endif
      @endguest
    </div>
  </div>
</div>
@endsection
