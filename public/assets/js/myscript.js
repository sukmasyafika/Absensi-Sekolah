$(document).ready(function() {
  const table = $('#datatabel').DataTable({
    paging: true,
    searching: true,
    info: true,
    lengthChange: true,
    pageLength: 25,
    ordering: false,
    language: {
      zeroRecords: "Data tidak ditemukan"
    },
    columnDefs: [
      { className: "text-center", targets: "_all" } 
    ],
    dom: '<"row mb-3"<"col-12 col-md-6 mb-2"l><"col-12 col-md-6"f>>t<"row mt-3"<"col-sm-6"i><"col-sm-6"p>>'
  });
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

