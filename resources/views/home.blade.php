@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<p>Welcome to this beautiful admin panel.</p>
<form action="">
    {{app()->getLocale()}}
    @include('partials.fileinput', ['model' => 'upload_file', 'multiple' => true, 'value' => isset($_GET['upload_file']) ? $_GET['upload_file'] : ''])
    <x-adminlte-button label="Submit" type="submit" />
</form>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop