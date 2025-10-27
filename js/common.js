async function ready(fn) {
  if (document.readyState !== "loading") {
    await fn();
    return;
  }
  document.addEventListener("DOMContentLoaded", fn);
}

var loader = new Loader("Loader");

function easternToLocal(easternDateString) {
  const eastern = "America/New_York";
  const localTZ = Intl.DateTimeFormat().resolvedOptions().timeZone;

  // Interpret as Eastern Time
  const easternDate = new Date(
    new Date(easternDateString).toLocaleString("en-US", {
      timeZone: eastern,
    })
  );

  // Convert to local time
  return new Date(
    easternDate.toLocaleString("en-US", {
      timeZone: localTZ,
    })
  );
}

function convertDateFields() {
  var datesToConvert = document.querySelectorAll("[data-dateformatter]");

  datesToConvert.forEach(function (el) {
    var odate = el.textContent;
    el.textContent = easternToLocal(odate).toLocaleString("en-US");
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
