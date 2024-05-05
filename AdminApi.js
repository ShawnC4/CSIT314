class AdminApi {
    constructor() {

    }

    createProfileApiCall = (event) => {
        event.preventDefault();
        const profileName = document.getElementById('profileName').value;
        const activeStatus = document.getElementById('activeStatus').checked;
        const description = document.getElementById('description').value;

		fetch('AdminLanding.php?action=createProfile', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ profileName, activeStatus, description })
		})
		.then(response => response.json())
		.then(data => {
			console.log(data);
			if (data['success']){
				alert(`Profile ${profileName} was created successfully!`);
				this.fetchUserProfiles();				
			}
			else if (data['message'] == 'error'){
				console.error('Error creating user profile:', data['errorMessage']);
			}
			else {
				alert(data['message']);
                return;
			}
		})
		.catch(error => console.error('Error creating user profile:', error));
    }

    createAccountApiCall = (event) => {
        event.preventDefault();
        const accountUsername = document.getElementById('accountUsername').value;
        const accountEmail = document.getElementById('accountEmail').value;
        const accountPassword = document.getElementById('accountPassword').value;
        const activeStatus = document.getElementById('activeStatus').checked;
        const accountProfile_id = document.getElementById('accountProfile_id').value;
		
		fetch('AdminLanding.php?action=createAccount', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ accountUsername, accountEmail, accountPassword, activeStatus, accountProfile_id })
		})
		.then(response => response.json())
		.then(data => {
			console.log(data);
			if (data['success']){
                alert(`Account ${accountUsername} was created successfully!`);
				this.fetchUserAccounts();
			}
			else if (data['message'] == 'error'){
				console.error('Error creating user account:', data['errorMessage']);
			}
			else {
				alert(data['message']);
                return;
			}
		})
		.catch(error => console.error('Error creating user account:', error));
    }

    updateProfileApiCall = (profileId, profileName, activeStatus, description) => {
        fetch('AdminLanding.php?action=updateProfile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ profileId, profileName, activeStatus, description })
        })
        .then(response => response.json())
        .then(data => {
			console.log(data);
			if (data['success']){
                alert(`Profile ${profileName} was updated successfully!`);
				this.fetchUserProfiles();
			}
			else {
				console.error('Error updating user profile:', data['errorMessage']);
			}
        })
        .catch(error => console.error('Error updating user profile:', error));
    }

    updateAccountApiCall = (username, email, password, activeStatus, profile_id) => {
        fetch('AdminLanding.php?action=updateAccount', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, email, password, activeStatus, profile_id })
        })
        .then(response => response.json())
        .then(data => {
			console.log(data);
			if (data['success']){
                alert(`Account ${username} was updated successfully!`);
				this.fetchUserAccounts();
			}
			else {
				console.error('Error updating user account:', data['errorMessage']);
			}
        })
        .catch(error => console.error('Error updating user account :', error));
    }

    //Suspend Profile
    suspendProfileApiCall = (profileId, profileName) => {
        fetch('AdminLanding.php?action=suspendProfile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ profileId })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data['success']) {
                alert(`Profile ${profileName} was suspended successfully!`);
                this.fetchUserProfiles();
            } else {
                console.error('Error suspending user profile:', data['errorMessage']);
            }
        })
        .catch(error => console.error('Error suspending user profile:', error));
    }
    //Suspend Account
    suspendAccountApiCall = (username) => {
        return fetch('AdminLanding.php?action=suspendAccount', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if(data['success']) {
                alert(`Account ${username} was suspended successfully!`);
				this.fetchUserAccounts();
            } else {
                console.error('Error suspending user account:', data['errorMessage']);
            }
        })
        .catch(error => console.error('Error suspending user account:', error));
    }
    
    fetchUserProfiles() {
        fetch('AdminLanding.php?action=getProfiles')
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
                    displayUpdateUP(profile.id, profile.name, profile.activeStatus, profile.description);
                });
                profileContainer.appendChild(editButton);

                // Create suspend button
                const suspendButton = document.createElement('button');
                if (profile.activeStatus != true) {
                    //suspendButton.classList.add("disable-btn");
                    suspendButton.disabled = true;  // Disables the button, preventing user interaction  
                }
                suspendButton.textContent = 'Suspend';
                suspendButton.addEventListener('click', () => {
                    // Handle suspend functionality here
                    if (confirm(`Are you sure you want to suspend Profile ${profile.name}?`)) {
                        this.suspendProfileApiCall(profile.id, profile.name);
                    }
                });
                profileContainer.appendChild(suspendButton);
            
                // Append profile container to profile list
                profileList.appendChild(profileContainer);
            });
        })
        .catch(error => console.error('Error fetching user profiles:', error));
    }

    fetchUserAccounts() {
        fetch('AdminLanding.php?action=getAccounts')
        .then(response => response.json())
        .then(accounts => {
            console.log(accounts);
            const accountList = document.getElementById('accountList');
            accountList.innerHTML = ''; // Clear previous content
            accounts.forEach(account => {
                // Create container for account information
                const accountContainer = document.createElement('div');
                
                // Display account name
                const accountName = document.createElement('span');
                accountName.textContent = account.username + ' ';
                accountContainer.appendChild(accountName);

                // Display account email
                const accountEmail = document.createElement('span');
                accountEmail.textContent = account.email + ' ';
                accountContainer.appendChild(accountEmail);

                //Display account status 
                const accountStatus =  document.createElement('span');
                accountStatus.textContent = account.activeStatus == 1 ? 'Active' : 'Inactive';
                accountContainer.appendChild(accountStatus);

                //Create view button
                const viewButton = document.createElement('button');
                viewButton.textContent = 'View';
				viewButton.addEventListener('click', () => {
                    viewAccount(account.username, account.email, account.password, account.activeStatus, account.profile_id);
                });
				accountContainer.appendChild(viewButton);

                // Create edit button
                const editButton = document.createElement('button');
                editButton.textContent = 'Edit';
                editButton.addEventListener('click', () => {
                    // Call displayUpdate function to display the form for updating profile
                    displayUpdateUA(account.username, account.email, account.password, account.activeStatus, account.profile_id);
                });
                accountContainer.appendChild(editButton);

                // Create suspend button
                const suspendButton = document.createElement('button');
                if (account.activeStatus != true) {
                    suspendButton.disabled = true; // Disables the button, preventing user interaction  
                }
                suspendButton.textContent = 'Suspend';
                suspendButton.addEventListener('click', () => {
                    // Handle suspend functionality here
                    if (confirm(`Are you sure you want to suspend Account ${account.username}?`)) {
                        this.suspendAccountApiCall(account.username);
                    }
                });
                accountContainer.appendChild(suspendButton);
            
                // Append account container to profile list
                accountList.appendChild(accountContainer);
            });
        })
        .catch(error => console.error('Error fetching user accounts:', error));
    }

    searchEngineProfile = () => {
        // Get value entered in search input field and convert it to lowercase
        const searchInput = document.getElementById('searchProfile').value.toLowerCase();

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

    searchEngineAccount= () => {
        // Get value entered in search input field and convert it to lowercase
        const searchInput = document.getElementById('searchAccount').value.toLowerCase();

        // Select all profile containers
        const accountContainers = document.querySelectorAll('#accountList > div');

        // Iterate over each profile container
        accountContainers.forEach(container => {
            // Get text content of profile name within container and convert it to lowercase
            const accountName = container.querySelector('span').textContent.toLowerCase();

            // Check if profile name includes search input
            if (accountName.includes(searchInput)) {

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

function displayCreateUP() {
    const Form = document.getElementById('modal-content');
    
    Form.style.display = 'block';
        
    Form.innerHTML = `
    <span class="close">&times;</span>
    <form id="UpForm">
        <br><input type="text" id="profileName" name="profileName" placeholder="Profile Name" required><br>
        <br><label><input type="checkbox" id="activeStatus" name="activeStatus">Active Status</label><br>
        <br><label for="description">Description:</label><br>
        <input type="text" id="description" name="description" placeholder="Description" required><br>
        <br><button id="SubmitUpForm" type="submit">Submit</button><br>
    </form>
    `;
    
    document.getElementById('UpForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Call the create profile API function if validation passes
        admin.createProfileApiCall(event);
        
        document.getElementById("myModal").style.display = "none";
    });

    modalFeatures();
}

function displayCreateUA() {
    
    fetch('AdminLanding.php?action=getProfiles')
    .then(response => response.json())
    .then(profiles => {
        const Form = document.getElementById('modal-content');

        Form.style.display = 'block';

        // Create the select element for profiles
        const profileSelect = document.createElement('select');
        profileSelect.id = 'accountProfile_id';
        profileSelect.name = 'accountProfile_id';
        profileSelect.required = true;

        // Iterate over fetched profiles and create options
        profiles.forEach(profile => {
            const option = document.createElement('option');
            option.value = profile.id;
            option.textContent = profile.name;
            profileSelect.appendChild(option);
        });

        // Create other form elements
        Form.innerHTML = `
            <span class="close">&times;</span>
            <form id="UpForm">
                <br><input type="text" id="accountUsername" name="accountUsername" placeholder="Username" required><br>
                <br><input type="email" id="accountEmail" name="accountEmail" placeholder="Email" required><br>
                <br><input type="password" id="accountPassword" name="accountPassword" placeholder="Password" required><br>
                <br><label><input type="checkbox" id="activeStatus" name="activeStatus">Active Status</label><br>
                <br><label for="accountProfile_id">Profile:</label><br>
                ${profileSelect.outerHTML}<br> <!-- Append profileSelect -->
                <br><button id="SubmitUpForm" type="submit">Submit</button><br>
            </form>
        `;

        document.getElementById('UpForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            // Call the create account API function if validation passes
            admin.createAccountApiCall(event);

            document.getElementById("myModal").style.display = "none";
        });

        modalFeatures();
    });

}

function viewProfile(id, name, activeStatus, description){
    const Form = document.getElementById('modal-content');

    const isActive = activeStatus == 1;

    Form.style.display = 'block';

    Form.innerHTML = `
    <span class="close">&times;</span>
    <div class = "profile-view">
    <h2>Profile Details</h2>
    <p><strong>Name:</strong> ${name}</p>
    <p><strong>Status:</strong> ${isActive ? 'Active' : 'Inactive'}</p>
    <p><strong>Description:</strong> ${description}</p>
    </div>
    `;

    modalFeatures();
}

function viewAccount(username, email, password, activeStatus, profile_id){
    fetch(`AdminLanding.php?action=getProfileById&profile_id=${profile_id}`)
	.then(response => response.json())
	.then(profile => {
		
		const Form = document.getElementById('modal-content');

		const isActive = activeStatus == true;

		Form.style.display = 'block';

		Form.innerHTML = `
		<span class="close">&times;</span>
		<div class = "account-view">
		<h2>Account Details</h2>
		<p><strong>Username:</strong> ${username}</p>
		<p><strong>Email:</strong> ${email}</p>
		<p><strong>Password:</strong>${password}</p>
		<p><strong>Status:</strong> ${isActive ? 'Active' : 'Inactive'}</p>
		<p><strong>Profile:</strong> ${profile.name}</p>
		</div>
		`;

		modalFeatures();
	});
}

function displayUpdateUP(profileId, profileName, activeStatus, description) {
    const Form = document.getElementById('modal-content');
    
    Form.style.display = 'block';
    
    Form.innerHTML = `
    <span class="close">&times;</span>
    <form id="UpForm">
    <input type="hidden" id="profileId" name="profileId" value="${profileId}"><br>
	<strong>Name:</strong>
	<input type="text" id="profileName" name="profileName" value="${profileName}" placeholder="Profile Name" required><br>
    <br><label><input type="checkbox" id="activeStatus" name="activeStatus">Active Status</label><br>
    <br><label for="description">Description:</label><br>
    <input type="text" id="description" name="description" value="${description}" placeholder="Description" required><br>
    <br><button id="SubmitUpForm" type="submit">Submit</button><br>
    </form>
    `;
    
    const activeStatusCheckbox = document.getElementById('activeStatus');
    activeStatusCheckbox.checked = activeStatus == true;  // Set checked based on actual value
    
    document.getElementById('UpForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const updatedProfileId = document.getElementById('profileId').value;
        const updatedProfileName = document.getElementById('profileName').value;
        // Retrieve the checked status of the checkbox inside the event listener
        const updatedActiveStatus = document.getElementById('activeStatus').checked;
        const updatedDescription = document.getElementById('description').value;

        
        const confirmation = confirm(`Are you sure you want to update ${profileName}'s details?`);
        if (confirmation) {
			// Call the update profile API function
			admin.updateProfileApiCall(updatedProfileId, updatedProfileName, updatedActiveStatus, updatedDescription);
        }
		
		document.getElementById("myModal").style.display = "none";
    });

    modalFeatures();
}

function displayUpdateUA(username, email, password, activeStatus, profile_id) {

    fetch(`AdminLanding.php?action=updateGetProfile`)
	.then(response => response.json())
    .then(profiles => {
        const Form = document.getElementById('modal-content');

        Form.style.display = 'block';

        // Create the select element for profiles
        const profileSelect = document.createElement('select');
        profileSelect.id = 'accountProfile_id';
        profileSelect.name = 'accountProfile_id';
        profileSelect.required = true;

        // Iterate over fetched profiles and create options
        profiles.forEach(profile => {
            const option = document.createElement('option');
            option.value = profile.id;
            option.textContent = profile.name;
			if (profile.id == profile_id){
				option.id = "selectProfile";
			}
            profileSelect.appendChild(option);
        });

        // Create other form elements
        Form.innerHTML = `
            <span class="close">&times;</span>
            <form id="UpForm">
			<br><label for="username">Username: </label>
			<input type="text" id="username" name="username" value="${username}" placeholder="Account Name" required><br>
			<br><label for="email">Email: </label>
			<input type="email" id="email" name="email" value="${email}" placeholder="Email" required><br>
			<br><label for="password">Password: </label>
			<input type="text" id="password" name="password" value="${password}" placeholder="Password" required><br>
			<br><label><input type="checkbox" id="activeStatus" name="activeStatus">Active Status</label><br>
			<br><label for="accountProfile_id">Profile:</label>
			${profileSelect.outerHTML}<br> <!-- Append profileSelect -->
			<br><button id="SubmitUpForm" type="submit">Submit</button><br>
            </form>
        `;

		const activeStatusCheckbox = document.getElementById('activeStatus');
		activeStatusCheckbox.checked = activeStatus == true;
		document.getElementById('selectProfile').selected = true;
		
		document.getElementById('UpForm').addEventListener('submit', function(event) {
			event.preventDefault();
			const updatedUsername = document.getElementById('username').value;
			const updatedEmail = document.getElementById('email').value;
			const updatedPassword = document.getElementById('password').value;
			const updatedActiveStatus = document.getElementById('activeStatus').checked;
			const updatedRole = document.getElementById('accountProfile_id').value;

			// If validation passes, proceed with confirmation popup
			const confirmation = confirm(`Are you sure you want to update ${username}'s details?`);
			if (confirmation) {
				// Call the update account API function
				admin.updateAccountApiCall(updatedUsername, updatedEmail, updatedPassword, updatedActiveStatus, updatedRole);
			}
			
			document.getElementById("myModal").style.display = "none";
		});

		modalFeatures();
    });
	
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

const admin = new AdminApi();

function initializeUP() {
    admin.fetchUserProfiles();

    document.getElementById('createProfile').addEventListener('click', displayCreateUP);
    document.getElementById('searchProfile').addEventListener('input', admin.searchEngineProfile);

}

function initializeUA() {
    admin.fetchUserAccounts();

    document.getElementById('createAccount').addEventListener('click', displayCreateUA);
    document.getElementById('searchAccount').addEventListener('input', admin.searchEngineAccount);
}


function loadContent(page) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("UPUA").innerHTML = this.responseText;
            if (page == 'AdminUP.php') {
                initializeUP();
            } else {
                initializeUA();
            }
        }
    };
    xhttp.open("GET", page, true);
    xhttp.send();
}
