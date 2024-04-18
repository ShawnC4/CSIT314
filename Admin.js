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
            <label>Permissions:</label><br>
            <label><input type="checkbox" id="createPermission" name="createPermission"> Create</label><br>
            <label><input type="checkbox" id="readPermission" name="readPermission"> Read</label><br>
            <label><input type="checkbox" id="updatePermission" name="updatePermission"> Update</label><br>
            <label><input type="checkbox" id="deletePermission" name="deletePermission"> Delete</label><br>
            <button type="submit">Submit</button><br>
        `;
    }
}

document.getElementById('createProfile').addEventListener('click', handleCreateProfileClick);