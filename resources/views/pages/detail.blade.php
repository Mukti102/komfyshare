@extends('layouts.guest')
@section('title', $product->title)
@section('content')
<section class="bg-black">
    <x-alert/>
    <x-hero-detail :product="$product" />
    <x-detail-product :product="$product" />
</section>
@endsection
