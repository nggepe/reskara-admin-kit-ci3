var cardForm = $("#card-form"),
  table, validation = false,
  save_method = "add",
  password_retype = true,
  global_id_user, select2privilege

$(document).ready(function () {
  cardForm.hide()
  $(".add-new-user").click(function (e) {
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

  $("#user-form").on("submit", function (e) {
    e.preventDefault()
    const form = this
    var url = ""
    if (save_method == "add") url = base_url + "admin/master/user/save"
    else url = base_url + "admin/master/user/update/" + global_id_user
    $.ajax({
      url: url,
      type: "POST",
      data: $(this).serialize(),
      success: function (data) {
        swalSaveSuccess()
        table.ajax.reload()
        clearUserForm()
        cardForm.hide(200)
      },
      error: function (x, s, e) {
        reskara_error_handler(x, base_url)
      }
    })
  })

  $("#retypepassword").keyup(function (e) {
    retypeValidation(this)
  }),
    $("#retypepassword").on("blur", function (e) {
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

  select2privilege = $("#id_privilege").select2({
    ajax: {
      url: base_url + 'admin/master/user/select2_privilege',
      dataType: 'json',
      data: function (params) {
        return {
          q: params.term,
          page: params.page
        }
      },
      processResults: function (data, params) {
        return {
          results: data.items,
          pagination: {
            more: (data.count == 10)
          },
          cache: true
        };
      },
      error: function (xhr, status, error) {
        reskara_error_handler(xhr, base_url)
      }
    },
    id: function (data) {
      return data.id
    },
    templateResult: function (data) {
      return $(`
        <div class='select2-result-repository clearfix'>
            ${data.name}
        </div>
        `)
    },
    templateSelection: function (data) {
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
    success: function (data) {
      $("#full_name").val(data.full_name)
      $("#username").val(data.username)
      $("#email").val(data.email)
      $("#phone_number").val(data.phone_number)
      $("#address").val(data.address)

      var option = new Option(data.privilege, data.id_privilege, false, false)
      select2privilege.append(option).trigger("change")
      select2privilege.val(data.id_privilege)

    },
    error: function (x, s, e) {

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
  }).then(function (result) {
    if (result.isConfirmed) {
      // showLoading()
      $.ajax({
        url: base_url + "admin/master/user/delete/" + id,
        type: 'GET',
        success: function (data) {
          table.ajax.reload()
          alertDeleteSuccess()
        },
        error: function (xhr, status, error) {
          reskara_error_handler(xhr, base_url)
        }
      })
    }
  })
}