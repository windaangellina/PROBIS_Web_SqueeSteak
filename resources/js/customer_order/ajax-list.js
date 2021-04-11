var tmrAjax = null;

function ajaxListCustomerOrder(table, status){
    var urlJson = status + "/list/json";
    $.ajax({
        type:"get",
        url:urlJson,
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
                        href="`+ el.id +`/detail">
                        <i class="fas fa-receipt"></i>
                    </a>`;
                    if (status == "done") {
                        domAksi += `<button type="button" class="btn btn-success mx-1 my-1 btnAksiModal"
                            formaction="` + el.id + `/confirm-payment" mode="Konfirmasi" item="pembayaran">
                            <i class="fas fa-check"></i>
                        </button>`;
                    }

                    //dom untuk status ditampilkan
                    if (status == "closed") {
                        let rowColumn = [
                            el.nomor_meja,
                            el.kode_order,
                            el.total,
                            el.created_at,
                            el.updated_at,
                            el.nama_kasir,
                            domAksi
                        ];

                        //add row ke datatables
                        console.log(rowColumn);
                        table.row.add(rowColumn);
                    }
                    else{
                        let rowColumn = [
                            el.nomor_meja,
                            el.kode_order,
                            el.total,
                            el.created_at,
                            domAksi
                        ];

                        //add row ke datatables
                        table.row.add(rowColumn);
                    }


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

            }
        }
    });
}

function callAjax(){
    //tampilkan data
    var pstatus = $('#statusPesanan').val();
    console.log(pstatus);

    var indexLastColumn = $("#dataTable").find('tr')[0].cells.length-1;
    var table = $("#dataTable").DataTable({
        columnDefs: [
            { orderable: false, targets: indexLastColumn },
            { className:'text-right', targets: [2] },
            { className:'text-center', targets: [0,indexLastColumn] },
        ]
    });

    ajaxListCustomerOrder(table, pstatus);

    //refresh ajax data setiap 3 menit
    tmrAjax = setInterval(() => {
        ajaxListCustomerOrder(table, pstatus)
    }, 3 * 60 * 1000);
}

$(document).ready(function () {
    callAjax();
});


