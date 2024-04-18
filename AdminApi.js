class AdminApi {
    constructor() {
        document.getElementById('UpForm').addEventListener('submit', this.handleCreate.bind(this));
        this.fetchUserProfiles();
    }

    handleCreate(event) {
        event.preventDefault();
        const profileName = document.getElementById('profileName').value;
        const activeStatus = document.getElementById('activeStatus').checked;
        const description = document.getElementById('description').value;

        this.CreateProfileApiCall(profileName, activeStatus, description);
    }

    CreateProfileApiCall(profileName, activeStatus, description) {
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
                const profileItem = document.createElement('div');
                profileItem.textContent = profile.name;
                profileList.appendChild(profileItem);
            });
        })
        .catch(error => console.error('Error fetching user profiles:', error));
    }

}

const admin = new AdminApi();
