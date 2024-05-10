class BuyerApi {
    constructor () {

    }

    getNumberOfPages () {
        fetch('BuyerLanding.php?action=getNumberOfPages')
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

    getDashboard (pageNumber) {
        fetch(`BuyerLanding.php?action=getDashboard&page=${pageNumber}`)
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
            location.reload();
        });
    }
}

const BuyerApiInstance = new BuyerApi();

function initializeView () {
    BuyerApiInstance.getDashboard(1);
    BuyerApiInstance.getNumberOfPages();

    document.getElementById('pageSelect').addEventListener('change', function() {
        const pageNumber = this.value;
        BuyerApiInstance.getDashboard(pageNumber);
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
                }
            } else {
                console.error("Element not found.");
            }
        }
    };
    xhttp.open("GET", page, true);
    xhttp.send();
}