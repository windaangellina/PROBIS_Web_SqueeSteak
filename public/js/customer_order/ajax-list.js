(()=>{function a(a){var t=a+"/list/json";$.ajax({type:"get",url:t,responsive:!0,success:function(t){var e=$("#dataTable").find("tr")[0].cells.length-1,n=$("#dataTable").DataTable({columnDefs:[{orderable:!1,targets:e},{className:"text-right",targets:[2]},{className:"text-center",targets:[e]}]});n.clear(),JSON.parse(JSON.stringify(t)).data.forEach((function(t){var e='<a class="btn btn-secondary mx-1 my-1 btnDelete"\n                        href="'+t.id+'/detail">\n                        <i class="fas fa-receipt"></i>\n                    </a>';if("done"==a&&(e+=' <button type="button" class="btn btn-success mx-1 my-1 btnAksiModal"\n                            formaction="'+t.id+'/confirm-payment" mode="Konfirmasi" item="pembayaran">\n                            <i class="fas fa-check"></i>\n                        </button>'),"closed"==a){var r=[t.nomor_meja,t.kode_order,t.total,t.created_at,t.updated_at,t.nama_kasir,e];console.log(r),n.row.add(r)}else{var o=[t.nomor_meja,t.kode_order,t.total,t.created_at,e];console.log(o),n.row.add(o)}})),n.draw()},error:function(a,t,e){alert("Status: "+t),alert("Error: "+e),alert("xhr: "+a.readyState)},statusCode:{404:function(){alert("page not found")}}})}$(document).ready((function(){var t;t=$("#statusPesanan").val(),console.log(t),a(t),setInterval((function(){a(t)}),18e4)}))})();