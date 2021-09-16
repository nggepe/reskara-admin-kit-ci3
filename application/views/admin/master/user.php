<link rel="stylesheet" href="<?= base_url() ?>public/assets/plugins/select2-4.1.0/select2.min.css">

<div class="container-xxl">
  <nav class="breadcrumb bg-transparent px-3 align-items-center" aria-label="breadcrumb">
    <div>
      <div class="fs-5 fw-bold text-solid">User</div>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><small>Master</small></a></li>
        <li class="breadcrumb-item active" aria-current="page"><small>User</small></li>
      </ol>
    </div>
    <div>
      <button class="btn btn-primary btn-sm primary-y-shadow add-new-user"><i class="fa fa-plus me-2"></i>Add New User</button>
    </div>
  </nav>
  <div class="row px-3">
    <div class="col-12">
      <div class="card card-success mb-5" id="card-form">
        <div class="card-header">
          <div class="card-title">Add New User</div>
          <div class="card-title-actions">
            <button class="hover-shadow collapse-card" data-hide='<i class="fa fa-plus"></i>' data-show='<i class="fa fa-minus"></i>'>
            </button>
            <button class="hover-shadow full-screen-card"><i class="fa fa-expand"></i></button>
            <button class="hover-shadow close-card"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="collapse-card-item">
          <form id="user-form" action="#" method="POST">
            <div class="card-body text-secondary">
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="full_name">Full Name</label>
                  <input type="text" class="form-control" id="full_name" required name="full_name">
                </div>
                <div class="col-md-6 form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" id="username" required name="username">
                </div>
                <div class="col-md-6 form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" required name="email">
                </div>
                <div class="col-md-6 form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" required id="password" name="password">
                </div>
                <div class="col-md-6 form-group">
                  <label for="retypepassword">Retype Password</label>
                  <input type="password" required class="form-control" id="retypepassword" name="retypepassword">
                </div>
                <div class="col-md-6 form-group">
                  <label for="id_privilege">Privilege</label>
                  <select required class="form-control w-100 d-block" id="id_privilege" name="id_privilege">
                  </select>
                </div>
                <div class="col-md-6 form-group">
                  <label for="phone_number">Phone Number</label>
                  <input type="text" class="form-control" id="phone_number" name="phone_number">
                </div>
                <div class="col-md-6 form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" id="address" name="address">
                </div>
              </div>
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-save me-2"></i> Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title text-secondary"><b>User Data</b></div>
          <div class="card-title-actions">
            <button class="hover-shadow collapse-card" data-hide='<i class="fa fa-plus"></i>' data-show='<i class="fa fa-minus"></i>'>
            </button>
            <button class="hover-shadow full-screen-card"><i class="fa fa-expand"></i></button>
          </div>
        </div>
        <div class="collapse-card-item">
          <div class="card-body text-secondary">
            <table class='table table-stripped table-bordered table-hovered w-100' id="user-table">
              <thead class="text-center">
                <th>No.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>#</th>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url() ?>public/assets/js/components.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables-1.11.1/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/select2-4.1.0/select2.min.js"></script>
<script>
  var cardForm = $("#card-form"),
    table, validation = false,
    save_method = "add",
    password_retype = true,
    global_id_user, select2privilege

  $(document).ready(function() {
    cardForm.hide()
    $(".add-new-user").click(function(e) {
      open_form()
      clearUserForm()
      save_method = "add"
    })

    table = $("#user-table").DataTable({
      "order": [],
      "ajax": {
        "url": base_url + "admin/master/user/datatable",
        "type": "POST",
      },

      "columnDefs": [{
          "targets": [0],
          "orderable": false,
        },
        {
          "targets": [0],
          "className": "details-control w20"
        },
        {
          "targets": [1, 2],
          "className": "details-control"
        },
        {
          "targets": [-1],
          "className": "text-center"
        },
      ],
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "processing": true,
      "scrollCollapse": true,
      "language": {
        paginate: {
          previous: "<i class='fas fa-angle-left'>",
          next: "<i class='fas fa-angle-right'>"
        },
      },
    })

    $("#user-form").on("submit", function(e) {
      e.preventDefault()
      const form = this
      var url = ""
      if (save_method == "add") url = base_url + "admin/master/user/save"
      else url = base_url + "admin/master/user/update/" + global_id_user
      $.ajax({
        url: url,
        type: "POST",
        data: $(this).serialize(),
        success: function(data) {
          swalSaveSuccess()
          table.ajax.reload()
          clearUserForm()
          cardForm.hide(200)
        },
        error: function(x, s, e) {
          reskara_error_handler(x, base_url)
        }
      })
    })

    $("#retypepassword").keyup(function(e) {
        retypeValidation(this)
      }),
      $("#retypepassword").on("blur", function(e) {
        retypeValidation(this)
      })

    function retypeValidation(el) {
      const parentGroup = $(el).parents(".form-group")

      if ($(el).val() == $("#password").val())
        parentGroup.removeClass("has-error"), parentGroup.find(".text-helper").remove(), password_retype = true;
      else {
        if (parentGroup.hasClass("has-error") == false)
          parentGroup.addClass("has-error"),
          parentGroup.append("<small class='text-danger text-helper'>Password isn't match!</small>")

        password_retype = false;
      }
    }

    $(document).on('select2:open', () => {
      document.querySelector('.select2-search__field').focus();
    });
    select2privilege = $("#id_privilege").select2({
      ajax: {
        url: base_url + 'admin/master/user/select2_privilege',
        dataType: 'json',
        data: function(params) {
          return {
            q: params.term,
            page: params.page
          }
        },
        processResults: function(data, params) {
          return {
            results: data.items,
            pagination: {
              more: (data.count == 10)
            },
            cache: true
          };
        },
        error: function(xhr, status, error) {
          reskara_error_handler(xhr, base_url)
        }
      },
      id: function(data) {
        return data.id
      },
      templateResult: function(data) {
        return $(`
        <div class='select2-result-repository clearfix'>
            ${data.name}
        </div>
        `)
      },
      templateSelection: function(data) {
        $(this).val(data.id)

        return data.name || data.text
      },
      placeholder: "Privilege",
      allowClear: true,
      width: "resolve"
    })
  })

  function clearUserForm() {
    clearForm($("#user-form"))
    $("#id_privilege").val("").trigger("change")
  }

  function open_form() {
    cardForm.show(200), cardForm.removeClass("scale-out-tr")
    cardForm.find(".card-title").html("<i class='fa fa-user me-3'></i> Add New User")
    $("#full_name").focus()
  }

  function edit(id) {
    save_method = "edit"
    global_id_user = id
    open_form(), $("#full_name").focus()
    $.ajax({
      url: base_url + "admin/master/user/edit/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $("#full_name").val(data.full_name)
        $("#username").val(data.username)
        $("#email").val(data.email)
        $("#phone_number").val(data.phone_number)
        $("#address").val(data.address)

        var option = new Option(data.privilege, data.id_privilege, false, false)
        select2privilege.append(option).trigger("change")
        select2privilege.val(data.id_privilege)

      },
      error: function(x, s, e) {

      }
    })
  }

  function deleteData(id) {
    Swal.fire({
      title: 'Anda yakin?',
      text: "Data akan dihapus secara permanent!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya!',
      cancelButtonText: 'Batal'
    }).then(function(result) {
      if (result.isConfirmed) {
        // showLoading()
        $.ajax({
          url: base_url + "admin/master/user/delete/" + id,
          type: 'GET',
          success: function(data) {
            table.ajax.reload()
            alertDeleteSuccess()
          },
          error: function(xhr, status, error) {
            reskara_error_handler(xhr, base_url)
          }
        })
      }
    })
  }
</script>