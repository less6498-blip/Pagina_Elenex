<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | Elenex</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #111;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      background: #fff;
      border-radius: 16px;
      padding: 40px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 20px 60px rgba(0,0,0,.4);
    }
    .login-logo {
      text-align: center;
      margin-bottom: 32px;
    }
    .login-logo img { height: 45px; }
    .login-logo p {
      font-size: 13px;
      color: #888;
      margin-top: 8px;
      margin-bottom: 0;
    }
    .form-control {
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 14px;
      border: 1.5px solid #e5e5e5;
    }
    .form-control:focus {
      border-color: #111;
      box-shadow: none;
    }
    .btn-login {
      background: #111;
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 13px;
      font-weight: 700;
      font-size: 15px;
      width: 100%;
      transition: background .2s;
    }
    .btn-login:hover { background: #333; }
  </style>
</head>
<body>

<div class="login-card">
  <div class="login-logo">
    <img src="{{ asset('img/elelogo.webp') }}" alt="Elenex">
    <p>Panel Administrador</p>
  </div>

  @if(session('error'))
    <div class="alert alert-danger rounded-3 py-2" style="font-size:13px;">
      {{ session('error') }}
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger rounded-3 py-2" style="font-size:13px;">
      {{ $errors->first() }}
    </div>
  @endif

  <form action="{{ route('admin.login.post') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label fw-medium" style="font-size:14px;">Correo electrónico</label>
      <input type="email" name="email" value="{{ old('email') }}"
             class="form-control" placeholder="admin@elenex.com" required autofocus>
    </div>
    <div class="mb-4">
      <label class="form-label fw-medium" style="font-size:14px;">Contraseña</label>
      <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-4">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember" style="font-size:13px;color:#888;">
          Mantener sesión iniciada
        </label>
      </div>
    </div>
    <button type="submit" class="btn-login">Iniciar sesión →</button>
  </form>
</div>

</body>
</html>