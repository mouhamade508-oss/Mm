@extends('layouts.pro-store')

@section('title', 'تسجيل الدخول - لوحة الإدارة')

@section('content')
<style>
:root {
  --blue-hero: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
  --blue-glow: 0 25px 50px rgba(59,130,246,0.4);
  --card-radius: 28px;
}

.login-hero {
  background: var(--blue-hero);
  color: white;
  text-align: center;
  padding: 5rem 2rem;
  margin-bottom: 3rem;
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
}

.login-hero h1 {
  font-size: 3.2rem;
  font-weight: 900;
  margin-bottom: 1rem;
}

.login-container {
  max-width: 420px;
  margin: 0 auto;
}

.login-card {
  background: rgba(255,255,255,0.95);
  backdrop-filter: blur(20px);
  padding: 3.5rem;
  border-radius: var(--card-radius);
  box-shadow: var(--blue-glow);
  border: 1px solid rgba(59,130,246,0.2);
}

.form-group {
  margin-bottom: 2rem;
}

.label-modern {
  display: block;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 0.8rem;
  font-size: 1.1rem;
}

.input-modern {
  width: 100%;
  padding: 1.3rem 1.8rem;
  border: 2px solid #e0e7ff;
  border-radius: 18px;
  font-size: 1.1rem;
  background: linear-gradient(145deg, #ffffff, #f8fafc);
  transition: all 0.3s ease;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
  font-family: 'Tajawal', sans-serif;
}

.input-modern:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 4px rgba(59,130,246,0.15);
  outline: none;
  transform: translateY(-1px);
}

.btn-login {
  background: var(--blue-hero);
  color: white;
  border: none;
  padding: 1.4rem 3rem;
  border-radius: 22px;
  font-size: 1.15rem;
  font-weight: 800;
  cursor: pointer;
  width: 100%;
  box-shadow: var(--blue-glow);
  transition: all 0.4s ease;
}

.btn-login:hover {
  transform: translateY(-3px);
  box-shadow: 0 25px 50px rgba(59,130,246,0.5);
}

.error-msg {
  background: linear-gradient(135deg, #fee2e2, #fecaca);
  border: 1px solid #fca5a5;
  border-radius: 16px;
  padding: 1.2rem;
  color: #dc2626;
  margin-bottom: 1.5rem;
  font-size: 1rem;
}

.remember-check {
  display: flex;
  align-items: center;
  gap: 0.8rem;
  margin-bottom: 1.5rem;
}

.remember-check input {
  width: auto;
  accent-color: #3b82f6;
}

.admin-info {
  text-align: center;
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid rgba(59,130,246,0.2);
  color: #64748b;
  font-size: 0.95rem;
}

@media (max-width: 480px) {
  .login-card {
    padding: 2.5rem 2rem;
    margin: 0 1rem;
  }
}
</style>

<div class="py-6">
  <section class="login-hero">
    <h1>🔐 لوحة الإدارة</h1>
    <p>تسجيل الدخول لإدارة المنتجات</p>
  </section>

  <div class="login-container">
    @if ($errors->any())
      <div class="error-msg">
        <strong>خطأ:</strong> {{ $errors->first() }}
      </div>
    @endif

    @if (session('error'))
      <div class="error-msg">
        {{ session('error') }}
      </div>
    @endif

    <div class="login-card">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="form-group">
          <label class="label-modern">📧 البريد الإلكتروني</label>
          <input type="email" name="email" class="input-modern" value="{{ old('email') }}" required 
                 placeholder=" البريد الإلكتروني" autofocus>
        </div>

        <div class="form-group">
          <label class="label-modern">🔑 كلمة المرور</label>
          <input type="password" name="password" class="input-modern" required placeholder="••••••••">
        </div>

        <div class="remember-check">
          <input type="checkbox" name="remember" id="remember">
          <label for="remember">تذكرني</label>
        </div>

        <button type="submit" class="btn-login">دخول الإدارة</button>
      </form>

      <div class="admin-info">
        <strong>👨‍💼 </strong><br>
       <br>
       
      </div>
    </div>
  </div>
</div>
@endsection

