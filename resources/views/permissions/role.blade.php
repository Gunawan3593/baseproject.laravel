@extends('layouts.app')

@section('content')
  <!-- <role-component acc-add="{{ Auth::user()->can('role create') }}"></role-component> -->
  <role-component acc-add="true"></role-component>
@endsection