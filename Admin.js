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

function handleUpdateProfileClick(profileId, profileName, createPermission, readPermission, updatePermission, deletePermission) {
    const updateForm = document.getElementById('UpForm');
    
    // If form is already visible, hide it and clear its contents
    if (updateForm.style.display === 'block') {
        updateForm.style.display = 'none';
        updateForm.innerHTML = ''; // Clear the form contents
    } else {
        // Otherwise, show the form
        updateForm.style.display = 'block';
        
        updateForm.innerHTML = `
            <input type="hidden" id="updateProfileId" value="${profileId}">
            <br><input type="text" id="updateProfileName" name="updateProfileName" placeholder="Profile Name" value="${profileName}" required><br>
            <label>Permissions:</label><br>
            <label><input type="checkbox" id="updateCreatePermission" name="updateCreatePermission" ${createPermission ? 'checked' : ''}> Create</label><br>
            <label><input type="checkbox" id="updateReadPermission" name="updateReadPermission" ${readPermission ? 'checked' : ''}> Read</label><br>
            <label><input type="checkbox" id="updateUpdatePermission" name="updateUpdatePermission" ${updatePermission ? 'checked' : ''}> Update</label><br>
            <label><input type="checkbox" id="updateDeletePermission" name="updateDeletePermission" ${deletePermission ? 'checked' : ''}> Delete</label><br>
            <button type="submit">Update</button><br>
        `;
    }
}


document.getElementById('createProfile').addEventListener('click', handleCreateProfileClick);
document.getElementById('updateProfile').addEventListener('click', handleUpdateProfileClick);