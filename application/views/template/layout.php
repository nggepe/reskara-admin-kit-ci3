<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reskara Bootsrap</title>
  <link rel="icon" href="<?= base_url('public') ?>/assets/img/logos/logo-square.png" type="image/icon type">
  <link rel="stylesheet" href="<?= base_url('public') ?>/assets/plugins/bootstrap-5.0.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('public') ?>/assets/plugins/highlightjs-11.1.0/atom-one-dark.min.css">
  <link rel="stylesheet" href="<?= base_url('public') ?>/assets/css/style.css">
</head>

<body>
  <noscript>
    <p>To display this page you need a browser that supports JavaScript.</p>
  </noscript>
  <nav class="side-nav">
    <div class="logo">
      <a href="index.html"><img src="<?= base_url('public') ?>/assets/img/logos/logo-landscape.png" alt="logo"></a>
      <button class="btn btn-default ml-auto py-0 px-0 minify-sidenav"><i class="fa fa-align-justify"></i><i class="fa fa-align-right"></i></button>
    </div>
    <div class="d-flex justify-content-center mb-2">
      <img src="<?= base_url() . $profile->avatar ?>" class="avatar" alt="gp">
    </div>
    <div class="text-center mini-hide"> <span><?= $profile->full_name ?></span> </div>
    <div class="text-center mini-hide text-tertiary mb-3">
      <small><?= $profile->email ?></small>
    </div>
    <?= $menu ?>
  </nav>
  <nav class="appbar">
    <div class="appbar-items">
      <button class="sidebar-btn-mobile"><i class="fa fa-align-justify"></i></button>
      <form action="#">
        <div class="appbar-form-group">
          <label class="icon" for="appbar-search"><i class="fa fa-search"></i></label>
          <input type="text" id="appbar-search" class="appbar-search" placeholder="Search">
        </div>
      </form>
    </div>
    <div class="appbar-items">
      <ul class="appbar-menu">
        <li><a href="#"><i class="fa fa-bell"></i><span class="caption">Notifications</span></a></li>
        <li><a href="#"><i class="fa fa-envelope"></i><span class="caption">Emails</span></a></li>
        <li class="dropdown"><a href="#"><img src="<?= base_url() . $profile->avatar ?>" alt="gp" class="appbar-avatar"><span class="caption visible"><?= $profile->full_name ?></span></a>
          <ul class="py-2 primary-y-shadow rounded-3">
            <li><a href="#" class="py-1 d-flex justify-items-center">
                <i class="fa fa-user text-blue me-2"></i>
                <div>Profile</div>
              </a></li>
            <li><a href="<?= base_url('auth/sign/logout') ?>" class="py-1 d-flex justify-items-center">
                <i class="fa fa-sign-out-alt text-danger me-2"></i>
                <div>logout</div>
              </a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <div class="r-container" id="content">
    <!-- here is your content fully loaded -->
  </div>
  <footer class="r-footer a-bold">
    <div class="container-xxl d-flex justify-content-between align-middle">
      <div><a href="https://github.com/nggepe/reskara-bootstrap" target="_blank">Github Repository</a></div>
      <div class="text-end"><span class="me-1">2021??</span> <a href="https://github.com/nggepe" target="_blank">Gilang
          Pratama</a></div>
    </div>
  </footer>
  <script src="<?= base_url('public') ?>/assets/plugins/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('public') ?>/assets/plugins/jquery-3.6.0/jquery.min.js"></script>
  <script src="<?= base_url('public') ?>/assets/js/reskara-bootstrap.js"></script>
  <script src="<?= base_url() ?>public/assets/plugins/sweetalert2/new/sweetalert2.min.js"></script>
  <script src="<?= base_url() ?>public/assets/js/jquery.form-helper.js"></script>
  <script>
    $(document).ready(function() {
      const awesome = document.createElement("link")
      awesome.setAttribute("rel", "stylesheet")
      awesome.setAttribute("href", "<?= base_url('public') ?>/assets/plugins/fontawesome-free/css/all.min.css")
      document.querySelector("head").appendChild(awesome)

    })
  </script>
  <script>
    const base_url = "<?= base_url() ?>"
    if (window.location.pathname.substr(window.location.pathname.length - 1) != "/") location.href = location.href + "/"

    const content = document.getElementById("content")

    if (window.location.hash !== "") loading(window.location.hash.substr(2), window.location.hash)
    else loading("admin/dashboard")

    window.addEventListener("hashchange", function(ev) {
      const href = findHash(ev.newURL);
      if (href.valid) loading(href.url, "none")
    })

    function findHash(url) {
      let valid = false;
      for (var i = 0; i < url.length; i++) {
        if (url.substring(i, i + 1) == "#") {
          var newUrl = url.substring(i)
          if (newUrl.substring(0, 1) == "#" && newUrl.substring(0, 2) == "#/") {
            newUrl = newUrl.substring(2)
            valid = true;
            break
          } else if (newUrl.substring(0, 1) == "#") {
            newUrl = newUrl.substring(1)
            break
          }
        }
      }
      return {
        url: newUrl,
        valid: valid
      }
    }
    $("nav.side-nav").find("a").click(function(e) {
      e.preventDefault()
      const href = $(this).attr("href"),
        host = href.replace(/(http:\/\/|https:\/\/)/g, "").split("/")[0],
        isHosted = href.includes("http://") || href.includes("https://"),
        target = $(this).attr("target")

      if (href !== "javascript:" && href !== "#" && href !== "index.html") window.location.hash = "/" + href
    })

    function loading(url, after = "") {
      $("#content").html(setloading())
      $.ajax({
        url: base_url + url,
        type: "GET",
        mimeType: "text/html charset=utf-8",
        async: true,
        cache: false,
        success: function(data) {
          $("#content").html(data)
          if (after != "none") window.location.hash = after
        },
        error: function(xhr, status, error) {
          reskara_error_handler(xhr, base_url)
        }
      })
    }
  </script>
</body>

</html>