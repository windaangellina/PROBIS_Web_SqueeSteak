function ajaxListMenu(){
    $.ajax({
        type:"get",
        url: "/menu/list/json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:
            function (response) {
                var dom = "";

                response.data.forEach(el => {
                    dom +=
                    `<tr>
                        <td>`+ el.nama_kategori +`</td>
                        <td>`+ el.nama +`</td>
                        <td class="text-right">`+ el.harga + `</td>
                        <td>`;
                            if (el.deleted_at != null) {
                                dom += '<span class="text-danger">Tidak</span>';
                            }
                            else{
                                dom += '<span class="text-success">Iya</span>';
                            }
                    dom += `</td>
                        <td>`+ el.created_at +`</td>
                        <td>`;
                        if (el.deleted_at != null) {
                            dom += el.deleted_at;
                        }
                        else{
                            dom += el.updated_at;
                        }
                    dom += '</td>';
                    dom +=
                        `<td class="text-center align-middle">
                            <a class="btn btn-secondary mx-1 my-1"
                                href="{{ url("/menu/" . `+ el.id +` . "/edit") }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form>`;
                                if (el.deleted_at == null) {
                                    dom +=
                                    `<button type="button" class="btn btn-danger mx-1 my-1 btnAksiModal"
                                    formaction="/menu/`+ el.id +`/delete" mode="Hapus" item="menu">
                                        <i class="fas fa-trash"></i>
                                    </button>`;
                                }
                                else{
                                    dom +=
                                    `<button type="button" class="btn btn-success mx-1 my-1 btnAksiModal"
                                    formaction="/menu/`+ el.id +`/restore" mode="Restorasi" item="menu">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>`;
                                }
                    dom += `</form>
                        </td>
                    </tr>`;
                });
                $("#dataTable tbody").html(dom);
            },
            error: function (xhr,status,error) {
               alert("Status: " + status);
               alert("Error: " + error);
               alert("xhr: " + xhr.readyState);
            },
            statusCode: {
               404: function() {
                   alert("page not found");
               }
            }
    });
}

var tmrAjax = null;
$(function() {
    $("#dataTable").dataTable();
    ajaxListMenu();

    //refresh ajax data setiap 2 menit
    tmrAjax = setInterval(() => {
        ajaxListMenu();
    }, 2 * 60 * 1000);
});

