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

  if (xhr.status == 404) {
    Swal.fire({
      title: 'Sorry!',
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

}