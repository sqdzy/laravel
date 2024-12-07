@extends('layout')
@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Name</th>
      <th scope="col">Shortdesc</th>
      <th scope="col">Description</th>
      <th scope="col">Preview image</th>
    </tr>
  </thead>
  <tbody>
    @foreach($articles as $article)
    <tr>
      <th scope="row">{{$article->date}}</th>
      <td>{{$article->name}}</td>
      <td>{{$article->shortDesc}}</td>
      <td>{{$article->desc}}</td>
      <td><a href="/galery/{{$article->full_image}}/{{$article->name}}"><img src="{{$article->preview_image}}" alt="" class="img-thumbnail"></a></td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection