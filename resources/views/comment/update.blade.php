@extends('layout')
@section('content')


@if ($errors->any())
  <div class="alert-danger">
     <ul>
      @foreach($errors->all() as $error)
        <li>{{$error}}</li>
      @endforeach
    </ul>
  </div>
@endif

@if(session('status'))
  <div class="alert alert-danger">
      {{ session('status') }}
  </div>
@endif

<form action="/comment/{{ $comment->id }}/update" method="POST">
  @csrf
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ $comment->name }}">
  </div>
  <div class="mb-3">
    <label for="desc" class="form-label">Description</label>
    <textarea name="desc" class="form-control" id="desc">{{ $comment->desc }}"</textarea>
  </div>
  <button type="submit" class="btn btn-primary">Update comment</button>
</form>
@endsection