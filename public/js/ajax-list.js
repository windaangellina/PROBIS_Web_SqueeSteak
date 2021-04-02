/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/menu/ajax-list.js ***!
  \****************************************/
function ajaxListMenu() {
  $.ajax({
    type: "get",
    url: "/menu/list/json",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(response) {
      console.log(response);
      var dom = "";
      response.data.forEach(function (el) {
        dom += "<tr>\n                        <td>" + el.nama_kategori + "</td>\n                        <td>" + el.nama + "</td>\n                        <td class=\"text-right\">" + el.harga + "</td>\n                        <td>";

        if (el.deleted_at != null) {
          dom += '<span class="text-danger">Tidak</span>';
        } else {
          dom += '<span class="text-success">Iya</span>';
        }

        dom += "</td>\n                        <td>" + el.created_at + "</td>\n                        <td>";

        if (el.deleted_at != null) {
          dom += el.deleted_at;
        } else {
          dom += el.updated_at;
        }

        dom += '</td>';
        dom += "<td class=\"text-center align-middle\">\n                            <a class=\"btn btn-secondary mx-1 my-1\"\n                                href=\"{{ url(\"/menu/\" . " + el.id + " . \"/edit\") }}\">\n                                <i class=\"fas fa-edit\"></i>\n                            </a>\n                            <form>";

        if (el.deleted_at == null) {
          dom += "<button type=\"button\" class=\"btn btn-danger mx-1 my-1 btnAksiModal\"\n                                    formaction=\"/menu/" + el.id + "/delete\" mode=\"Hapus\" item=\"menu\">\n                                        <i class=\"fas fa-trash\"></i>\n                                    </button>";
        } else {
          dom += "<button type=\"button\" class=\"btn btn-success mx-1 my-1 btnAksiModal\"\n                                    formaction=\"/menu/" + el.id + "/restore\" mode=\"Restorasi\" item=\"menu\">\n                                        <i class=\"fas fa-trash-restore\"></i>\n                                    </button>";
        }

        dom += "</form>\n                        </td>\n                    </tr>";
      });
      $("#dataTable tbody").html(dom);
    },
    error: function error(xhr, status, _error) {//    alert("Status: " + status);
      //    alert("Error: " + error);
      //    alert("xhr: " + xhr.readyState);
    },
    statusCode: {
      404: function _() {
        alert("page not found");
      }
    }
  });
}

var tmrAjax = null;
$(function () {
  ajaxListMenu();
});
/******/ })()
;