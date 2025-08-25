@extends('layouts.app')

@section('content')
<h1>Add New Category</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
