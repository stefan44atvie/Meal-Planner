function deleteswal2(id) {
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
        confirmButtonText: 'Yes, delete User!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire(
            'Deleted!',
            'The User has been deleted.',
            'success',
            setTimeout(function(){
                window.location.href = '/admin/user' + id + '/delete'
            }, 1300)
          )
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'User Delete cancelled',
            'error'
          )
        }
      })
    }
    
    
    function searchName() {
      event.preventDefault();
      let search = document.getElementById("search").value;
      window.location.href = '/admin/user/' + search;
    }