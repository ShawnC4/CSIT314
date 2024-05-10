"use strict";

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var BuyerApi =
/*#__PURE__*/
function () {
  function BuyerApi() {
    _classCallCheck(this, BuyerApi);
  }

  _createClass(BuyerApi, [{
    key: "getNumberOfPages",
    value: function getNumberOfPages() {
      fetch('BuyerLanding.php?action=getNumberOfPages').then(function (response) {
        return response.json();
      }).then(function (numberOfPages) {
        var pageSelect = document.getElementById('pageSelect');
        pageSelect.innerHTML = '';

        for (var i = 1; i <= numberOfPages; i++) {
          var option = document.createElement('option');
          option.value = i;
          option.textContent = i;
          pageSelect.appendChild(option);
        }
      });
    }
  }, {
    key: "getNumberOfPagesForShortlist",
    value: function getNumberOfPagesForShortlist() {
      fetch('BuyerLanding.php?action=getNumberOfPagesForShortlist').then(function (response) {
        return response.json();
      }).then(function (numberOfPages) {
        var pageSelect = document.getElementById('pageSelect');
        pageSelect.innerHTML = '';

        for (var i = 1; i <= numberOfPages; i++) {
          var option = document.createElement('option');
          option.value = i;
          option.textContent = i;
          pageSelect.appendChild(option);
        }
      });
    }
  }, {
    key: "getDashboard",
    value: function getDashboard(pageNumber) {
      var _this = this;

      fetch("BuyerLanding.php?action=getDashboard&page=".concat(pageNumber)).then(function (response) {
        return response.json();
      }).then(function (propertyObjects) {
        console.log(propertyObjects);
        var propertyList = document.querySelector('.property-listings');
        propertyList.innerHTML = '';
        propertyObjects.forEach(function (property) {
          // Create div for property image, name and status
          var propertyDiv = document.createElement('div');
          propertyDiv.classList.add('property'); // Create image element

          var img = document.createElement('img');
          img.src = property.image; // Assuming property.image is the image URL

          img.alt = property.id; // Append elements to container

          propertyDiv.appendChild(img);
          var propertyDetailsDiv = document.createElement('div');
          propertyDetailsDiv.classList.add('property-details'); // Create h2 element for property name

          var propertyName = document.createElement('h2');
          propertyName.textContent = property.name; // Append elements to propertyDiv

          propertyDetailsDiv.appendChild(propertyName); // View button

          var viewButton = document.createElement('button');
          viewButton.textContent = 'View';
          viewButton.addEventListener('click', function () {
            _this.displayProperty(property.id);
          });
          propertyDetailsDiv.appendChild(viewButton); // ShortList button

          var shortListButton = document.createElement('button');
          shortListButton.textContent = 'Add To ShortList';
          shortListButton.addEventListener('click', function () {
            _this.shortListProperty(property.id);
          });
          propertyDetailsDiv.appendChild(shortListButton); // Create button for Give Rating

          var ratingButton = document.createElement('button');
          ratingButton.textContent = 'Give Rating';
          ratingButton.addEventListener('click', function () {
            _this.displayRating(property.id);
          }); // Create button for Give Review

          var reviewButton = document.createElement('button');
          reviewButton.textContent = 'Give Review';
          reviewButton.addEventListener('click', function () {
            _this.displayReview(property.id);
          }); // Append Give Rating and Give Review buttons to container

          propertyDetailsDiv.appendChild(ratingButton);
          propertyDetailsDiv.appendChild(reviewButton);
          propertyDiv.appendChild(propertyDetailsDiv); // Append property container to listings

          propertyList.appendChild(propertyDiv);
        });
      });
    }
  }]);

  return BuyerApi;
}();

var BuyerApiInstance = new BuyerApi();

function initializeView() {
  BuyerApiInstance.getDashboard(1);
  BuyerApiInstance.getNumberOfPages();
  document.getElementById('pageSelect').addEventListener('change', function () {
    var pageNumber = this.value;
    BuyerApiInstance.getDashboard(pageNumber);
  });
}

window.onload = function () {
  loadContent('BuyerView.php');
};

function loadContent(page) {
  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Attempt to set the innerHTML property of an element
      var element = document.querySelector("#body"); // Change to the appropriate selector

      if (element !== null) {
        element.innerHTML = this.responseText;

        if (page === 'BuyerView.php') {
          initializeView();
        }
      } else {
        console.error("Element not found.");
      }
    }
  };

  xhttp.open("GET", page, true);
  xhttp.send();
}

function loadShortlist() {
  loadContent('BuyerShortlist.php');
}

function initializeShortlist() {
  BuyerApiInstance.getDashboard(1);
  BuyerApiInstance.getNumberOfPages();
  document.getElementById('pageSelect').addEventListener('change', function () {
    var pageNumber = this.value;
    BuyerApiInstance.getDashboard(pageNumber);
  });
}