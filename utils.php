<?php
function generateRandomString($length=8) {
  return bin2hex(random_bytes($length / 2));
}

function generateUniqueCode($conn) {
    do {
        $code = generateRandomString();
        $result = $conn->query(
            "SELECT * FROM rooms WHERE code = '$code'"
        )->fetch_assoc();
        if($result == NULL){
            break;
        }
    } while ($result->num_rows > 0);
    return $code;
}

function validateInput($conn,$string,$limit=30) {
    return substr(
        htmlspecialchars(
            preg_replace('/([^\x20-\x7E]|&)/', '', $conn->real_escape_string($string)),
            ENT_QUOTES,
            'UTF-8'
        ),
        0,
        $limit
    );
}

function noAND($string) {
    return preg_replace('/&/', '', $string);
}

function getUser($conn) {
    if (isset($_COOKIE['login'])) {
        $cookie = $conn->real_escape_string($_COOKIE['login']);
        $result = $conn->query(
            "SELECT username,expiration_date FROM users WHERE cookie = '$cookie' LIMIT 1"
        );
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            if (strtotime($row['expiration_date']) > time()) {
                return $row['username'];
            }
        }
    }
    return NULL;
}
?>