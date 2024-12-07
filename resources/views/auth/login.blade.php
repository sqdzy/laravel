@extends('layout')
@section('content')

@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">{{$error}}</div>
  @endforeach
@endif


<form action="/auth/authenticate" method="POST">
  @csrf

  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">SignIn</button>
</form>
@endsection