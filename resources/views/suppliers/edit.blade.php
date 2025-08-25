@extends('layouts.app')

@section('content')
<h1>Edit Supplier</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form action="{{ route('suppliers.update', $supplier) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required value="{{ $supplier->name }}">
    </div>

    <div class="mb-3">
        <label>Contact</label>
        <input type="text" name="contact" class="form-control" value="{{ $supplier->contact }}">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $supplier->email }}">
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ $supplier->phone }}">
    </div>

    <div class="mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control">{{ $supplier->address }}</textarea>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
