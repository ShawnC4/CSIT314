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
