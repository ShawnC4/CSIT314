class AgentViewApi {
    constructor() {

    }
     
    getAgentProperties() {
        fetch(`AgentView.php?action=getAgentProperties`)
        .then(response => response.json())
        .then(properties => {
            console.log(properties);
            const propertiesList = document.getElementById('propertyList');
            propertiesList.innerHTML = '';
            properties.forEach(property => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${property.name}</td>
                    <td>seller</td>
                    <td>${property.price}</td>
                    <td>
                        <button onclick="viewProperty(${property.id})">View</button>
                        <button onclick="editProperty(${property.id})">Edit</button>
                        <button onclick="deleteProperty(${property.id})">Delete</button>
                    </td>
                `;
                propertiesList.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching properties:', error));
    }
}

const agentViewApi = new AgentViewApi();

function initialize() {
    agentViewApi.getAgentProperties();
}

window.onload = initialize();