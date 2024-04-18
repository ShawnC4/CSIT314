class AdminApi {
    constructor() {
        document.getElementById('UpForm').addEventListener('submit', this.handleCreate.bind(this));
        this.fetchUserProfiles();
    }

    handleCreate(event) {
        event.preventDefault();
        const profileName = document.getElementById('profileName').value;
        const createPermission = document.getElementById('createPermission').checked;
        const readPermission = document.getElementById('readPermission').checked;
        const updatePermission = document.getElementById('updatePermission').checked;
        const deletePermission = document.getElementById('deletePermission').checked;

        this.CreateProfileApiCall(profileName, createPermission, readPermission, updatePermission, deletePermission);
    }

    CreateProfileApiCall(profileName, createPermission, readPermission, updatePermission, deletePermission) {
        fetch('AdminCreateUPController.php?action=createProfile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ profileName, createPermission, readPermission, updatePermission, deletePermission })
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            this.fetchUserProfiles();
        })
        .catch(error => console.error('Error creating profile:', error));
    }

    updateProfileApiCall = (event, profileId) => {
        event.preventDefault();
        const profileName = document.getElementById('updateProfileName').value;
        const activeStatus = document.getElementById('updateActiveStatus').checked;
        const description = document.getElementById('updateDescription').value;

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
        .catch(error => console.error('Error updating profile:', error));
    }

    fetchUserProfiles() {
        fetch('AdminViewUPController.php?action=getProfiles')
        .then(response => response.json())
        .then(profiles => {
            console.log(profiles);
            const profileList = document.getElementById('profileList');
            profileList.innerHTML = ''; // Clear previous content
            profiles.forEach(profile => {
                const profileItem = document.createElement('div');
                profileItem.textContent = profile.id;
                profileList.appendChild(profileItem);
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

function displayUpdate() {
    const Form = document.getElementById('modal-content');
    
    Form.style.display = 'block';
        
    Form.innerHTML = `
    <span class="close">&times;</span>
    <form id="UpdateProfileForm">
        <input type="hidden" id="updateProfileId" value="${profileId}">
        <br><input type="text" id="updateProfileName" name="updateProfileName" placeholder="Profile Name" value="${profileName}" required><br>
        <br><label><input type="checkbox" id="updateActiveStatus" name="updateActiveStatus" ${activeStatus ? 'checked' : ''}>Active Status</label><br>
        <br><label for="updateDescription">Description:</label><br>
        <input type="text" id="updateDescription" name="updateDescription" placeholder="Description" value="${description}"><br>
        <br><button id="SubmitUpdateProfileForm" type="submit">Update</button><br>
    </form>
    `;
    
    document.getElementById('UpForm2').addEventListener('submit', admin.updateProfileApiCall);

    document.getElementById('SubmitUpForm2').addEventListener('click', () => {
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
