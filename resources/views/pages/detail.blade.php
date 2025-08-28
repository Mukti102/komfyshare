@extends('layouts.guest')
@section('title', 'Product Detail')
@section('content')
<section class="bg-black">
    <x-hero-detail :product="$product" />
    <x-detail-product :product="$product" />
</section>
@endsection
