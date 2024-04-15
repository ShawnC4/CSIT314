/*
// JavaScript code to handle login functionality
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    console.log(username);
    // Call login API endpoint
    login(username, password);
});

function login(username, password) {
    console.log(username);
    fetch('UserController.php?action=login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
    })
    .then(response => response.json())
    .then(data => {
        if (data['success'] == true) {
            // Redirect or show success message
            window.location.href = 'landing.php'; // Redirect to dashboard on successful login
        } else {
            document.getElementById('loginMessage').textContent = 'Invalid username or password';
        }
    })
    .catch(error => console.error('Error logging in:', error));
}

*/

class Login {
    constructor() {
        // Bind event listener to the login form
        document.getElementById('loginForm').addEventListener('submit', this.handleLogin.bind(this));
    }

    handleLogin(event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        console.log(username);
        // Call login API endpoint
        this.apiCall(username, password);
    }

    apiCall(username, password) {
        console.log(username);
        fetch('UserController.php?action=login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password })
        })
        .then(response => response.json())
        .then(data => {
            if (data['success'] == true) {
                // Redirect or show success message
                window.location.href = 'landing.php'; // Redirect to dashboard on successful login
            } else {
                document.getElementById('loginMessage').textContent = 'Invalid username or password';
            }
        })
        .catch(error => console.error('Error logging in:', error));
    }
}

// Instantiate LoginManager
const login = new Login();
