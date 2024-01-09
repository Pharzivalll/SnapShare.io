<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["code"])) {
    $code = $_GET["code"];

    // Read the mapping file to find the corresponding file path
    $mappingFile = 'secure_codes.txt';
    $mappingLines = file($mappingFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($mappingLines as $line) {
        list($secureCode, $filePath) = explode('|', $line);

        if ($secureCode === $code) {
            // Found the matching file, send it to the browser
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filePath));
            readfile($filePath);
            exit;
        }
    }

    // Code not found, handle appropriately (e.g., show an error message)
    echo "Error: File not found for the given code.";
} else {
    // Invalid request, handle appropriately (e.g., show an error message)
    echo "Error: Invalid request.";
}
?>
