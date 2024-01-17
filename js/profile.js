document.addEventListener('DOMContentLoaded', function() {
  var isDJ = false

  if (isDJ) {
      document.getElementById('createRoom').style.display = 'block'
  } else {
      document.getElementById('enterRoom').style.display = 'block'
  }
})

function openSelectRoomModal() {
    document.getElementById('selectRoomModal').style.display = 'block'
}

function closeSelectRoomModal() {
    document.getElementById('selectRoomModal').style.display = 'none'
}

function openCreateRoomModal() {
    document.getElementById('createRoomModal').style.display = 'block'
}

function closeCreateRoomModal() {
    document.getElementById('createRoomModal').style.display = 'none'
}

function openEnterRoomModal() {
    document.getElementById('enterRoomModal').style.display = 'block'
}

function closeEnterRoomModal() {
    document.getElementById('enterRoomModal').style.display = 'none'
}

function openDeleteProfileModal() {
    document.getElementById('deleteProfileModal').style.display = 'block'
}

function closeDeleteProfileModal() {
    document.getElementById('deleteProfileModal').style.display = 'none'
}

function deleteProfile() {
    window.location.href = "account.php"
}

function back() {
  window.location.href = "account.php"
}