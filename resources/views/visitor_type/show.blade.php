@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Visitor Type Details</h1>

    <p><strong>Type Name:</strong> {{ $visitorType->type_name }}</p>

    <a href="{{ route('visitor_type.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
