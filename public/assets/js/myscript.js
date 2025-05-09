document.addEventListener('DOMContentLoaded', function () {
  const selectAll = document.getElementById('selectAll');
  const btnHapus = document.getElementById('btnHapusBanyak');

  const table = $('#datatabel').DataTable({
    paging: true,
    searching: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    ordering: false,
    language: {
      zeroRecords: "Data tidak ditemukan"
    },
    columnDefs: [
      { className: "text-center", targets: "_all" } 
    ],
    dom: '<"row mb-3"<"col-12 col-md-6 mb-2"l><"col-12 col-md-6"f>>t<"row mt-3"<"col-sm-6"i><"col-sm-6"p>>'
  });

  table.on('order.dt search.dt draw.dt', function () {
    let i = 1;
    table.column(1, { search: 'applied', order: 'applied' }).nodes().each(function (cell) {
      cell.innerHTML = i++;
    });
  });

  selectAll.addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('.data-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
    toggleDeleteButton();
  });

  document.addEventListener('change', function (e) {
    if (e.target.classList.contains('data-checkbox')) {
      const checkboxes = document.querySelectorAll('.data-checkbox');
      const allChecked = Array.from(checkboxes).every(cb => cb.checked);
      selectAll.checked = allChecked;
      toggleDeleteButton();
    }
  });  
 
  function toggleDeleteButton() {
    const checkboxes = document.querySelectorAll('.data-checkbox');
    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
    btnHapus.disabled = !anyChecked;
  }
});


function previewImg() {
  const foto = document.querySelector('#foto');
  const imgPreview = document.querySelector('#img-preview');

  const fileFoto = new FileReader();
  fileFoto.readAsDataURL(foto.files[0]);

  fileFoto.onload = function(e) {
      imgPreview.src = e.target.result;
      imgPreview.style.display = 'block';
  };
}
 
$(document).on('click', '.btn-delete', function () {
  const form = $(this).closest('form');

  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: 'Data yang dihapus tidak bisa dikembalikan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      form.submit();
    }
  });
  $.fn.dataTable.ext.errMode = 'none'; 
});


