class AdminApi {
    constructor() {
        this.fetchUserProfiles();
    }

    CreateProfileApiCall = (event) => {
        event.preventDefault();
        const profileName = document.getElementById('profileName').value;
        const activeStatus = document.getElementById('activeStatus').checked;
        const description = document.getElementById('description').value;
        
        fetch('AdminCreateUPController.php?action=createProfile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ profileName, activeStatus, description })
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            this.fetchUserProfiles();  
        })
    }

    fetchUserProfiles() {
        fetch('AdminViewUPController.php?action=getProfiles')
        .then(response => response.json())
        .then(profiles => {
            console.log(profiles);
            const profileList = document.getElementById('profileList');
            profileList.innerHTML = ''; // Clear previous content
            profiles.forEach(profile => {
                // Create container for profile information
                const profileContainer = document.createElement('div');
                
                // Display profile name
                const profileName = document.createElement('span');
                profileName.textContent = profile.name;
                profileContainer.appendChild(profileName);
                
                // Create edit button
                const editButton = document.createElement('button');
                editButton.textContent = 'Edit';
                editButton.addEventListener('click', () => {
                    // Handle edit functionality here
                    console.log('Edit button clicked for profile:', profile.name);
                });
                profileContainer.appendChild(editButton);
                
                // Create suspend button
                const suspendButton = document.createElement('button');
                if (profile.activeStatus != true) {
                    suspendButton.classList.add("disable-btn");
                }
                suspendButton.textContent = 'Suspend';
                suspendButton.addEventListener('click', () => {
                    // Handle suspend functionality here
                    console.log('Suspend button clicked for profile:', profile.name);
                });
                profileContainer.appendChild(suspendButton);
                
                // Append profile container to profile list
                profileList.appendChild(profileContainer);
            });
        })
        .catch(error => console.error('Error fetching user profiles:', error));
    }
    

}

const admin = new AdminApi();

function displayCreate() {
    const Form = document.getElementById('modal-content');
    
    Form.style.display = 'block';
        
    Form.innerHTML = `
    <span class="close">&times;</span>
    <form id="UpForm">
    <br><input type="text" id="profileName" name="profileName" placeholder="Profile Name" required><br>
    <br><label><input type="checkbox" id="activeStatus" name="activeStatus">Active Status</label><br>
    <br><label for="description">Description:</label><br>
    <input type="text" id="description" name="description" placeholder="Description"><br>
    <br><button id="SubmitUpForm" type="submit">Submit</button><br>
    </form>
    `;
    
    document.getElementById('UpForm').addEventListener('submit', admin.CreateProfileApiCall);

    document.getElementById('SubmitUpForm').addEventListener('click', () => {
        document.getElementById("myModal").style.display = "none";
    });

    modalFeatures();
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

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    
}

document.getElementById('createProfile').addEventListener('click', displayCreate);
