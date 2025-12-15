@extends('layouts.public')

@section('title', 'Beranda - Dinas Kesehatan Kota Kediri')

@section('content')
    <div class="min-h-screen">
        <x-jumbotron />
        <x-slider :sliders="$sliders" />
    </div>
@endsection