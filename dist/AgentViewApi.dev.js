"use strict";

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var AgentViewApi =
/*#__PURE__*/
function () {
  function AgentViewApi() {
    _classCallCheck(this, AgentViewApi);
  }

  _createClass(AgentViewApi, [{
    key: "getAgentProperties",
    value: function getAgentProperties() {
      fetch("AgentView.php?action=getAgentProperties&agentId=".concat(window.userID)).then(function (response) {
        return response.json();
      }).then(function (properties) {
        console.log(properties);
        var propertiesList = document.getElementById('propertyList');
        propertiesList.innerHTML = '';
        properties.forEach(function (property) {
          var row = document.createElement('tr');
          row.innerHTML = "\n                    <td>".concat(property.name, "</td>\n                    <td>seller</td>\n                    <td>").concat(property.price, "</td>\n                    <td>\n                        <button onclick=\"viewProperty(").concat(property.id, ")\">View</button>\n                        <button onclick=\"editProperty(").concat(property.id, ")\">Edit</button>\n                        <button onclick=\"deleteProperty(").concat(property.id, ")\">Delete</button>\n                    </td>\n                ");
          propertiesList.appendChild(row);
        });
      })["catch"](function (error) {
        return console.error('Error fetching properties:', error);
      });
    }
  }]);

  return AgentViewApi;
}();

var agentViewApi = new AgentViewApi();

function initialize() {
  agentViewApi.getAgentProperties();
  document.getElementById('searchProperty').addEventListener('input', agentViewApi.searchEngineProperty);
}

window.onload = initialize();