/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/menu/ajax-list.js ***!
  \****************************************/
var tmrAjax = null; // function ajaxListMenuV2(){
//     var table = $("#dataTable").DataTable();
//     table.clear().destroy();
//     var table = $("#dataTable").DataTable({
//         ajax:{
//             url:"/menu/list/json",
//             cache:false
//         },
//         serverSide:true,
//         responsive:true,
//         columnDefs: [
//             // align text right untuk kolom dengan index ke-2 (kolom harga)
//             { className: 'text-right', targets: [2] },
//         ],
//         columns:[
//             { data : 'nama_kategori' },
//             { data : 'nama' },
//             { data: 'harga' },
//             {
//                 data: null,
//                 render: function ( data, type, row ) {
//                     if (data.deleted_at != null) {
//                         return '<span class="text-danger">Tidak</span>';
//                     }
//                     else{
//                         return '<span class="text-success">Iya</span>';
//                     }
//                 }
//             },
//             { data : 'created_at' },
//             { data : 'updated_at' },
//             {
//                 data: null,
//                 orderable: false,
//                 render: function ( data, type, row ) {
//                     var dom =
//                     `<a class="btn btn-secondary mx-1 my-1"
//                         href="/menu/`+ data.id +`/edit") }}">
//                         <i class="fas fa-edit"></i>
//                     </a>`;
//                     if (data.deleted_at == null) {
//                         dom += `<button type="button" class="btn btn-danger mx-1 my-1 btnAksiModal"
//                         formaction="/menu/`+ data.id +`/delete" mode="Hapus" item="menu">
//                             <i class="fas fa-trash"></i>
//                         </button>`;
//                     }
//                     else{
//                         dom +=  `<button type="button" class="btn btn-success mx-1 my-1 btnAksiModal"
//                         formaction="/menu/`+ data.id +`/restore" mode="Restorasi" item="menu">
//                             <i class="fas fa-trash-restore"></i>
//                         </button>`;
//                     }
//                     return dom;
//                 }
//             },
//         ]
//     });
// }

function ajaxListMenu(table) {
  $.ajax({
    type: "get",
    url: "/menu/list/json",
    responsive: true,
    success: function success(response) {
      //clear content
      table.clear();
      var obj = JSON.parse(JSON.stringify(response));
      obj.data.forEach(function (el) {
        // dom untuk button aksi
        var domAksi = "<a class=\"btn btn-secondary mx-1 my-1\"\n                        href=\"/menu/" + el.id + "/edit\") }}\">\n                        <i class=\"fas fa-edit\"></i>\n                    </a>";

        if (el.deleted_at == null) {
          domAksi += "<button type=\"button\" class=\"btn btn-danger mx-1 my-1 btnAksiModal\"\n                        formaction=\"/menu/" + el.id + "/delete\" mode=\"Hapus\" item=\"menu\">\n                            <i class=\"fas fa-trash\"></i>\n                        </button>";
        } else {
          domAksi += "<button type=\"button\" class=\"btn btn-success mx-1 my-1 btnAksiModal\"\n                        formaction=\"/menu/" + el.id + "/restore\" mode=\"Restorasi\" item=\"menu\">\n                            <i class=\"fas fa-trash-restore\"></i>\n                        </button>";
        } //dom untuk status ditampilkan


        var domStatus = "";

        if (el.deleted_at != null) {
          domStatus = '<span class="text-danger">Tidak</span>';
        } else {
          domStatus = '<span class="text-success">Iya</span>';
        } //add row ke datatables


        table.row.add([el.nama_kategori, el.nama, el.harga, domStatus, el.created_at, el.updated_at, domAksi]);
      }); //update display

      table.draw();
    },
    error: function error(xhr, status, _error) {
      alert("Status: " + status);
      alert("Error: " + _error);
      alert("xhr: " + xhr.readyState);
    },
    statusCode: {
      404: function _() {
        alert("page not found");
      }
    }
  });
}

$(document).ready(function () {
  var table = $("#dataTable").DataTable({
    columnDefs: [{
      orderable: false,
      targets: 6
    }, {
      className: 'text-right',
      targets: [2]
    }, {
      className: 'text-center',
      targets: [6]
    }]
  }); //tampilkan data

  ajaxListMenu(table); //refresh ajax data setiap 3 menit

  tmrAjax = setInterval(function () {
    ajaxListMenu(table);
  }, 3 * 60 * 1000);
});
/******/ })()
;