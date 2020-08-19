@extends('layouts.app')

@section('content')
  <user-component acc-add="{{ Auth::user()->can('user create') }}"></user-component>
@endsection