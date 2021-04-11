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

                    //add row ke datatables
                    table.row.add([
                        el.nama_kategori,
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
            { orderable: false, targets: 6 },
            { className:'text-right', targets: [2] },
            { className:'text-center', targets: [6] },
        ]
    });

    //tampilkan data
    ajaxListMenu(table);

    //refresh ajax data setiap 3 menit
    tmrAjax = setInterval(() => {
        ajaxListMenu(table);
    }, 3 * 60 * 1000 * 99999);
});
