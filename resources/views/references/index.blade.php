@extends('layouts.app')

@section('content')
  <reference-component acc-add="{{ Auth::user()->can('reference create') }}"></reference-component>
@endsection