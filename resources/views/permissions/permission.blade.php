@extends('layouts.app')

@section('content')
  <permission-component acc-add="{{ Auth::user()->can('permission create') }}"></permission-component>
@endsection