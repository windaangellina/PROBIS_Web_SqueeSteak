let tmrAjax = null;

function ajaxListRekapMenu(table, status){
    let urlJson = status + "/list/json/rekapmenu";

    $.ajax({
        type:"get",
        url:urlJson,
        responsive:true,
        success:
            function (response) {
                //clear content
                table.clear();

                let obj = JSON.parse(JSON.stringify(response));
                let countData = obj.data.length;

                if (status == "ongoing") {
                    if (countData > 0) {
                        obj.data.forEach(el => {
                            //add row ke datatables
                            table.row.add([
                                el.nama,
                                el.jumlah
                            ]);
                        });

                        //update display
                        table.draw();
                    }
                    else{
                        let domGambar =
                        `<div class="row mt-4 d-flex justify-content-center">
                            <div class="col-sm-12 col-lg-4 text-center">
                                <img src="`+ urlGambarChef +`" class="img-responsive w-100" alt="">
                            </div>
                        </div>`;
                        $("#rowPageContent").html(domGambar);
                    }
                }

            },
        error: function (xhr,status,error) {
            console.log("Status: " + status);
            console.log("Error: " + error);
            console.log("xhr: " + xhr.readyState);
        },
        statusCode: {
            404: function() {
                //alert("page not found");
            }
        }
    });
}

function ajaxListPesananMenu(status, csrf_token){
    //let urlJson = status + "/list/json/pesanan";
    let urlJson = 'http://127.0.0.1:8000/food-order/' + status + '/list/json/pesanan';
    $.ajax({
        type:"get",
        url:urlJson,
        responsive:true,
        success:
            function (response) {
                let dom = "";

                let obj = JSON.parse(JSON.stringify(response));
                obj.data.forEach(el => {
                    let details = JSON.parse(JSON.stringify(el.detailpesanan));

                    dom += `<div class="col mb-4">
                    <div class="card" style="min-height: 15rem;">
                        <div class="card-header">
                            <p class="card-title">
                                <strong>
                                    Meja ` + el.nomor_meja + ' / ' + el.kode_order +
                                `</strong>
                            </p>
                        </div>
                        <div>
                            <ul class="list-group list-group-flush">`;
                                details.forEach(detail => {
                                    let displayValid = true;
                                    if (status == "ongoing") {
                                        if (detail.status_diproses != 1) {
                                            displayValid = false;
                                        }
                                    }
                                    else if (status == "all") {
                                        if (detail.status_diproses == 0) {
                                            displayValid = false;
                                        }
                                    }

                                    if(displayValid){
                                    dom +=
                                    `<li class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-5 col-md-6 col-xl-7">
                                                `+ detail.nama_menu +`
                                            </div>
                                            <div class="col text-left">
                                                x `+ detail.jumlah +`
                                            </div>`;

                                            if (detail.status_diproses == 1) {
                                                dom += `<div class="col text-right">`;
                                                if (status == "ongoing") {
                                                    dom +=
                                                    `<form method="POST">
                                                    <input type="hidden" name="_token" value="`+
                                                    csrf_token +`" />
                                                        <button type="submit" class="btn btn-success btnTextResponsive" formaction="`+ detail.id +`/done">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>`;
                                                }
                                                else if (status == "all") {
                                                    dom +=
                                                    `<button class="btn btn-secondary btnTextResponsive" disabled>
                                                        <i class="fas fa-clock"></i>
                                                    </button>`;
                                                }
                                                dom +='</div>';
                                            }
                                        dom +='</div>';
                                        if (detail.keterangan != null) {
                                            dom +=
                                            `<div class="row">
                                                <div class="col-12">
                                                    <p class="ml-2 font-italic text-muted">`+ detail.keterangan +`</p>
                                                </div>
                                            </div>`;
                                        }
                                        dom += `</li>`;
                                    }
                                });
                            dom += `</ul>
                        </div>`;

                        //form untuk button "sudah selesai semua"
                        if (status == "ongoing") {
                            dom += `<hr>
                            <div class="text-center mb-3">
                                <form method="POST">
                                <input type="hidden" name="_token" value="`+ csrf_token +`" />
                                    <button type="submit" formaction="/customer-order/` + el.id + `/done-all" class="btn btn-primary w-75 btnTextResponsive">
                                        Sudah Selesai Semua
                                    </button>
                                </form>
                            </div>`;
                        }

                    dom +=
                    `</div>
                </div>`;
                });

                $("#containerCardPesanan").html(dom);
            },
        error: function (xhr,status,error) {
            console.log("Status: " + status);
            console.log("Error: " + error);
            console.log("xhr: " + xhr.readyState);
        },
        statusCode: {
            404: function() {
                //alert("page not found");
            }
        }
    });
}

var table = null;

$(document).ready(function() {
    //tampilkan data
    let pstatus = $('#statusPesanan').val();
    let csrf_token = $('meta[name="csrf-token"]').attr('content');


    table = $("#dataTable").DataTable({
        columnDefs: [
            { className:'text-right', targets: [1] },
        ]
    });

    if (pstatus == "ongoing") {
        ajaxListRekapMenu(table, pstatus);
    }
    ajaxListPesananMenu(pstatus, csrf_token);

    //refresh ajax data setiap 5 detik
    tmrAjax = setInterval(() => {
        if (pstatus == "ongoing") {
            ajaxListRekapMenu(table, pstatus);
        }
        ajaxListPesananMenu(pstatus, csrf_token);
    }, 5 * 1000);
});
