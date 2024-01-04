document.addEventListener('DOMContentLoaded', function() {
    var isDJ = true

    if (isDJ) {
        document.getElementById('dj').style.display = 'block'
    } else {
        document.getElementById('user').style.display = 'block'
    }
})

function openDeleteRoomModal() {
  document.getElementById('deleteRoomModal').style.display = 'block'
}

function closeDeleteRoomModal() {
    document.getElementById('deleteRoomModal').style.display = 'none'
}

function deleteRoom() {
    window.location.href = "../html/profile.html"
}

function back() {
    window.location.href = "../html/profile.html"
}