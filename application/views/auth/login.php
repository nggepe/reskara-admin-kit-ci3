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
    <form class="login-form ps-4 pe-4" id="form-login">
      <img src="<?= base_url('public') ?>/assets/img/logos/logo-square.png" class="logo" alt="logo">
      <div class="text-super-black text-family-ssp fs-1" style="font-weight: 700;">Sign in</div>
      <div class="pb-4">Don't have an account? <a href="<?= base_url('public') ?>/">Sign up</a></div>
      <div class="justify-content-center justify-items-center text-center py-3 mb-3 border-danger text-danger is-valid"> Invalid
        username/password </div>
      <div class="loading text-center py-3">
        <div class="d-flex justify-content-center">
          <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div class="spinner-grow text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div class="spinner-grow text-danger" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div class="spinner-grow text-warning" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
        <div class="text-warning pt-3" role="status">
          <span>Loading...</span>
        </div>
      </div>
      <div class="form-group">
        <label for="username">Email/username</label>
        <input type="text" id="username" name="username" required class="form-control">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required class="form-control">
      </div>
      <div class="d-flex justify-items-center justify-content-between align-items-center">
        <div class="d-flex justify-items-center align-items-center">
          <input type="checkbox" id="rememberme" class="me-2">
          <label for="rememberme" class="pointer-cursor">Remember me</label>
        </div>
        <a href="<?= base_url('public') ?>/">Forgot password?</a>
      </div>
      <button class="btn btn-primary btn-block w-100 btn-md mt-5" type="submit">Sign in</button>
    </form>
  </div>
</body>
<script src="<?= base_url('public') ?>/assets/plugins/jquery-3.6.0/jquery.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/sweetalert2/new/sweetalert2.min.js"></script>
<script>
  let base_url = "<?= base_url() ?>"
  const is_valid = $(".is-valid"),
    loading = $(".loading")
  is_valid.hide()
  loading.hide()

  $("#form-login").submit(function(e) {
    loading.fadeIn()
    e.preventDefault()
    $.ajax({
      url: base_url + "auth/sign/in",
      type: "POST",
      data: $(this).serialize(),
      success: function(data) {
        loading.fadeOut()
        location.href = base_url
      },
      error: function(j, s, e) {
        loading.fadeOut()
        is_valid.fadeIn(600)
      }
    })
  })
</script>

</html>