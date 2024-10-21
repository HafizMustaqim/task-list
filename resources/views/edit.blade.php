@extends('layouts.app')

{{-- applying subviews --}}
@section('content')
    @include('form', ['task' => $task])
@endsection
