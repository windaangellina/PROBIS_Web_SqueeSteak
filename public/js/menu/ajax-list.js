(()=>{function t(t){$.ajax({type:"get",url:"/menu/list/json",responsive:!0,success:function(a){t.clear(),JSON.parse(JSON.stringify(a)).data.forEach((function(a){var e='<a class="btn btn-secondary mx-1 my-1"\n                        href="/menu/'+a.id+'/edit") }}">\n                        <i class="fas fa-edit"></i>\n                    </a>';null==a.deleted_at?e+='<button type="button" class="btn btn-danger mx-1 my-1 btnAksiModal"\n                        formaction="/menu/'+a.id+'/delete" mode="Hapus" item="menu">\n                            <i class="fas fa-trash"></i>\n                        </button>':e+='<button type="button" class="btn btn-success mx-1 my-1 btnAksiModal"\n                        formaction="/menu/'+a.id+'/restore" mode="Restorasi" item="menu">\n                            <i class="fas fa-trash-restore"></i>\n                        </button>';var n="";n=null!=a.deleted_at?'<span class="text-danger">Tidak</span>':'<span class="text-success">Iya</span>';var s='<img id="fotoMenu" class="img-responsive w-100 mx-auto" style="max-width: 80px; max-height: 80px; object-fit:cover;" src="'+a.url_foto+'") }}">';t.row.add([a.nama_kategori,s,a.nama,a.harga,n,a.created_at,a.updated_at,e])})),t.draw()},error:function(t,a,e){console.log("Status: "+a),console.log("Error: "+e),console.log("xhr: "+t.readyState)},statusCode:{404:function(){alert("page not found")}}})}$(document).ready((function(){var a=$("#dataTable").DataTable({columnDefs:[{orderable:!1,targets:7},{className:"text-right",targets:[3]},{className:"text-center",targets:[1,6,7]},{visible:!1,targets:[0,4,5,6]}]});$("a.toggle-vis").on("click",(function(t){t.preventDefault();var e=a.column($(this).attr("data-column"));e.visible(!e.visible())})),t(a),setInterval((function(){t(a)}),1799982e4)}))})();