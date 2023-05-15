function deleteswal(id) {
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success ms-1 swalbtn',
      cancelButton: 'btn btn-danger me-1'
    },
    buttonsStyling: false
  })
  
  swalWithBootstrapButtons.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete Meal!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      swalWithBootstrapButtons.fire(
        'Deleted!',
        'The Meal has been deleted.',
        'success',
        setTimeout(function(){
            window.location.href = '/admin/meal' + id + '/delete'
        }, 1300)
      )
    } else if (
      /* Read more about handling dismissals below */
      result.dismiss === Swal.DismissReason.cancel
    ) {
      swalWithBootstrapButtons.fire(
        'Cancelled',
        'Meal Delete cancelled',
        'error'
      )
    }
  })
}

// let myform = document.getElementById("searchform")
// myform.preventDefault();

function searchName() {
  event.preventDefault();
  let search = document.getElementById("search").value;
  window.location.href = '/admin/meal/' + search;
}