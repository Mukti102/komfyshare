@extends('layouts.guest')
@section('title', $product->title)
@section('content')
<section class="bg-black">
    <x-hero-detail :product="$product" />
    <x-detail-product :product="$product" />
</section>
@endsection
