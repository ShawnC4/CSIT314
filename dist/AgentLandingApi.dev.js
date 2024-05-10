"use strict";

function loadContent(page) {
  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Attempt to set the innerHTML property of an element
      var element = document.querySelector(".body"); // Change to the appropriate selector

      if (element !== null) {
        element.innerHTML = this.responseText;
      } else {
        console.error("Element not found.");
      }
    }
  };

  xhttp.open("GET", page, true);
  xhttp.send();
}