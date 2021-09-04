<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="icon" href="<?= base_url('public') ?>/assets/img/logos/logo-square.png" type="image/icon type">
  <link rel="stylesheet" href="<?= base_url('public') ?>/assets/plugins/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('public') ?>/assets/css/style.css">
</head>

<body>
  <noscript>
    <p>To display this page you need a browser that supports JavaScript.</p>
  </noscript>
  <div class="d-flex justify-content-center justify-items-center">
    <form class="login-form ps-4 pe-4">
      <img src="<?= base_url('public') ?>/assets/img/logos/logo-square.png" class="logo" alt="logo">
      <div class="text-super-black text-family-ssp fs-1" style="font-weight: 700;">Sign in</div>
      <div class="pb-4">Don't have an account? <a href="<?= base_url('public') ?>/">Sign up</a></div>
      <div class="form-group">
        <label for="username">Email/username</label>
        <input type="text" id="username" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" class="form-control">
      </div>
      <div class="d-flex justify-items-center justify-content-between align-items-center">
        <div class="d-flex justify-items-center align-items-center">
          <input type="checkbox" id="rememberme" class="me-2">
          <label for="rememberme" class="pointer-cursor">Remember me</label>
        </div>
        <a href="<?= base_url('public') ?>/">Forgot password?</a>
      </div>
    </form>
  </div>
</body>

</html>