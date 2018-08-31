@extends('layouts.main')

@section('breadcrumbs')
    <h1 class="h2">Dashboard / API Access </h1><small class="bInfo">API Access Generator</small>
@endsection

@section('content')
    <passport-clients></passport-clients><br />
    <passport-authorized-clients></passport-authorized-clients><br />
    <passport-personal-access-tokens></passport-personal-access-tokens>
@endsection

@section('script')
@endsection