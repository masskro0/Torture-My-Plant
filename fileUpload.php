<?php
// Allow only JPEG format
$verifyimg = getimagesize($_FILES['image']['tmp_name']);
if($verifyimg['mime'] != 'image/jpeg') {
    echo "Only JPEG images are allowed!";
    exit;
}
// Choose directory
$uploaddir = '/home/michael/Schreibtisch/new/';

$uploadfile = $uploaddir . basename($_FILES['image']['name']);

if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
    echo "Image succesfully uploaded.";
} else {
    echo "Image uploading failed.";
}
?> 