@extends('layouts.app')

@section('content')

<div class="container">
  <form class="mt-3" action="{{ route('admin.works.store') }}" method="POST">

    @csrf
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" name="title" class="form-control" id="title" placeholder="insert the project title here.." value="{{ old('title') }}">
    </div>
    
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea type="text" name="description" class="form-control" id="description" placeholder="insert the description here.." rows="5">{{ old('description') }}</textarea>
    </div>
    
    <div class="mb-3">
      <label for="github_link" class="form-label">GitHub Link</label>
      <input type="text" name="github_link" class="form-control" id="github_link" placeholder="http://..." value="{{ old('github_link') }}">
    </div>

    <div class="mb-3">
      <label for="type_id" class="form-label">Type</label>
      <select class="form-control" name="type_id" id="type_id">
        <option value="">-- Select Type --</option>
        @foreach($types as $type) 
          <option @selected( $type->id == old('type_id') ) value="{{ $type->id }}"> {{ $type->name }}</option>
        @endforeach
      </select>
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
          <input @checked(in_array($technology->id, old('technologies', []))) name="technologies[]" type="checkbox" value="{{ $technology->id }}" id="tech-{{ $technology->id }}">
         
        </div>

      @endforeach
      </div>
          
      
      
      

    </div>

    <button class="btn btn-success">Create</button>
  </form>

  @if ($errors->any())
    <ul class="errors">
      @foreach ($errors->all() as $error)
        <li class="alert alert-danger">{{ $error }}</li>  
      @endforeach
    </ul>
  @endif
</div>
    
@endsection