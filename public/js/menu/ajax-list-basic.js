(()=>{function t(){$.ajax({type:"get",url:"/menu/list/json",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){var a="";t.data.forEach((function(t){a+="<tr>\n                        <td>"+t.nama_kategori+"</td>\n                        <td>"+t.nama+'</td>\n                        <td class="text-right">'+t.harga+"</td>\n                        <td>",null!=t.deleted_at?a+='<span class="text-danger">Tidak</span>':a+='<span class="text-success">Iya</span>',a+="</td>\n                        <td>"+t.created_at+"</td>\n                        <td>",null!=t.deleted_at?a+=t.deleted_at:a+=t.updated_at,a+="</td>",a+='<td class="text-center align-middle">\n                            <a class="btn btn-secondary mx-1 my-1"\n                                href="{{ url("/menu/" . '+t.id+' . "/edit") }}">\n                                <i class="fas fa-edit"></i>\n                            </a>\n                            <form>',null==t.deleted_at?a+='<button type="button" class="btn btn-danger mx-1 my-1 btnAksiModal"\n                                    formaction="/menu/'+t.id+'/delete" mode="Hapus" item="menu">\n                                        <i class="fas fa-trash"></i>\n                                    </button>':a+='<button type="button" class="btn btn-success mx-1 my-1 btnAksiModal"\n                                    formaction="/menu/'+t.id+'/restore" mode="Restorasi" item="menu">\n                                        <i class="fas fa-trash-restore"></i>\n                                    </button>',a+="</form>\n                        </td>\n                    </tr>"})),$("#dataTable tbody").html(a)},error:function(t,a,n){alert("Status: "+a),alert("Error: "+n),alert("xhr: "+t.readyState)},statusCode:{404:function(){alert("page not found")}}})}$((function(){$("#dataTable").dataTable(),t(),setInterval((function(){t()}),12e4)}))})();