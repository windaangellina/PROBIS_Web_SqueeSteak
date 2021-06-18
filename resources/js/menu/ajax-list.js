var tmrAjax = null;

function ajaxListMenu(table){
    $.ajax({
        type:"get",
        url:"/menu/list/json",
        responsive:true,
        success:
            function (response) {
                //clear content
                table.clear();

                var obj = JSON.parse(JSON.stringify(response));
                obj.data.forEach(el => {
                    // dom untuk button aksi
                    var domAksi =
                    `<a class="btn btn-secondary mx-1 my-1"
                        href="/menu/`+ el.id +`/edit") }}">
                        <i class="fas fa-edit"></i>
                    </a>`;
                    if (el.deleted_at == null) {
                        domAksi += `<button type="button" class="btn btn-danger mx-1 my-1 btnAksiModal"
                        formaction="/menu/`+ el.id +`/delete" mode="Hapus" item="menu">
                            <i class="fas fa-trash"></i>
                        </button>`;
                    }
                    else{
                        domAksi +=  `<button type="button" class="btn btn-success mx-1 my-1 btnAksiModal"
                        formaction="/menu/`+ el.id +`/restore" mode="Restorasi" item="menu">
                            <i class="fas fa-trash-restore"></i>
                        </button>`;
                    }

                    //dom untuk status ditampilkan
                    var domStatus = "";
                    if (el.deleted_at != null) {
                        domStatus = '<span class="text-danger">Tidak</span>';
                    }
                    else{
                        domStatus = '<span class="text-success">Iya</span>';
                    }

                    var domFoto = '<img id="fotoMenu" class="img-responsive w-100 mx-auto" style="max-width: 80px; max-height: 80px; object-fit:cover;" src="' + el.url_foto + '") }}">';

                    //add row ke datatables
                    table.row.add([
                        el.nama_kategori,
                        domFoto,
                        el.nama,
                        el.harga,
                        domStatus,
                        el.created_at,
                        el.updated_at,
                        domAksi
                    ]);
                });

                //update display
                table.draw();
            },
        error: function (xhr,status,error) {
            console.log("Status: " + status);
            console.log("Error: " + error);
            console.log("xhr: " + xhr.readyState);
        },
        statusCode: {
            404: function() {
                alert("page not found");
            }
        }
    });
}

$(document).ready(function() {
    var table = $("#dataTable").DataTable({
        columnDefs: [
            { orderable: false, targets: 7 },
            { className:'text-right', targets: [3] },
            { className:'text-center', targets: [1, 6, 7] },
            { visible:false, targets: [0, 4, 5, 6]}
        ]
    });

    // toggle column visibility
    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column( $(this).attr('data-column') );

        // Toggle the visibility
        column.visible( ! column.visible() );
    } );

    //tampilkan data
    ajaxListMenu(table);

    //refresh ajax data setiap 3 menit
    tmrAjax = setInterval(() => {
        ajaxListMenu(table);
    }, 3 * 60 * 1000 * 99999);
});
