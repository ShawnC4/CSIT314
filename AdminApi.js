class AdminApi {
    constructor() {
        this.fetchUserProfiles();
    }

    createProfileApiCall = (event) => {
        event.preventDefault();
        const profileName = document.getElementById('profileName').value;
        const activeStatus = document.getElementById('activeStatus').checked;
        const description = document.getElementById('description').value;

        // Check if profile name already exists
        if (this.profileExists(profileName)) {
            alert('Profile already exists!');
            return; // Exit function if profile already exists
        }
        
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

    profileExists = (profileName) => {
        const profiles = document.querySelectorAll('#profileList > div');
        for (let i = 0; i < profiles.length; i++) {
            const name = profiles[i].querySelector('span').textContent.trim();
            if (name === profileName) {
                return true; // Profile exists
            }
        }
        return false; // Profile does not exist
    }

    updateProfileApiCall = (profileId, profileName, activeStatus, description) => {
        fetch('AdminUpdateUPController.php?action=updateProfile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ profileId, profileName, activeStatus, description })
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            this.fetchUserProfiles();  
        })
        .catch(error => console.error('Error updating user profile:', error));
    }

    suspendProfileApiCall = (profileId) => {
        fetch('AdminSuspendUPController.php?action=suspendProfile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ profileId })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data.success) {
                //window.location.reload();
                alert('Profile suspended successfully');
                window.location.reload();
            } else {
                alert('Failed to suspend profile');
            }
            // Refresh the profiles list here if necessary
        })
        .catch(error => console.error('Error suspending user profile:', error));
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
                profileName.textContent = profile.name + ' ';
                profileContainer.appendChild(profileName);

                //Display profile status 
                const profileStatus =  document.createElement('span');
                profileStatus.textContent = profile.activeStatus == 1 ? 'Active' : 'Inactive';
                profileContainer.appendChild(profileStatus);

                //Create view button
                const viewButton = document.createElement('button')
                viewButton.textContent = 'View'
                viewButton.addEventListener('click', () => {
                    viewProfile(profile.id, profile.name, profile.activeStatus, profile.description);
                });
                profileContainer.appendChild(viewButton)

                // Create edit button
                const editButton = document.createElement('button');
                editButton.textContent = 'Edit';
                editButton.addEventListener('click', () => {
                    // Call displayUpdate function to display the form for updating profile
                    displayUpdate(profile.id, profile.name, profile.activeStatus, profile.description);
                });
                profileContainer.appendChild(editButton);

                // Create suspend button
                const suspendButton = document.createElement('button');
                if (profile.activeStatus != true) {
                    suspendButton.classList.add("disable-btn");
                    //suspendButton.disabled = true;  // Disables the button, preventing user interaction  
                }
                suspendButton.textContent = 'Suspend';
                suspendButton.addEventListener('click', () => {
                    // Handle suspend functionality here
                    if (confirm('Are you sure you want to suspend this profile?')) {
                        this.suspendProfileApiCall(profile.id);
                    }
                });
                profileContainer.appendChild(suspendButton);
            
                // Append profile container to profile list
                profileList.appendChild(profileContainer);
            });
        })
        .catch(error => console.error('Error fetching user profiles:', error));
    }

    searchProfile = () => {
        // Get value entered in search input field and convert it to lowercase
        const searchInput = document.getElementById('searchInput').value.toLowerCase();

        // Select all profile containers
        const profileContainers = document.querySelectorAll('#profileList > div');

        // Iterate over each profile container
        profileContainers.forEach(container => {
            // Get text content of profile name within container and convert it to lowercase
            const profileName = container.querySelector('span').textContent.toLowerCase();

            // Check if profile name includes search input
            if (profileName.includes(searchInput)) {

                // display container if profile name includes search input
                container.style.display = 'block';
            }
            else {
                // hide container if profile name does not include search input
                container.style.display = 'none';
            }
        });
    }
};

window.onload = function() {
    loadContent('AdminUP.php');
};

const admin = new AdminApi();

function displayCreate() {
    const Form = document.getElementById('modal-content');
    
    Form.style.display = 'block';
        
    Form.innerHTML = `
    <span class="close">&times;</span>
    <form id="UpForm">
    <br><input type="text" id="profileName" name="profileName" placeholder="Profile Name"><br>
    <br><label><input type="checkbox" id="activeStatus" name="activeStatus">Active Status</label><br>
    <br><label for="description">Description:</label><br>
    <input type="text" id="description" name="description" placeholder="Description"><br>
    <br><button id="SubmitUpForm" type="submit">Submit</button><br>
    </form>
    `;
    
    document.getElementById('UpForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Perform validation
        const profileName = document.getElementById('profileName').value;
        const description = document.getElementById('description').value;

        if (!profileName.trim()) {
            alert('Profile Name cannot be empty');
            return;
        }

        if (!description.trim()) {
            alert('Description cannot be empty');
            return;
        }

        // Call the create profile API function if validation passes
        admin.createProfileApiCall(event);
        alert(`Profile ${profileName} was created successfully!`)
        document.getElementById("myModal").style.display = "none";
    });

    modalFeatures();
}

function viewProfile(id, name, activeStatus, description){
    const Form = document.getElementById('modal-content');

    const isActive = activeStatus == 1;

    Form.style.display = 'block';

    Form.innerHTML = `
    <span class="close">&times;</span>
    <div class = "profile-view">
    <h2>Profile Details</h2>
    <p><strong>ID:</strong> ${id}</p>
    <p><strong>Name:</strong> ${name}</p>
    <p><strong>Status:</strong> ${isActive ? 'Active' : 'Inactive'}</p>
    <p><strong>Description:</strong> ${description}</p>
    </div>
    `;

    modalFeatures();
}

function displayUpdate(profileId, profileName, activeStatus, description) {
    const Form = document.getElementById('modal-content');
    
    Form.style.display = 'block';
    
    Form.innerHTML = `
    <span class="close">&times;</span>
    <form id="UpForm">
    <input type="hidden" id="profileId" name="profileId" value="${profileId}">
    <br><input type="text" id="profileName" name="profileName" value="${profileName}" placeholder="Profile Name"><br>
    <br><label><input type="checkbox" id="activeStatus" name="activeStatus">Active Status</label><br>
    <br><label for="description">Description:</label><br>
    <input type="text" id="description" name="description" value="${description}" placeholder="Description"><br>
    <br><button id="SubmitUpForm" type="submit">Submit</button><br>
    </form>
    `;
    
    // Store original values after populating the form
    const originalProfileName = document.getElementById('profileName').value; // Moved inside
    const activeStatusCheckbox = document.getElementById('activeStatus');
    activeStatusCheckbox.checked = activeStatus;  // Set checked based on actual value
    const originalDescription = document.getElementById('description').value.trim(); // Use trim for description
    
    document.getElementById('UpForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const updatedProfileId = document.getElementById('profileId').value;
        const updatedProfileName = document.getElementById('profileName').value;
        // Retrieve the checked status of the checkbox inside the event listener
        const updatedActiveStatus = document.getElementById('activeStatus').checked;
        const updatedDescription = document.getElementById('description').value;
    
        // Check if any information was edited
        if (updatedProfileName.trim() === originalProfileName.trim() &&
            updatedActiveStatus === activeStatus &&
            updatedDescription.trim() === originalDescription.trim()) {
            
            alert("Nothing was changed");
            return;
        }

        // Add empty field checks
        if (updatedProfileName.trim() === '') {
            alert("Profile Name cannot be empty");
            return;
        } 
        
        else if (updatedDescription.trim() === '') {
            alert("Description cannot be empty");
            return;
        }
        
        else {
                // If validation passes, proceed with confirmation popup
                const confirmation = confirm(`Are you sure you want to update ${originalProfileName}'s details?`);
                if (confirmation) {
                // Call the update profile API function
                admin.updateProfileApiCall(updatedProfileId, updatedProfileName, updatedActiveStatus, updatedDescription);
                document.getElementById("myModal").style.display = "none";
                }
            }
        });

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
    //window.onclick = function(event) {
    //    if (event.target == modal) {
    //        modal.style.display = "none";
    //    }
    //}
    
}

function initialize() {
    admin.fetchUserProfiles();
    document.getElementById('createProfile').addEventListener('click', displayCreate);
    document.getElementById('searchInput').addEventListener('input', admin.searchProfile);
}


function loadContent(page) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("UPUA").innerHTML = this.responseText;
        initialize();
    }
    };
    xhttp.open("GET", page, true);
    xhttp.send();
}
