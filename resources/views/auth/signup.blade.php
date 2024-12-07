@extends('layout')
@section('content')

@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">{{$error}}</div>
  @endforeach
@endif


<form action="/auth/registr" method="POST">
  @csrf
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <button type="submit" class="btn btn-primary">SignUp</button>
</form>
@endsection