@extends('layouts.admin')

@section('title', 'Tambah Destinasi')
@section('heading', 'Tambah Destinasi')
@section('crumb')<a href="{{ route('admin.destinations.index') }}">Destinasi</a> / Tambah @endsection

@section('content')
    @include('admin.destinations._form')
@endsection
