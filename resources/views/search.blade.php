@extends('layout.layout')

@section('content')
@if($errors->isEmpty() && !$case_study->isEmpty())
<iren-search :cases="{{$case_study}}"></iren-search>
@else
<iren-search :cases="0"></iren-search>
@endif
@endsection
