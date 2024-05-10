"use strict";

var xhttp = new XMLHttpRequest();

xhttp.onreadystatechange = function () {
  if (this.readyState == 4 && this.status == 200) {
    // Attempt to set the innerHTML property of an element
    var element = document.getElementById("yourElementId");

    if (element !== null) {
      element.innerHTML = this.responseText;
    } else {
      console.error("Element with ID 'yourElementId' not found.");
    }
  }
};

xhttp.open("GET", "yourPage.php", true);
xhttp.send();