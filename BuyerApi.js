class BuyerApi {
    constructor() {
    }

    getDashboard () {
        fetch(`BuyerLanding.php?action=getProperties`)
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
                    displayUpdateProperty(property.name, property.type, property.size, property.rooms, property.price, property.location, property.status, property.image, property.views, property.seller_id, property.agent_id, property.id);
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
}