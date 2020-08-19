@extends('layouts.app')

@section('content')
  <page-component acc-add="{{ Auth::user()->can('page create') }}"></page-component>
@endsection