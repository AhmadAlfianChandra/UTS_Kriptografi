<?php

function Encrypt($plainText, $key) {
    // Prepare input data
    $plainText = prepareText($plainText);
    $key = prepareText($key);
    
    // Generate key matrix
    $matrix = generateKeyMatrix($key);

    // Split input into pairs
    $pair = splitPairs($plainText);
    $ciphertext = "";

    // Encrypt each pair
    foreach ($pair as $pair) {
        $positions = getCharPositions($pair[0], $pair[1], $matrix);
        $encryptedPair = encryptPairs($positions, $matrix);
        $ciphertext .= $encryptedPair;
    }

    return $ciphertext;
}

function Decrypt($cipherText, $key) {
    // Prepare input data
    $cipherText = prepareText($cipherText);
    $key = prepareText($key);

    // Generate key matrix
    $matrix = generateKeyMatrix($key);

    // Split input into pairs
    $pair = splitPairs($cipherText);
    $plaintext = "";

    // Decrypt each pair
    foreach ($pair as $pairs) {
        $positions = getCharPositions($pairs[0], $pairs[1], $matrix);
        $decryptedPair = decryptPairs($positions, $matrix);
        $plaintext .= $decryptedPair;
    }

    return $plaintext;
}

function prepareText($text) {
    // Remove non-alphabetic characters and convert to lowercase
    return preg_replace("/[^a-z]/", "", strtolower($text));
}

function generateKeyMatrix($key) {
    // Implement logic to generate a 5x5 matrix based on the key
    // Return the matrix
    // ...
}

function splitPairs($text) {
    // Implement logic to split text into pairs
    // Return an array of pairs
    // ...
}

function getCharPositions($char1, $char2, $matrix) {
    // Implement logic to find positions of characters in the matrix
    // Return positions as an array
    // ...
}

function encryptPairs($positions, $matrix) {
    // Implement logic to encrypt pairs based on their positions in the matrix
    // Return encrypted pair
    // ...
}

function decryptPairs($positions, $matrix) {
    // Implement logic to decrypt pairs based on their positions in the matrix
    // Return decrypted pair
    // ...
}

// Example usage:
//$plainText = "DHIMAS ADITYA";
//$key = "KEY";

//$cipherText = Encrypt($plainText, $key);
//echo "Encrypted: $cipherText\n";

//$decryptedText = Decrypt($cipherText, $key);
//echo "Decrypted: $decryptedText\n";
?>
