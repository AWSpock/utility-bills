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

var datesToConvert = document.querySelectorAll("[data-dateformatter]");

datesToConvert.forEach(function (el) {
  var odate = el.textContent;
  el.textContent = easternToLocal(odate).toLocaleString("en-US");
});
