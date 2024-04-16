class Login {
    constructor() {
        // Bind event listener to the login form
        document.getElementById('loginForm').addEventListener('submit', this.handleLogin.bind(this));
    }

    handleLogin(event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const profile = document.getElementById('profile').value;
        // Call login API endpoint
        this.apiCall(username, password, profile);
    }

    apiCall(username, password, profile) {
        fetch('UserController.php?action=login', {
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
}

// Instantiate LoginManager
const login = new Login();
