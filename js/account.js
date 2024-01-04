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
    window.location.href = "../html/login.html"
}