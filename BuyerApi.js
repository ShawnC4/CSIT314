class BuyerApi {
    constructor () {

    }

    getViewNumberOfPages () {
        fetch('BuyerLanding.php?action=getViewNumberOfPages')
        .then(response => response.json())
        .then(numberOfPages => {
            const pageSelect = document.getElementById('pageSelect');
            pageSelect.innerHTML = '';

            for (let i = 1; i <= numberOfPages; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                pageSelect.appendChild(option);
            }
        });
    }

    getShortlistNumberOfPages () {
        fetch(`BuyerLanding.php?action=getShortlistNumberOfPages&buyerId=${window.userID}`)
        .then(response => response.json())
        .then(numberOfPages => {
            const pageSelect = document.getElementById('pageSelect');
            pageSelect.innerHTML = '';

            for (let i = 1; i <= numberOfPages; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                pageSelect.appendChild(option);
            }
        });
    }

    getViewDashboard (pageNumber) {
        fetch(`BuyerLanding.php?action=getViewDashboard&page=${pageNumber}`)
        .then(response => response.json())
        .then(propertyObjects => {
            console.log(propertyObjects);
            const propertyList = document.querySelector('.property-listings');
            propertyList.innerHTML = '';

            propertyObjects.forEach(property => {
                // Create div for property image, name and status
                var propertyDiv = document.createElement('div');
                propertyDiv.classList.add('property');
                // Create image element
                var img = document.createElement('img');
                img.src = property.image; // Assuming property.image is the image URL
                img.alt = property.id;
                // Append elements to container
                propertyDiv.appendChild(img);
                var propertyDetailsDiv = document.createElement('div');
                propertyDetailsDiv.classList.add('property-details');
                // Create h2 element for property name
                var propertyName = document.createElement('h2');
                propertyName.textContent = property.name;

                // Append elements to propertyDiv
                propertyDetailsDiv.appendChild(propertyName);

                // View button
                var viewButton = document.createElement('button');
                viewButton.textContent = 'View';
                viewButton.addEventListener('click', () => {
                    this.displayProperty(property.id);
                });

                propertyDetailsDiv.appendChild(viewButton);

                // ShortList button
                this.shortListExists(property.id).then(exists => {
                    if (!exists) {
                        var shortListButton = document.createElement('button');
                        shortListButton.textContent = 'Add To ShortList';
                        shortListButton.addEventListener('click', () => {
                            this.shortListProperty(property.id);
                        });
                
                        propertyDetailsDiv.appendChild(shortListButton);
                    }
                });

                // Create button for Give Rating
                var ratingButton = document.createElement('button');
                ratingButton.textContent = 'Give Rating';
                ratingButton.addEventListener('click', () => {
                    this.displayRating(property.id);
                });
                // Create button for Give Review
                var reviewButton = document.createElement('button');
                reviewButton.textContent = 'Give Review';
                reviewButton.addEventListener('click', () => {
                    this.displayReview(property.id);
                });
                // Append Give Rating and Give Review buttons to container
                propertyDetailsDiv.appendChild(ratingButton);
                propertyDetailsDiv.appendChild(reviewButton);
                propertyDiv.appendChild(propertyDetailsDiv);
                
                // Append property container to listings
                propertyList.appendChild(propertyDiv);
            });
        });
    }

    getShortlistDashboard(pageNumber) {
        // Fetch shortlisted properties for the logged-in user
        fetch(`BuyerLanding.php?action=getShortlistDashboard&buyerId=${window.userID}&page=${pageNumber}`)
        .then(response => response.json())
        .then(shortlistedProperties => {
            console.log(shortlistedProperties);

            const shortlistListing = document.querySelector('.shortlist-listing');
            shortlistListing.innerHTML = '';
            
            if (shortlistedProperties.length === 0) {
                var message = document.createElement('h1');
                message.innerHTML = 'No properties shortlisted';
                shortlistListing.appendChild(message);
            } else {
                shortlistedProperties.forEach(property => {
                    // Create div for property image, name, and status
                    var propertyDiv = document.createElement('div');
                    propertyDiv.classList.add('property');
        
                    // Create image element
                    var img = document.createElement('img');
                    img.src = property.image; // Assuming property.image is the image URL
                    img.alt = property.id;
        
                    // Append elements to container
                    propertyDiv.appendChild(img);
        
                    var propertyDetailsDiv = document.createElement('div');
                    propertyDetailsDiv.classList.add('property-details');
        
                    // Create h2 element for property name
                    var propertyName = document.createElement('h2');
                    propertyName.textContent = property.name;
        
                    // Append elements to propertyDiv
                    propertyDetailsDiv.appendChild(propertyName);
        
                    // View button
                    var viewButton = document.createElement('button');
                    viewButton.textContent = 'View';
                    viewButton.addEventListener('click', () => {
                        this.displayProperty(property.id);
                    });
        
                    propertyDetailsDiv.appendChild(viewButton);

                    //Delete ShortList button
                    var shortListButton = document.createElement('button');
                    shortListButton.textContent = 'Delete ShortList';
                    shortListButton.addEventListener('click', () => {
                        this.deleteShortListProperty(property.id);
                    });
                
                    propertyDetailsDiv.appendChild(shortListButton);

                    // Create button for Give Rating
                    var ratingButton = document.createElement('button');
                    ratingButton.textContent = 'Give Rating';
                    ratingButton.addEventListener('click', () => {
                        this.displayRating(property.id);
                    });
                    // Create button for Give Review
                    var reviewButton = document.createElement('button');
                    reviewButton.textContent = 'Give Review';
                    reviewButton.addEventListener('click', () => {
                        this.displayReview(property.id);
                    });
                    // Append Give Rating and Give Review buttons to container
                    propertyDetailsDiv.appendChild(ratingButton);
                    propertyDetailsDiv.appendChild(reviewButton);
        
                    // Append propertyDetailsDiv to propertyDiv
                    propertyDiv.appendChild(propertyDetailsDiv);
        
                    // Append property container to shortlist container
                    shortlistListing.appendChild(propertyDiv);
                });
            }
        });
    }

    displayProperty(id) {
        fetch(`BuyerLanding.php?action=viewProperty&propertyId=${id}`)
            .then(response => response.json())
            .then(propertyDetails => {
                console.log(propertyDetails);
                // Assuming you have a modal for property details
                document.getElementById('modal-content').innerHTML = `
                    <span class="close">&times;</span>
                    <div id="details">
                        <div>
                            <p>Property ID: ${id}</p>
                            <p>Name: ${propertyDetails.name}</p>
                            <p>Type: ${propertyDetails.type}</p>
                            <p>Size: ${propertyDetails.size}</p>
                            <p>Rooms: ${propertyDetails.rooms}</p>
                            <p>Price: ${propertyDetails.price}</p>
                            <p>Location: ${propertyDetails.location}</p>
                            <p>Status: ${propertyDetails.status}</p>
                            <p>Seller: ${propertyDetails.seller_id}</p>
                            <p>Number of Views: ${propertyDetails.views}</p>
                        </div>
                `;
                //create a property image div to append to modal content
                var propertyImage = document.createElement('div');
                propertyImage.classList.add('property-image');
                // Create img element for property image
                var img = document.createElement('img');
                img.src = propertyDetails.image; // Assuming propertyDetails.image is the image URL
                // Set style for property image
                img.style.maxWidth = '100%';
                img.style.height = 'auto';
                // Append img element to propertyImage div
                propertyImage.appendChild(img);

                propertyImage.style.maxWidth = '50%';
                propertyImage.style.height = 'auto';
                document.getElementById('details').appendChild(propertyImage);

                modalFeatures();
            })
            .catch(error => {
                console.error('Error fetching property details:', error);
            });
    }

    async shortListExists (propertyId) {
        const response = await fetch(`BuyerLanding.php?action=shortListExists&propertyId=${propertyId}&buyerId=${window.userID}`);
        const exist = await response.json();
        return exist;
    }

    shortListProperty (propertyId) {
        fetch(`BuyerLanding.php?action=shortListProperty&propertyId=${propertyId}&buyerId=${window.userID}`)
        .then(response => response.json())
        .then(response => {
            alert(response.message);
            this.getViewDashboard(1);
        });
    }

    deleteShortListProperty (propertyId) {
        fetch(`BuyerLanding.php?action=deleteShortlistProperty&propertyId=${propertyId}&buyerId=${window.userID}`)
        .then(response => response.json())
        .then(response => {
            alert(response.message);
            this.getShortlistDashboard(1);
        });
    }

    //Create Review 
    displayReview(propertyId) {
        // Fetch property details to get necessary information
        fetch(`BuyerLanding.php?action=viewProperty&propertyId=${propertyId}`)
            .then(response => response.json())
            .then(propertyDetails => {
                // Create modal content
                const modalContent = document.getElementById('modal-content');
                modalContent.innerHTML = `
                    <span class="close">&times;</span>
                    <div id="review-form">
                        <h2>Review the Agent</h2>
                        <form id="reviewForm">
                            <div>
                                <label for="propertyName">Property Name:</label>
                                <span id="propertyName">${propertyDetails.name}</span>
                            </div>
                            <div>
                                <label for="agentID">Real Estate Agent:</label>
                                <span id="agentID">${propertyDetails.agent_id}</span>
                            </div>
                            <div>
                                <label for="agentReview">Review:</label>
                                <textarea id="agentReview" name="agentReview" rows="4" cols="50" required placeholder="Type your review here..."></textarea>
                            </div>
                            <button type="submit">Submit Review</button>
                        </form>
                    </div>
                `;
                // Add event listener to form submission
                const reviewForm = document.getElementById('reviewForm');
                reviewForm.addEventListener('submit', this.createReview);
                
                // Display the modal
                modalFeatures();
            })
            .catch(error => {
                console.error('Error fetching property details:', error);
            });
    }
    
    createReview = (event) => {
        event.preventDefault();
        // Extract values from the form
        const agentReview = document.getElementById('agentReview').value;
        const customerID = userID; // Assuming userID is accessible here
        const agentID = document.getElementById('agentID').textContent;
        
        fetch('BuyerLanding.php?action=createReview', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ agentReview, customerID, agentID })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error in the network!');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            if (data === true){
                alert(`Review for ${agentID} was created successfully!`);
                document.getElementById("myModal").style.display = "none";
            } else if(data['message'] == 'error'){
                console.error('Error reviewing agent:', data['errorMessage']);
            }
        })
        .catch(error => console.error('Error reviewing agent:', error));
    }
    // Create Rating 
    displayRating(propertyId) {
        // Fetch property details to get necessary information
        fetch(`BuyerLanding.php?action=viewProperty&propertyId=${propertyId}`)
            .then(response => response.json())
            .then(propertyDetails => {
                // Create modal content
                const modalContent = document.getElementById('modal-content');
                modalContent.innerHTML = `
                    <span class="close">&times;</span>
                    <div id="rating-form">
                        <h2>Rate the Agent</h2>
                        <form id="ratingForm">
                            <div>
                                <label for="propertyName">Property Name:</label>
                                <span id="propertyName">${propertyDetails.name}</span>
                            </div>
                            <div>
                                <label for="agentID">Real Estate Agent:</label>
                                <span id="agentID">${propertyDetails.agent_id}</span>
                            </div>
                            <div>
                                <label for="agentRating">Rating (1-5):</label>
                                <input type="number" id="agentRating" name="agentRating" min="1" max="5" required>
                            </div>
                            <button type="submit">Submit Rating</button>
                        </form>
                    </div>
                `;

                // Add event listener to form submission
                const ratingForm = document.getElementById('ratingForm');
                ratingForm.addEventListener('submit', this.createRating);
                
                // Display the modal
                modalFeatures();
            })
            .catch(error => {
                console.error('Error fetching property details:', error);
            });
    }

    createRating = (event) => {
        event.preventDefault();
        // Extract values from the form
        const agentRating = document.getElementById('agentRating').value;
        const customerID = userID; // Assuming userID is accessible here
        const agentID = document.getElementById('agentID').textContent;
    
        fetch('BuyerLanding.php?action=createRating', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ agentRating, customerID, agentID })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error in the network!');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            if (data === true){
                alert(`Rating for ${agentID} was created successfully!`);
                document.getElementById("myModal").style.display = "none";
            } else if(data['message'] == 'error'){
                console.error('Error rating agent:', data['errorMessage']);
            }
        })
        .catch(error => console.error('Error rating agent:', error));
    }

    //SEARCH//
    searchBuyerProperty = () => {
        // Get value entered in search input field and convert it to lowercase
        const propertyName = document.getElementById('searchInput').value.toLowerCase();
        const propertyStatus = document.getElementById('filterSelect').value;
        const pageNum = document.getElementById('pageSelect').value; // Get selected page number
        
        if (propertyName.trim() == '') {
            this.getViewDashboard(1);
            return;
        }
        
        fetch(`BuyerLanding.php?action=searchBuyerProperty&pageNum=${pageNum}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status: propertyStatus, name: propertyName, pageNum: pageNum }) // Include pageNum in the JSON object
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            
            if (!data.success) // Access 'success' directly instead of using brackets
            throw new Error(data.errorMessage);

            // Display search results
            this.displaySearchResults(data.properties);
        })
        .catch(error => console.error('Error searching properties:', error));
    }

    displaySearchResults = (properties) => {
        const propertyList = document.querySelector('.property-listings');
        propertyList.innerHTML = '';

        if (properties && properties.length > 0) {
            properties.forEach(property => {
                // Create div for property image, name, and status
                var propertyDiv = document.createElement('div');
                propertyDiv.classList.add('property');
        
                // Create image element
                var img = document.createElement('img');
                img.src = property.image; // Assuming property.image is the image URL
                img.alt = property.id;
        
                // Append elements to container
                propertyDiv.appendChild(img);
        
                var propertyDetailsDiv = document.createElement('div');
                propertyDetailsDiv.classList.add('property-details');
        
                // Create h2 element for property name
                var propertyName = document.createElement('h2');
                propertyName.textContent = property.name;
        
                // Append elements to propertyDiv
                propertyDetailsDiv.appendChild(propertyName);
        
                // View button
                var viewButton = document.createElement('button');
                viewButton.textContent = 'View';
                viewButton.addEventListener('click', () => {
                    this.displayProperty(property.id);
                });
        
                propertyDetailsDiv.appendChild(viewButton);
        
                // ShortList button
                this.shortListExists(property.id).then(exists => {
                    if (!exists) {
                        var shortListButton = document.createElement('button');
                        shortListButton.textContent = 'Add To ShortList';
                        shortListButton.addEventListener('click', () => {
                            this.shortListProperty(property.id);
                        });
        
                        propertyDetailsDiv.appendChild(shortListButton);
                    }
                });
        
                // Create button for Give Rating
                var ratingButton = document.createElement('button');
                ratingButton.textContent = 'Give Rating';
                ratingButton.addEventListener('click', () => {
                    this.displayRating(property.id);
                });
                // Create button for Give Review
                var reviewButton = document.createElement('button');
                reviewButton.textContent = 'Give Review';
                reviewButton.addEventListener('click', () => {
                    this.displayReview(property.id);
                });
                // Append Give Rating and Give Review buttons to container
                propertyDetailsDiv.appendChild(ratingButton);
                propertyDetailsDiv.appendChild(reviewButton);
        
                // Append propertyDetailsDiv to propertyDiv
                propertyDiv.appendChild(propertyDetailsDiv);
        
                // Append property container to listings
                propertyList.appendChild(propertyDiv);
            });

            // Calculate total pages and update dropdown
            console.log("properties.length is", properties.length);
            const totalPages = Math.ceil(properties.length / 9);
            console.log("totalPages is", totalPages);
            this.updatePageSelectionDropdown(totalPages);

        } else {
            // Display message when there are no search results
            const noResultsMessage = document.createElement('div');
            noResultsMessage.textContent = 'No search results found.';
            propertyList.appendChild(noResultsMessage);
        }

    }
    
    // Function to update page selection dropdown based on total number of pages
    updatePageSelectionDropdown = (totalPages) => {
        const pageSelect = document.getElementById('pageSelect');
        pageSelect.innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            pageSelect.appendChild(option);
        }
    }

}

function modalFeatures () {
    // Get the modal
    var modal = document.getElementById("myModal");

    modal.style.display = "block";

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    }
}

const BuyerApiInstance = new BuyerApi();

function initializeView () {
    BuyerApiInstance.getViewDashboard(1);
    BuyerApiInstance.getViewNumberOfPages();

    document.getElementById('pageSelect').addEventListener('change', function() {
        const pageNumber = this.value;
        BuyerApiInstance.getViewDashboard(pageNumber);
    });
    // Event listener for search input
    document.getElementById('searchInput').addEventListener('input', BuyerApiInstance.searchBuyerProperty);

    // Event listener for dropdown filter
    document.getElementById('filterSelect').addEventListener('change', function () {
        const pageNumber = document.getElementById('pageSelect').value; // Get current page number
        BuyerApiInstance.getViewDashboard(pageNumber); // Refresh dashboard based on current page number
    });
}

function initializeShortlist () {
    BuyerApiInstance.getShortlistDashboard(1);
    BuyerApiInstance.getShortlistNumberOfPages();

    document.getElementById('pageSelect').addEventListener('change', function() {
        const pageNumber = this.value;
        BuyerApiInstance.getShortlistDashboard(pageNumber);
    });
}



window.onload = () => {
    loadContent('BuyerView.php');
}

function loadContent(page) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Attempt to set the innerHTML property of an element
            var element = document.querySelector("#body"); // Change to the appropriate selector
            if (element !== null) {
                element.innerHTML = this.responseText;
                
                if (page === 'BuyerView.php') {
                    initializeView();
                } else if (page === 'BuyerShortlist.php') {
                    initializeShortlist();
                }
            } else {
                console.error("Element not found.");
            }
        }
    };
    xhttp.open("GET", page, true);
    xhttp.send();
}