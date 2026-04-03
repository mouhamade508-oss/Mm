@extends('layouts.pro-store')

@section('content')
<style>
:root {
  --primary: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
  --glow: 0 25px 50px rgba(59,130,246,0.4);
}

.section-hero {
  background: var(--primary);
  color: white;
  text-align: center;
  padding: 4rem 2rem;
  margin-bottom: 3rem;
  border-radius: 20px;
  box-shadow: var(--glow);
}

.section-title { font-size: 3rem; font-weight: 900; margin-bottom: 1rem; }
.section-desc { font-size: 1.2rem; opacity: 0.95; }

.categories-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
}

.category-card {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  box-shadow: 0 10px 25px rgba(59,130,246,0.15);
  transition: all 0.3s ease;
  text-decoration: none;
  color: inherit;
  cursor: pointer;
  text-align: center;
  border: 2px solid transparent;
}

.category-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(59,130,246,0.25);
  border-color: #3b82f6;
}

.category-card h3 { font-weight: 800; margin-bottom: 0.5rem; color: #1e293b; }
.category-card .count { color: #999; font-size: 0.9rem; }

.products-section {
  margin-top: 3rem;
}

.section-divider {
  text-align: center;
  margin: 2rem 0;
  color: #999;
  font-size: 1.5rem;
}

.filters-store {
  background: rgba(255,255,255,0.95);
  backdrop-filter: blur(20px);
  padding: 2rem;
  border-radius: 16px;
  box-shadow: var(--glow);
  margin-bottom: 2rem;
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

.product-name { font-weight: 700; font-size: 1.1rem; margin-bottom: 0.5rem; }
.product-price { font-size: 1.5rem; font-weight: 900; color: #3b82f6; }
</style>

<div class="py-4">
  <!-- Hero Section -->
  <section class="section-hero">
    <h1 class="section-title">{{ $section->icon ?? '📁' }} {{ $section->name }}</h1>
    <p class="section-desc">{{ $section->description }}</p>
  </section>

  <!-- Categories Navigation -->
  <section>
    <h2 style="font-weight: 800; margin-bottom: 1.5rem; color: #1e293b;">الفئات</h2>
    <div class="categories-grid">
      @foreach($categories as $cat)
        <a href="{{ route('section.category.show', [$section, $cat]) }}" class="category-card">
          <h3>{{ $cat->name }}</h3>
          <div class="count">{{ $cat->products()->count() }} منتج</div>
        </a>
      @endforeach
    </div>
  </section>

  <!-- Filters -->
  <section class="section-divider">
    <h2 style="font-weight: 800; margin: 2rem 0 1.5rem; color: #1e293b;">جميع المنتجات</h2>
  </section>

  <section class="filters-store">
    <form method="GET" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem;">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 ابحث عن منتج" style="padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px;">
      
      <select name="category" style="padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px;">
        <option value="">كل الفئات</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>

      <button type="submit" style="background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; cursor: pointer; font-weight: bold;">بحث</button>
    </form>
  </section>

  <!-- Products Grid -->
  @if($products->count() > 0)
    <div class="products-container">
      @foreach($products as $product)
        <div class="product-card">
          @if($product->image)
            <img src="{{ $product->image_url }}" class="product-image">
          @else
            <div class="product-image" style="display: flex; align-items: center; justify-content: center; font-size: 3rem;">📦</div>
          @endif
          <div class="product-info">
            <div class="product-name">{{ $product->name }}</div>
            <div class="product-price">{{ number_format($product->price, 0) }} {{ $product->currency == 'USD' ? '$' : 'ل.س' }}</div>
            <a href="{{ route('product.show', $product) }}" style="display: inline-block; background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; margin-top: 1rem;">عرض المنتج</a>
          </div>
        </div>
      @endforeach
    </div>

    @if($products->hasPages())
      <div style="text-align: center;">
        {{ $products->links() }}
      </div>
    @endif
  @else
    <div style="background: white; border-radius: 12px; padding: 4rem 2rem; text-align: center;">
      <p style="color: #999; font-size: 1.1rem;">لا توجد منتجات في هذا القسم</p>
    </div>
  @endif
</div>
@endsection
