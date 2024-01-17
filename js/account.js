function openSelectProfileModal() {
    document.getElementById('selectProfileModal').style.display = 'block'
}

function closeSelectProfileModal() {
    document.getElementById('selectProfileModal').style.display = 'none'
}

function openCreateProfileModal() {
    document.getElementById('createProfileModal').style.display = 'block'
}

function closeCreateProfileModal() {
    document.getElementById('createProfileModal').style.display = 'none'
}

function logout() {
    window.location.href = "/";
}

function gotoProfile(profile){
    console.log(profile)
    // fetch('account.php', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'profilename': ''
    //     }
    // })
    // .then(response => response.json())
    // .then(data => {
    //     console.log('Success:', data);
    // })
    // .catch((error) => {
    //     console.error('Error:', error);
    // });
}
