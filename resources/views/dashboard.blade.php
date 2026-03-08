@extends('layouts.app')

@section('content')

    {{-- ⭐ HERO SECTION --}}
    <x-hero/>
  <x-pet-pharmacy-baby :products="$products" />

    {{-- ⭐ CATEGORY SLIDER --}}
    <x-catgry :categories="$categories" />

    {{-- ⭐ PHARMACY BANNER --}}
  

    {{-- ⭐ 3 CARDS / FEATURED PRODUCTS SLIDER --}}
   <section class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-10">

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Banner 1 -->
    

    <!-- Banner 2 -->
    
  </div>

</section>

@endsection
