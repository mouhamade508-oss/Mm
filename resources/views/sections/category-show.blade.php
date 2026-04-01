@extends('layouts.pro-store')

@section('content')
<style>
:root {
  --primary: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
  --glow: 0 25px 50px rgba(59,130,246,0.4);
}

.breadcrumb {
  margin-bottom: 2rem;
  font-size: 0.95rem;
}

.breadcrumb a { color: #3b82f6; text-decoration: none; font-weight: 600; }
.breadcrumb a:hover { text-decoration: underline; }

.header-bar {
  background: var(--primary);
  color: white;
  padding: 2rem;
  border-radius: 16px;
  margin-bottom: 2rem;
  box-shadow: var(--glow);
}

.header-bar h1 { font-size: 2.5rem; font-weight: 900; margin-bottom: 0.5rem; }
.header-bar p { opacity: 0.95; }

.filters-store {
  background: white;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  margin-bottom: 2rem;
}

.category-pills {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
  margin-bottom: 1.5rem;
}

.pill {
  padding: 0.75rem 1.5rem;
  border-radius: 20px;
  background: #e5e7eb;
  color: #333;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: 600;
  border: 2px solid transparent;
}

.pill.active {
  background: var(--primary);
  color: white;
}

.pill:hover {
  background: var(--primary);
  color: white;
}

.products-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 2rem;
  margin-bottom: 3rem;
}

.product-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(59,130,246,0.2);
}

.product-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  background: #f3f4f6;
}

.product-info {
  padding: 1.5rem;
}

.product-name { font-weight: 700; font-size: 1.1rem; margin-bottom: 0.5rem; color: #1e293b; }
.product-price { font-size: 1.5rem; font-weight: 900; color: #3b82f6; margin-bottom: 1rem; }
.view-btn {
  display: inline-block;
  background: #3b82f6;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 6px;
  text-decoration: none;
  font-size: 0.9rem;
}
.view-btn:hover {
  background: #1e40af;
}
</style>

<div class="py-4">
  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="/">الرئيسية</a> / 
    <a href="{{ route('section.show', $section) }}">{{ $section->name }}</a> / 
    <span style="color: #666;">{{ $category->name }}</span>
  </div>

  <!-- Header -->
  <div class="header-bar">
    <h1>{{ $section->icon ?? '📁' }} {{ $category->name }}</h1>
    <p>{{ $category->description }}</p>
  </div>

  <!-- Category Navigation -->
  <section class="filters-store">
    <h3 style="font-weight: 800; margin-bottom: 1rem; color: #1e293b;">الفئات الأخرى في {{ $section->name }}</h3>
    <div class="category-pills">
      @foreach($categories as $cat)
        <a href="{{ route('section.category.show', [$section, $cat]) }}" 
           class="pill {{ $cat->id === $category->id ? 'active' : '' }}">
          {{ $cat->name }} ({{ $cat->products()->count() }})
        </a>
      @endforeach
    </div>
  </section>

  <!-- Filters & Search -->
  <section class="filters-store">
    <form method="GET" style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 1rem;">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 ابحث عن منتج" style="padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px;">
      
      <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="السعر من" style="padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px;">
      
      <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="السعر إلى" style="padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px;">

      <button type="submit" style="background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; cursor: pointer; font-weight: bold;">بحث</button>
    </form>
  </section>

  <!-- Products Grid -->
  @if($products->count() > 0)
    <div class="products-container">
      @foreach($products as $product)
        <div class="product-card">
          @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="product-image">
          @else
            <div class="product-image" style="display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
          @endif
          <div class="product-info">
            <div class="product-name">{{ $product->name }}</div>
            <p style="color: #999; font-size: 0.9rem; margin-bottom: 1rem;">{{ Str::limit($product->description, 60) }}</p>
            <div class="product-price">{{ $product->price }}دولار</div>
            <a href="{{ route('product.show', $product) }}" class="view-btn">عرض المنتج</a>
          </div>
        </div>
      @endforeach
    </div>

    @if($products->hasPages())
      <div style="text-align: center; margin-top: 2rem;">
        {{ $products->links() }}
      </div>
    @endif
  @else
    <div style="background: white; border-radius: 12px; padding: 4rem 2rem; text-align: center;">
      <p style="color: #999; font-size: 1.1rem;">لا توجد منتجات في هذه الفئة</p>
    </div>
  @endif
</div>
@endsection
