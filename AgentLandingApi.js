function loadContent(page) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Attempt to set the innerHTML property of an element
            var element = document.querySelector(".body"); // Change to the appropriate selector
            if (element !== null) {
                element.innerHTML = this.responseText;
                
                if (page === 'AgentView.php' && typeof AgentViewApi === 'undefined') {
                    var script = document.createElement('script');
                    script.src = 'AgentViewApi.js';
                    script.type = 'text/javascript';
                    document.body.appendChild(script);
                }
            } else {
                console.error("Element not found.");
            }
        }
    };
    xhttp.open("GET", page, true);
    xhttp.send();
}
