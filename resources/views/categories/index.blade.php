@extends('layouts.app')

@section('content')
<h1>Categories</h1>
<a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">+ New Category</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="2">No categories found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
