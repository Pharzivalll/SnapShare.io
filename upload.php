<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $allowedExtensions = ["jpg", "jpeg", "png", "pdf", "txt"]; // Add more if needed
    $maxFileSizeMB = 10; // Maximum file size in megabytes

    $file = $_FILES["file"];

    $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);

    if (in_array(strtolower($fileExtension), $allowedExtensions) &&
        $file["size"] <= $maxFileSizeMB * 1024 * 1024) {

        $secureCode = bin2hex(random_bytes(8));

        // Move the uploaded file to a secure location
        $uploadDir = "E:/Test Website/uploadss/";
        $uploadPath = $uploadDir . $secureCode . "." . $fileExtension;

        move_uploaded_file($file["tmp_name"], $uploadPath);

        // Store the secure code and file information in a mapping file
        $mappingFile = 'secure_codes.txt';
        file_put_contents($mappingFile, "$secureCode|$uploadPath\n", FILE_APPEND);

        echo "Secure Code: " . $secureCode;
    } else {
        echo "Invalid file or file size exceeded.";
    }
}
?>
