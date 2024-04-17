class LoginApi {
    constructor() {
        // Bind event listener to the login form
        document.getElementById('loginForm').addEventListener('submit', this.handleLogin.bind(this));

        this.fetchUserProfiles();
    }

    handleLogin(event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const profile = document.getElementById('profile').value;

        this.apiCall(username, password, profile);
    }

    apiCall(username, password, profile) {
        fetch('LoginController.php?action=login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password, profile })
        })
        .then(response => response.json())
        .then(data => {
            if (data['success'] == true) {
                switch (profile) {
                    case 'buyer':
                        window.location.href = 'BuyerLanding.php';
                        break;
                    case 'seller':
                        window.location.href = 'SellerLanding.php';
                        break;
                    case 'agent':
                        window.location.href = 'AgentLanding.php';
                        break;
                    case 'admin':
                        window.location.href = 'AdminLanding.php';
                        break;
                    default:
                        window.location.href = 'logout.php';
                        break;
                }
            } else {
                document.getElementById('loginMessage').textContent = 'Invalid username or password';
            }
        })
        .catch(error => console.error('Error logging in:', error));
    }

    fetchUserProfiles() {
        fetch('LoginController.php?action=getProfiles')
        .then(response => response.json())
        .then(profiles => {
            console.log(profiles);
            const profileSelect = document.getElementById('profile');
            profileSelect.innerHTML = '';
            profiles.forEach(profile => {
                const option = document.createElement('option');
                option.value = profile.id.toLowerCase();
                option.textContent = profile.id;
                profileSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching user profiles:', error));
    }
}

// Instantiate LoginManager
const login = new LoginApi();
