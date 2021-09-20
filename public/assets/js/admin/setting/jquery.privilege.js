var cardForm = $("#card-form"),
  table, validation = false,
  save_method = "add",
  password_retype = true,
  global_id_privilege, select2privilege, privilege_data = []

$(document).ready(function () {
  cardForm.hide()
  $(".add-new-privilege").click(function (e) {
    open_form()
    clearPrivilegeForm()
    save_method = "add"
  })

  table = $("#privilege-table").DataTable({
    "order": [],
    "ajax": {
      "url": base_url + "admin/setting/privilege/datatable",
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

  $("#privilege-form").on("submit", function (e) {
    e.preventDefault()
    const form = this
    var url = ""
    if (save_method == "add") url = base_url + "admin/setting/privilege/save"
    else url = base_url + "admin/setting/privilege/update/" + global_id_privilege
    $.ajax({
      url: url,
      type: "POST",
      data: $(this).serialize(),
      success: function (data) {
        swalSaveSuccess()
        table.ajax.reload()
        clearPrivilegeForm()
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
})

function clearPrivilegeForm() {
  clearForm($("#privilege-form"))
  $("#id_privilege").val("").trigger("change")
}

function open_form() {
  cardForm.show(200), cardForm.removeClass("scale-out-tr")
  cardForm.find(".card-title").html("<i class='fa fa-privilege me-3'></i> Add New privilege")
  $("#name").focus()
}

function edit(id) {
  save_method = "edit"
  global_id_privilege = id
  open_form(), $("#name").focus()
  $.ajax({
    url: base_url + "admin/setting/privilege/edit/" + id,
    type: "GET",
    dataType: "JSON",
    success: function (data) {
      $("#name").val(data.name)
    },
    error: function (x, s, e) {
      reskara_error_handler(x, base_url)
    }
  })
}

function access_setting(id) {
  $.ajax({
    url: base_url + "admin/setting/privilege/get_access_setting/" + id,
    dataType: "JSON",
    success: function (data) {
      privilege_data = data
      render_privilege_menu(privilege_data, id)
    }
  })
  $("#privilege-modal").modal("show")
}

function render_privilege_menu(data, id) {
  let html = ''
  html += find_privilege_child(data, id)

  $("#privilege-modal").find(".modal-body").html(html)
}

function find_privilege_child(data = [], id) {
  let html = ''
  data.forEach(function (e) {
    html += `<div class="ms-3">`
    html += `<input class="pm-control" type="checkbox" ${e.status == "true" ? "checked" : ""} onchange="set_privilege(${e.status}, ${e.id}, ${id}, this)" id="pm-${e.id}" value="${e.id}">`
    html += `<label class='ms-3' for="pm-${e.id}">${e.name}</label>`
    if (e.child.length > 0)
      html += find_privilege_child(e.child, id)
    html += `</div>`
  })
  return html
}

function set_privilege(status, id_menu, id_privilege, el) {
  $("#privilege-modal").find(".modal-body").html(setloading())
  $.ajax({
    url: base_url + "admin/setting/privilege/set_access_setting",
    type: "POST",
    data: {
      status: !status,
      id_menu: id_menu,
      id_privilege: id_privilege
    },
    success: function (data) {
      privilege_data = set_deep_child(privilege_data, status, id_menu)
      render_privilege_menu(privilege_data, id_privilege)
    },
    error: function (x, s, e) {
      reskara_error_handler(x, base_url)
      privilege_data = set_deep_child(privilege_data, !status, id_menu)
      render_privilege_menu(privilege_data, id_privilege)
    }
  })
}

function set_deep_child(data = [], status, id_menu) {
  return data.map(function (v, i) {
    var newData = v
    var children = v.child || []
    if (children.length > 0) {
      newData.child = set_deep_child(newData.child, status, id_menu)
    }

    if (newData.id == id_menu) {
      newData.status = `${!status}`
      return newData
    }
    else return newData

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
        url: base_url + "admin/setting/privilege/delete/" + id,
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