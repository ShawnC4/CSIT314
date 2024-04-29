class AgentViewApi {
    constructor() {

    }
     
    getAgentProperties() {
        fetch(`AgentView.php?action=getAgentProperties&agentId=${window.userId}`)
        .then(response => response.json())
        .then(properties => {
            console.log(properties);
            const propertiesList = document.getElementById('propertyList');
            propertiesList.innerHTML = '';
            properties.forEach(property => {
                fetch(`AgentView.php?action=getSellerName&sellerId=${property.seller_id}`)
                .then(response => response.json())
                .then(seller => {
                    //name
                    const row = document.createElement('tr');
                    const nameCell = document.createElement('td');
                    nameCell.textContent = property.name;
                    row.appendChild(nameCell);

                    //seller
                    const usernameCell = document.createElement('td');
                    usernameCell.textContent = seller.username;
                    row.appendChild(usernameCell);

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
                        editProperty(property.id);
                    });
                    buttonCell.appendChild(updateButton);

                    //delete button
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    deleteButton.addEventListener('click', () => {
                        deleteProperty(property.id);
                    });
                    buttonCell.appendChild(deleteButton);

                    row.appendChild(buttonCell);
                    propertiesList.appendChild(row);
                })
                .catch(error => console.error('Error fetching seller name:', error));
            });
        })
        .catch(error => console.error('Error fetching properties:', error));
    }

    viewProperty(propertyId) {
        fetch(`AgentView.php?action=getProperty&propertyId=${propertyId}`)
        .then(response => response.json())
        .then(property => {
            console.log(property);
            fetch(`AgentView.php?action=getSellerName&sellerId=${property.seller_id}`)
            .then(response => response.json())
            .then(seller => {
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
                    <p>Seller: ${seller.username}</p>
                    <p>Status: ${property.status}</p>
                `;
                modalFeatures();
            })
            .catch(error => console.error('Error fetching seller name:', error));
        })
        .catch(error => console.error('Error fetching property:', error));
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

const agentViewApi = new AgentViewApi();

function initialize() {
    agentViewApi.getAgentProperties();
}

window.onload = initialize();