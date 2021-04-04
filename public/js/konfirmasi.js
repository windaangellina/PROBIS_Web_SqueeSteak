/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./resources/js/konfirmasi.js ***!
  \************************************/
// node js / laravel mix. keterangan baca di CATATAN.txt
function setModalMode(mode, action, item) {
  if (mode == "Hapus") {
    $("#btnAction").addClass('btn-danger');
  } else {
    $("#btnAction").addClass('btn-success');
  }

  $("#modalTitle").html(mode + ' ' + item);
  $("#btnAction").html(mode);
  $("#modalBody").html('Yakin ingin ' + mode + " " + item + ' ?');
  $("#btnAction").attr('formaction', action);
  $("#modalConfirmation").modal('show');
}

function refreshAjaxDataTables() {
  //refresh ajax di datatables
  var table = $("#dataTable").DataTable();
  table.ajax.reload();
}

$(document).on('click', ".btnAksiModal", function () {
  // console.log(this);
  var action = $(this).attr('formaction');
  var mode = $(this).attr("mode");
  var item = $(this).attr("item");
  setModalMode(mode, action, item);
});
/******/ })()
;