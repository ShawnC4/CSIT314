function handleCreateProfileClick() {
    const upForm = document.getElementById('UpForm');
    
    // If form is already visible, hide it and clear its contents
    if (upForm.style.display === 'block') {
        upForm.style.display = 'none';
        upForm.innerHTML = ''; // Clear the form contents
    } else {
        // Otherwise, show the form
        upForm.style.display = 'block';
        
        upForm.innerHTML = `
            <br><input type="text" id="profileName" name="profileName" placeholder="Profile Name" required><br>
            <label><input type="checkbox" id="activeStatus" name="activeStatus">Active Status</label><br>
            <input type="text" id="description" name="description" placeholder="Description"><br>
            <button type="submit">Submit</button><br>
        `;
    }
}

document.getElementById('createProfile').addEventListener('click', handleCreateProfileClick);