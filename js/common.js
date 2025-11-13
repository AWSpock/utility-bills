async function ready(fn) {
  if (document.readyState !== "loading") {
    await fn();
    return;
  }
  document.addEventListener("DOMContentLoaded", fn);
}

var loader = new Loader("Loader");

function convertDateFields() {
  var datesToConvert = document.querySelectorAll("[data-dateformatter]");

  datesToConvert.forEach(function (el) {
    var odate = el.textContent;
    el.textContent = new Date(odate + " UTC").toLocaleString("en-US");
    el.removeAttribute("data-dateformatter");
  });
}
ready(convertDateFields);

function moneyFormat(amount) {
  return new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
  }).format(amount);
}

//

var currentUrl = window.location.pathname;
var address_id = -1;
var bill_type_id = -1;
var bill_id = -1;
if (currentUrl.split("/")[2]) address_id = currentUrl.split("/")[2];
if (currentUrl.split("/")[4]) bill_type_id = currentUrl.split("/")[4];
if (currentUrl.split("/")[6]) bill_id = currentUrl.split("/")[6];
