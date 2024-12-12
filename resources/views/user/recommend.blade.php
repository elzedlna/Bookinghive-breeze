@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Recommended Hotels</h2>
    <div class="grid grid-cols-3 gap-4">
        @foreach ($hotels as $hotel)
            <div class="card">
                <h3>{{ $hotel->name }}</h3>
                <p>{{ $hotel->location }}</p>
                <a href="/hotels/{{ $hotel->id }}" class="btn btn-primary">View Details</a>
            </div>
        @endforeach
    </div>
</div>
@endsection