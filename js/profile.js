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
    //  window.location.href = "account.php"
    fetch('profile.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'profilename': document.title
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data)
    })
    .catch((error) => {
        console.error('Error:', error)
    });
}

function back() {
  window.location.href = "account.php"
}