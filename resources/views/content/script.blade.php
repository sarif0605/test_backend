<script type="text/javascript">
    $(document).ready(function () {
     var table = $("#table-content").DataTable({
         processing: true,
         serverSide: false,
         ajax: {
             url: "{{ route('content') }}",
             type: "GET",
             dataType: "json",
             headers: {
                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
             },
         },
         dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-5"i><"col-sm-7"p>>',
        language: {
            lengthMenu: "Show _MENU_ entries",
            search: "Search:",
            searchPlaceholder: "Search data..."
        },
         columns: [
             {
                 data: null,
                 render: (data, type, row, meta) => {
                     return meta.row + 1;
                 },
             },
             {
                 data: "title",
                 render: function (data, type, row) {
                     return data ? data : "N/A";
                 }
             },
             {
                 data: "content",
                 render: function (data, type, row) {
                     return data ? data : "pemilik";
                 }
             },
             {
                 data: "user.name",
                 render: function (data, type, row) {
                     return data ? data : "pemilik";
                 }
             },
             {
                 data: "image_url",
                 render: function (data, type, row) {
                     if (data && data.length > 0) {
                         const imageUrl = `${data}`;
                         return `<img class="img-profile rounded-circle"
                                 src="${imageUrl}"
                                 alt="Content Image"
                                 style="width:50px;height:50px;">`;
                     }
                     return 'No image';
                 }
             },
             {
                 data: null,
                 orderable: false,
                 searchable: false,
                 render: function (data) {
                    return `
                        <div class="d-flex gap-2 justify-content-start">
                            <a href="/content/show/${data.id}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="/content/edit/${data.id}" class="btn btn-sm btn-warning">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${data.id}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>`;
                },
             },
         ],
     });

     // Delete action (for the delete button functionality)
     $("#table-content").on("click", ".delete-btn", function () {
        const contentId = $(this).data("id");
        const button = $(this);

        deleteContent(contentId, button);
    });
 });

 function deleteContent(contentId, deleteButton) {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: `Anda yakin menghapus data ini?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            // Tambahkan loading overlay
            $("#loading").show();

            // Nonaktifkan tombol & ganti teksnya jadi loading
            deleteButton.prop("disabled", true);
            deleteButton.html("<i class='fas fa-spinner fa-spin'></i> Deleting...");

            $.ajax({
                url: `/content/destroy/${contentId}`,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function () {
                    Swal.fire({
                        icon: "success",
                        title: "Deleted!",
                        text: `Data content berhasil dihapus.`,
                        timer: 2000,
                    });

                    $("#table-content").DataTable().ajax.reload();
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Gagal menghapus data. Silakan coba lagi.",
                    });
                },
                complete: function () {
                    // Sembunyikan loading overlay setelah request selesai
                    $("#loading").hide();

                    // Kembalikan tombol delete ke kondisi semula
                    deleteButton.prop("disabled", false);
                    deleteButton.html('<i class="fas fa-trash-alt"></i>');
                }
            });
        }
    });
}
 </script>
