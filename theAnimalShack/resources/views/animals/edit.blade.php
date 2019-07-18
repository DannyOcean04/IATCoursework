@extends('layouts.app')
<!-- This blade.php page edits the animal object-->
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
      @if(Auth::user()->role==1)
      <div class="card">
        <div class="card-header">Edit and update the animal</div>
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div><br />
        @endif
        @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
        @endif
        <div class="card-body">
          <form class="form-horizontal" method="POST" action="{{ action('AnimalController@update',
          $animal['id']) }} " enctype="multipart/form-data" >
          @method('PATCH')
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
            <textarea rows="4" cols="50" name="description" > {{$animal->description}}
            </textarea>
          </div>
          <div class="col-md-8">
            <label>Image</label>
            <input type="file" name="image" />
          </div>
          <div class="col-md-6 col-md-offset-4">
            <input type="submit" class="btn btn-primary" />
            <input type="reset" class="btn btn-primary" />
          </a>
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
