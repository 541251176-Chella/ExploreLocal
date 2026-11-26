@extends('layouts.admin')

@section('title', 'Edit Destinasi')
@section('heading', 'Edit Destinasi')
@section('crumb')<a href="{{ route('admin.destinations.index') }}">Destinasi</a> / Edit @endsection

@section('content')
    @include('admin.destinations._form')
@endsection
