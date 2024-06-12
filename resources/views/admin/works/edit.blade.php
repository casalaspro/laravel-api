@extends('layouts.app')

@section('content')

<div class="container mt-3">
  <form action="{{ route('admin.works.update', $work) }}" method="POST">

    @csrf

    @method('PUT')

    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
    <input type="text" name="title" class="form-control" id="title" placeholder="insert the project title here.." value="{{ $work->title }}">
    </div>
    <div class="mb-3">
      <label for="slug" class="form-label">Slug</label>
    <input type="text" name="slug" class="form-control" id="slug" placeholder="insert the project slug here.." value="{{ $work->slug }}">
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
    <textarea type="text" name="description" class="form-control" id="description" placeholder="insert the description here.." value="">{{ $work->description }}</textarea>
    </div>
    <div class="mb-3">
      <label for="github_link" class="form-label">GitHub Link</label>
    <input type="text" name="github_link" class="form-control" id="github_link" placeholder="http://..." value="{{ $work->github_link }}">
    </div>

    <div class="form-group mb-3">
      <p>Select the Technologies used</p>

      <div class="d-flex gap-2">
      @foreach ($technologies as $technology)
       
        <div class=" form-check">
          <label class="form-check-label" for="tech-{{ $technology->id }}">
            {{ $technology->name }}
          </label>
          {{-- @checked is used to return the checked attribute if the argument is true.
               It receives the function old() that retreives the flashed value of the form. The second argument of that function is the value returned if has found nothing.
               in_array() receive two arguments:
               The first argument is the needle, the element to search inside the array.
               The second arg is the haystack, the array where to search. --}}
          <input @checked(in_array($technology->id, old('technologies', $work->technologies->pluck('id')->all()))) name="technologies[]" type="checkbox" value="{{ $technology->id }}" id="tech-{{ $technology->id }}">
         
        </div>

      @endforeach
      </div>

    {{-- <a href="" class="btn btn-success mt-3">Update</a> --}}
    <button class="btn btn-success mt-3">Update</button>
  </form>

 
    @if ($errors->any())
      <div class="error">
          <ul>
            @foreach ($errors->all() as $error)
                <li class="alert alert-danger">{{ $error }}</li>
            @endforeach
          </ul>
      </div>
    @endif
  
</div>

@endsection