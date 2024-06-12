@extends('layouts.app')

@section('content')

<div class="container">
  <div class="card mt-3">
    <div class="card-header">
      <div class="row justify-content-between my-3">
        <div class="col-3">
          <h3>Dashboard</h3>
        </div>
        <div class="col-3">
          <a href="{{ route('admin.works.create') }}" class="btn_new_project btn btn-success">Create New Project</a>
        </div>
      </div>
    </div>

    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th  scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Slug</th>
            <th scope="col">Description</th>
            <th scope="col">GitHub Link</th>
            <th class="col-2 " scope="col-4">Modify</th>
          </tr>
        </thead>
        <tbody>
          
            @foreach ($works as $work)
            <tr>
              <th scope="row align-items-center">{{ $work->id }}</th>
              <td>{{ $work->title }}</td>
              <td>{{ $work->slug }}</td>
              <td>{{ $work->description }}</td>
              <td><a href="#">{{ $work->github_link }}</a></td>
              <td class="row">
                <a href="{{ route('admin.works.show', $work ) }}" class="btn btn-primary">More Infos</a>
                <a href="{{ route('admin.works.edit', $work) }}" class="btn btn-warning">Edit</a>
                <form class="p-0" action="{{ route('admin.works.destroy', $work) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button  type="submit" class="w-100 btn btn-danger mb-auto">Trash</button>
                </form>
              </td>
            </tr>
            @endforeach
         
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection