function reskara_error_handler(xhr, base_url) {

  if (xhr.status == 401) {
    Swal.fire({
      title: 'Sorry!',
      text: "You have no session anymore!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya!',
      cancelButtonText: 'Batal'
    }).then(function (result) {
      if (result.isConfirmed) {
        location.href = base_url + "auth/sign/login"
      }
    })
  }

  else if (xhr.status == 404) {
    Swal.fire({
      title: '404',
      text: "There is no page here!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya!',
      cancelButtonText: 'Batal'
    }).then(function (result) {
      if (result.isConfirmed) {
        window.history.back()
      }
    })
  }

  else {
    Swal.fire({
      title: "Oops!",
      text: xhr.responseText,
      icon: "warning",
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ya!',
    })
  }
}

function swalSaveSuccess() {
  Swal.fire({
    title: 'Great!',
    text: "The data have been save successfully!",
    icon: "success",
  })
}

function alertDeleteSuccess() {
  Swal.fire({
    title: 'Great!',
    text: "The data have been deleted!",
    icon: "success",
  })
}

function clearForm(el) {
  el.find("input").val("")
  el.find("textarea").val("")
  el.find("select").val("")
}

function setloading() {
  return `<div style="margin-top: auto; margin-bottom: auto" class="d-flex justify-content-center">
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
</div>`
}