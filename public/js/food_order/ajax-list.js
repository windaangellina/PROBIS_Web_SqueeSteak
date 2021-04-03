/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/js/food_order/ajax-list.js ***!
  \**********************************************/
var tmrAjax = null;

function ajaxListRekapMenu(table, status) {
  var urlJson = status + "/list/json/rekapmenu";
  $.ajax({
    type: "get",
    url: urlJson,
    responsive: true,
    success: function success(response) {
      //clear content
      table.clear();
      var obj = JSON.parse(JSON.stringify(response));
      var countData = obj.data.length;

      if (status == "ongoing") {
        if (countData > 0) {
          obj.data.forEach(function (el) {
            //add row ke datatables
            table.row.add([el.nama, el.jumlah]);
          }); //update display

          table.draw();
        } else {
          var domGambar = "<div class=\"row mt-4 d-flex justify-content-center\">\n                            <div class=\"col-sm-12 col-lg-4 text-center\">\n                                <img src=\"" + urlGambarChef + "\" class=\"img-responsive w-100\" alt=\"\">\n                            </div>\n                        </div>";
          $("#rowPageContent").html(domGambar);
        }
      }
    },
    error: function error(xhr, status, _error) {// alert("Status: " + status);
      //alert("Error: " + error);
      // alert("xhr: " + xhr.readyState);
    },
    statusCode: {
      404: function _() {//alert("page not found");
      }
    }
  });
}

function ajaxListPesananMenu(status, csrf_token) {
  //let urlJson = status + "/list/json/pesanan";
  var urlJson = 'http://127.0.0.1:8000/food-order/' + status + '/list/json/pesanan';
  $.ajax({
    type: "get",
    url: urlJson,
    responsive: true,
    success: function success(response) {
      var dom = "";
      var obj = JSON.parse(JSON.stringify(response));
      obj.data.forEach(function (el) {
        var details = JSON.parse(JSON.stringify(el.detailpesanan));
        dom += "<div class=\"col mb-4\">\n                    <div class=\"card\" style=\"min-height: 15rem;\">\n                        <div class=\"card-header\">\n                            <p class=\"card-title\">\n                                <strong>\n                                    Meja " + el.nomor_meja + ' / ' + el.kode_order + "</strong>\n                            </p>\n                        </div>\n                        <div>\n                            <ul class=\"list-group list-group-flush\">";
        details.forEach(function (detail) {
          var displayValid = true;

          if (status == "ongoing") {
            if (detail.status_diproses != 1) {
              displayValid = false;
            }
          } else if (status == "all") {
            if (detail.status_diproses == 0) {
              displayValid = false;
            }
          }

          if (displayValid) {
            dom += "<li class=\"list-group-item\">\n                                        <div class=\"row\">\n                                            <div class=\"col-sm-5 col-md-6 col-xl-7\">\n                                                " + detail.nama_menu + "\n                                            </div>\n                                            <div class=\"col text-left\">\n                                                x " + detail.jumlah + "\n                                            </div>";

            if (detail.status_diproses == 1) {
              dom += "<div class=\"col text-right\">";

              if (status == "ongoing") {
                dom += "<form method=\"POST\">\n                                                    <input type=\"hidden\" name=\"_token\" value=\"" + csrf_token + "\" />\n                                                        <button type=\"submit\" class=\"btn btn-success\" formaction=\"" + detail.id + "/done\">\n                                                            <i class=\"fas fa-check\"></i>\n                                                        </button>\n                                                    </form>";
              } else if (status == "all") {
                dom += "<button class=\"btn btn-secondary\" disabled>\n                                                        <i class=\"fas fa-spinner\"></i>\n                                                    </button>";
              }
            }

            dom += "</div>";

            if (detail.keterangan != null) {
              dom += "<div class=\"row\">\n                                                <div class=\"col-12\">\n                                                    <p class=\"ml-2 font-italic text-muted\">" + detail.keterangan + "</p>\n                                                </div>\n                                            </div>";
            }

            dom += "</li>";
          }
        });
        dom += "</ul>\n                        </div>"; //form untuk button "sudah selesai semua"

        if (status == "ongoing") {
          dom += "<hr>\n                            <div class=\"text-center mb-3\">\n                                <form method=\"POST\">\n                                <input type=\"hidden\" name=\"_token\" value=\"" + csrf_token + "\" />\n                                    <button type=\"submit\" formaction=\"/customer-order/" + el.id + "/done-all\" class=\"btn btn-primary w-75\">\n                                        Sudah Selesai Semua\n                                    </button>\n                                </form>\n                            </div>";
        }

        dom += "</div>\n                </div>";
      });
      $("#containerCardPesanan").html(dom);
    },
    error: function error(xhr, status, _error2) {// alert("Status: " + status);
      //alert("Error: " + error);
      // alert("xhr: " + xhr.readyState);
    },
    statusCode: {
      404: function _() {//alert("page not found");
      }
    }
  });
}

var table = null;
$(document).ready(function () {
  //tampilkan data
  var pstatus = $('#statusPesanan').val();
  var csrf_token = $('meta[name="csrf-token"]').attr('content');
  table = $("#dataTable").DataTable({
    columnDefs: [{
      className: 'text-right',
      targets: [1]
    }]
  });

  if (pstatus == "ongoing") {
    ajaxListRekapMenu(table, pstatus);
  }

  ajaxListPesananMenu(pstatus, csrf_token); //refresh ajax data setiap 5 detik

  tmrAjax = setInterval(function () {
    if (pstatus == "ongoing") {
      ajaxListRekapMenu(table, pstatus);
    }

    ajaxListPesananMenu(pstatus, csrf_token);
  }, 5 * 1000);
});
/******/ })()
;