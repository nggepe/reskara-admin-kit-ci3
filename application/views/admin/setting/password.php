<div class="container-xxl">
  <nav class="breadcrumb bg-transparent px-3 align-items-center" aria-label="breadcrumb">
    <div>
      <div class="fs-5 fw-bold text-solid">Password</div>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><small>Setting</small></a></li>
        <li class="breadcrumb-item active" aria-current="page"><small>password</small></li>
      </ol>
    </div>
  </nav>

  <div class="row px-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <b class="text-secondary">Change Password</b>
          </div>
        </div>
        <form action="#" id="save_password">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 form-group">
                <label for="old_password">Old Password</label>
                <input type="password" required class="form-control" id="old_password" name="old_password">
              </div>
              <div class="col-md-6 form-group">
                <label for="new_password">New Password</label>
                <input type="password" required class="form-control" id="new_password" name="new_password">
              </div>
              <div class="col-md-6 form-group">
                <label for="retype_new_password">Retype New Password</label>
                <input type="password" required class="form-control" id="retype_new_password" name="retype_new_password">
              </div>
            </div>
          </div>
          <div class="card-footer text-end">
            <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-save"></i> Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(e) {
    var passwordValidate = ""
    $("#save_password").submit(function(e) {
      e.preventDefault()
    })

    $("#old_password").keyup(function(e) {
      const el = $(this)
      const value = el.val();

      $.ajax({
        url: base_url + "admin/setting/password/password_validate",
        type: "POST",
        dataType: "JSON",
        data: {
          password: value
        },
        success: function(data) {
          console.log(data)
          if (data == "success") {
            el.parents(".form-group").removeClass("has-error")
            el.parents(".form-group").find(".text-helper").remove()

          } else {
            const formGroup = el.parents(".form-group")
            if (formGroup.hasClass("has-error") == false) {
              formGroup.addClass("has-error")
              formGroup.append("<small class='text-danger text-helper'>Incorrect password<small>")
            }
          }
        },
        error: function(x, s, e) {
          reskara_error_handler(x, base_url)
        }
      })
    })
  })
</script>