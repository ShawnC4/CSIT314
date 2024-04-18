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

function CreateModal () {

    document.getElementById('SubmitUpForm').addEventListener('click', () => {
        modal.style.display = "none";
    });
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("createProfile");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
    modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    
}

document.getElementById('createProfile').addEventListener('click', CreateModal);


