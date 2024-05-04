class AgentApi {
    constructor() {

    }
    getAgentProperties() {
        fetch(`AgentView.php?action=getAgentProperties&agentId=${window.userID}`)
        .then(response => response.json())
        .then(properties => {
            console.log(properties);
            const propertiesList = document.getElementById('propertyList');
            propertiesList.innerHTML = '';
            properties.forEach(property => {
                //name
                const row = document.createElement('tr');
                row.id = `property-row-${property.id}`;
                const nameCell = document.createElement('td');
                nameCell.textContent = property.name;
                row.appendChild(nameCell);
                //seller
                const usernameCell = document.createElement('td');
                usernameCell.textContent = property.seller_id;
                row.appendChild(usernameCell);
                //location
                const locationCell = document.createElement('td');
                locationCell.textContent = property.location;
                row.appendChild(locationCell);
                //price
                const priceCell = document.createElement('td');
                priceCell.textContent = property.price;
                row.appendChild(priceCell);
                //view button
                const buttonCell = document.createElement('td');
                const viewButton = document.createElement('button');
                viewButton.textContent = 'View';
                viewButton.addEventListener('click', () => {
                    this.viewProperty(property.id);
                });
                buttonCell.appendChild(viewButton);
                //update button
                const updateButton = document.createElement('button');
                updateButton.textContent = 'Update';
                updateButton.addEventListener('click', () => {
                    this.updateProperty(property.id);
                });
                buttonCell.appendChild(updateButton);
                //delete button
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.addEventListener('click', () => {
                    if (confirm('Are you sure you want to delete this property ?')){
                        this.deleteProperty(property.id,row);
                    }
                });
                buttonCell.appendChild(deleteButton);
                row.appendChild(buttonCell);
                propertiesList.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching properties:', error));
    }

    getAgentRatings() {
        fetch(`AgentRating.php?action=getAgentRatings&agentId=${window.userID}`)
        .then(response => response.json())
        .then(ratings => {
            console.log(ratings);
            const ratingList = document.getElementById('ratingList');
            ratingList.innerHTML = '';
            ratings.forEach(rating => {
                const ratingDiv = document.createElement('div');
                ratingDiv.classList.add('rating');
                const userP = document.createElement('p');
                userP.classList.add('user');
                userP.textContent = rating.customer_id;
                ratingDiv.appendChild(userP);
                const scoreP = document.createElement('p');
                scoreP.classList.add('score');
                scoreP.textContent = `Rating: ${rating.rating}`;
                ratingDiv.appendChild(scoreP);
                ratingList.appendChild(ratingDiv);
            });

            // Calculate average rating
            const totalRatings = ratings.length;
            const totalScore = ratings.reduce((sum, rating) => sum + parseInt(rating.rating), 0);
            const averageRating = totalScore / totalRatings;
            // Append average rating to element
            const avgRatingElement = document.getElementById('AvgRating');
            avgRatingElement.textContent = `${averageRating.toFixed(2)} out of 5 stars`;
        })
        .catch(error => console.error('Error fetching ratings:', error));
    }

    //Agent Review 
    getAgentReviews() {
        fetch(`AgentReview.php?action=getAgentReviews&agentId=${window.userID}`)
        .then(response => response.json())
        .then(reviews => {
            console.log(reviews);
            const reviewList = document.getElementById('reviewList'); // Make sure 'reviewList' is the correct ID in your HTML
            reviewList.innerHTML = '';
            reviews.forEach(review => {
                const reviewDiv = document.createElement('div');
               // reviewDiv.classList.add('review'); // 
    
                const userP = document.createElement('p');
                userP.classList.add('user');
                userP.textContent = review.customer_id; // 
                reviewDiv.appendChild(userP);
    
                const reviewP = document.createElement('p');
                //reviewP.classList.add('review-text'); //
                reviewP.textContent = `Review: ${review.review}`; // 
                reviewDiv.appendChild(reviewP);
    
                reviewList.appendChild(reviewDiv);
            });
        })
        .catch(error => console.error('Error fetching reviews:', error));
    }
    
    viewProperty(propertyId) {
        fetch(`AgentView.php?action=getProperty&propertyId=${propertyId}`)
        .then(response => response.json())
        .then(property => {
            console.log(property);
            const modalContent = document.getElementById('modal-content');
            modalContent.innerHTML = `
                <span class="close">&times;</span>
                <div class = "property-view">
                <h2>Name: ${property.name}</h2>
                <p>Type: ${property.type}</p>
                <p>Sqft: ${property.size}</p>
                <p>Rooms: ${property.rooms}</p>
                <p>Price: $${property.price}</p>
                <p>Location: ${property.location}</p>
                <p>Seller: ${property.seller_id}</p>
                <p>Status: ${property.status}</p>
            `;
            modalFeatures();
        })
        .catch(error => console.error('Error fetching property:', error));
    }

    //Delete Property function
    deleteProperty(propertyId) {  
        fetch(`AgentView.php?action=deleteProperty&propertyId=${propertyId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ propertyId: propertyId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Property deleted successfully');
                const row = document.getElementById(`property-row-${propertyId}`);
                if (row) {
                    row.remove(); // Remove the row from the table
                }
            } else {
                alert('Failed to delete property');
            }
        })
        .catch(error => console.error('Error deleting property:', error));
    }
    

    //SEARCH
    searchEngineProperty = () => {
        // Get value entered in search input field and convert it to lowercase
        const searchInput = document.getElementById('searchProperty').value.toLowerCase();

        // Select all profile containers
        const propertyContainers = document.querySelectorAll('#propertyList > tr');

        // Iterate over each profile container
        propertyContainers.forEach(container => {
            // Get text content of profile name within container and convert it to lowercase
            const propertyName = container.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const propertyLocation = container.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const propertyPrice = container.querySelector('td:nth-child(4)').textContent.toLowerCase();

            // Check if profile name includes search input
            if (propertyName.includes(searchInput) || propertyLocation.includes(searchInput) || propertyPrice.includes(searchInput)){

                // display container if profile name includes search input
                container.style.visibility = 'visible';
            }
            else {
                // hide container if profile name does not include search input
                container.style.visibility = 'collapse';
            }
        });
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

const AgentApi = new AgentApi();

function initializeView() {
    AgentApi.getAgentProperties();

    document.getElementById('searchProperty').addEventListener('input', AgentApi.searchEngineProperty);
}

function initializeRating() {
    AgentApi.getAgentRatings();
}

window.onload = () => {
    loadContent('AgentView.php');
}

function initializeReview() {
    AgentApi.getAgentReviews();
}

function loadContent(page) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Attempt to set the innerHTML property of an element
            var element = document.querySelector(".body"); // Change to the appropriate selector
            if (element !== null) {
                element.innerHTML = this.responseText;
                
                if (page === 'AgentView.php') {
                    initializeView();
                } else if (page === "AgentRating.php") {
                    initializeRating();
                } else if (page === "AgentReview.php") {
                    initializeReview();
                }
            } else {
                console.error("Element not found.");
            }
        }
    };
    xhttp.open("GET", page, true);
    xhttp.send();
}