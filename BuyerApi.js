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
                var shortListButton = document.createElement('button');
                shortListButton.textContent = 'Add To ShortList';
                shortListButton.addEventListener('click', () => {
                    this.shortListProperty(property.id);
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
                propertyDiv.appendChild(propertyDetailsDiv);
                
                // Append property container to listings
                propertyList.appendChild(propertyDiv);
            });
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