@extends('layouts.app')

@section('content')
<h1>Add New Supplier</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form action="{{ route('suppliers.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
    </div>

    <div class="mb-3">
        <label>Contact</label>
        <input type="text" name="contact" class="form-control" value="{{ old('contact') }}">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
    </div>

    <div class="mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control">{{ old('address') }}</textarea>
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
