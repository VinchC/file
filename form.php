<?php



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $uploadDir = 'public/uploads/';

    $prefix = uniqid("", false);

    $uploadFile = $uploadDir . basename($prefix . "." . $_FILES['avatar']['name']);

    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

    $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];

    $maxFileSize = 1000000;

    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type .jpg, .png, .gif ou .webp !';
    }

    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 1M !";
    }

    if (empty($errors)) {
        move_uploaded_file(($_FILES['avatar']['tmp_name']), $uploadFile);
    }
}

if (!empty($errors)) {
    foreach ($errors as $error) : ?>
        <ul>
            <li><?= $error; ?></li>
        </ul>
<?php endforeach;
}
?>

<form method="post" enctype="multipart/form-data">
    <label for="imageUpload">Upload an profile image</label>
    <input type="file" name="avatar" id="imageUpload" />
    <button name="send">Send</button>
</form>

<?php
if (isset($uploadFile) && file_exists($uploadFile)) : ?>
    <div>
        <img src="<?= $uploadFile; ?>">
    </div>
<?php endif;
