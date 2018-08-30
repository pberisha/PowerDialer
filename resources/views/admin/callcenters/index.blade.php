@extends('layouts.main')

@section('breadcrumbs')
    <h1 class="h2">Dashboard / CallCenters </h1><small class="bInfo">CRUD Operations for CallCenters</small>
@endsection

@section('content')
    <call-centers apitoken="{{ Auth::user()->remember_token }}"></call-centers>

@endsection

@section('script')
@endsection