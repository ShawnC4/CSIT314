function getDashboard() {
    fetch('SellerLanding.php?action=getDashboard')
        .then(response => response.json())
        .then(propertyObjects => {
            propertyObjects.forEach(property => {
                // Create image element
                var img = document.createElement('img');
                img.src = property.image; // Assuming property.image is the image URL
                // Set image properties

                // Create div for property name and status
                var propertyDiv = document.createElement('div');
                propertyDiv.innerHTML = `<h2>${property.name}</h2><div class="status">${property.status}</div>`;

                // Create button for View
                var viewButton = document.createElement('button');
                viewButton.textContent = 'View';
                viewButton.addEventListener('click', () => {
                    viewProperty(property.id);
                });

                // Append elements to container
                propertyDiv.appendChild(img);
                propertyDiv.appendChild(viewButton);

                // Check if property status is 'sold'
                if (property.status === 'sold') {
                    // Create button for Give Rating
                    var ratingButton = document.createElement('button');
                    ratingButton.textContent = 'Give Rating';
                    ratingButton.addEventListener('click', () => {
                        giveRating(property.id);
                    });

                    // Create button for Give Review
                    var reviewButton = document.createElement('button');
                    reviewButton.textContent = 'Give Review';
                    reviewButton.addEventListener('click', () => {
                        giveReview(property.id);
                    });

                    // Append Give Rating and Give Review buttons to container
                    propertyDiv.appendChild(ratingButton);
                    propertyDiv.appendChild(reviewButton);
                }

                // Append property container to listings
                document.querySelector('.property-listings').appendChild(propertyDiv);
            });
        });
}

function viewProperty(id) {
    fetch(`SellerLanding.php?action=getPropertyDetails&propertyId=${id}`)
        .then(response => response.json())
        .then(propertyDetails => {
            // Assuming you have a modal for property details
            document.getElementById('propertyModal').style.display = 'block';
            document.getElementById('propertyDetails').innerHTML = `
                <p>Property ID: ${propertyDetails.id}</p>
                <p>Name: ${propertyDetails.name}</p>
                <p>Type: ${propertyDetails.type}</p>
                <p>Size: ${propertyDetails.size}</p>
                <!-- Add more property details as needed -->
            `;
            document.getElementById('propertyImage').src = propertyDetails.image; // Assuming propertyDetails.image is the image URL
        })
        .catch(error => {
            console.error('Error fetching property details:', error);
        });
}


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
                    script.src = 'SellerViewApi.js';
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
