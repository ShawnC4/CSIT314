class AdminApi {
    constructor() {
        // Bind event listener to the login form
        document.getElementById('UpForm').addEventListener('submit', this.handleLogin.bind(this));
    }

    handleLogin(event) {
        event.preventDefault();
        const profileName = document.getElementById('profileName').value;
        const createPermission = document.getElementById('createPermission').checked;
        const readPermission = document.getElementById('readPermission').checked;
        const updatePermission = document.getElementById('updatePermission').checked;
        const deletePermission = document.getElementById('deletePermission').checked;

        this.CreateProfileApiCall(profileName, createPermission, readPermission, updatePermission, deletePermission);
    }

    CreateProfileApiCall(profileName, createPermission, readPermission, updatePermission, deletePermission) {
        fetch('AdminCreateProfileController.php?action=createProfile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ profileName, createPermission, readPermission, updatePermission, deletePermission })
        })
        .then(response => response.text())
        .then(data =>console.log(data))
    }

}

const admin = new AdminApi();
