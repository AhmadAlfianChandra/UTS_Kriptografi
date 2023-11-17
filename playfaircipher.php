<?php

function findCharIndex($char, $matrix)
{
    $index = array();

    foreach ($matrix as $rowKey => $row) {
        foreach ($row as $colKey => $col) {
            if ($char == $col) {
                $index['row'] = $rowKey;
                $index['col'] = $colKey;
                return $index;
            }
        }
    }

    return $index;
}

function generatePlayfairMatrix($key)
{
    $key = strtoupper($key);
    $key = str_replace('J', 'I', $key);

    $keyArray = str_split($key);
    $alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
    $matrix = array();

    $keyIndex = 0;

    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            if (isset($keyArray[$keyIndex])) {
                $matrix[$i][$j] = $keyArray[$keyIndex];
                $keyIndex++;
            } else {
                while (in_array($alphabet[0], $matrix) || in_array($alphabet[0], $keyArray)) {
                    $alphabet = substr($alphabet, 1);
                }
                $matrix[$i][$j] = $alphabet[0];
                $alphabet = substr($alphabet, 1);
            }
        }
    }

    return $matrix;
}

function playfairEncrypt($plaintext, $key)
{
    $matrix = generatePlayfairMatrix($key);
    $plaintext = str_replace('J', 'I', strtoupper($plaintext));
    $plaintext = str_split(preg_replace("/[^A-Z]/", "", $plaintext));

    $ciphertext = '';

    for ($i = 0; $i < count($plaintext); $i += 2) {
        $char1 = $plaintext[$i];
        $char2 = isset($plaintext[$i + 1]) ? $plaintext[$i + 1] : 'X';

        $index1 = findCharIndex($char1, $matrix);
        $index2 = findCharIndex($char2, $matrix);

        if ($index1['row'] == $index2['row']) {
            $ciphertext .= $matrix[$index1['row']][($index1['col'] + 1) % 5];
            $ciphertext .= $matrix[$index2['row']][($index2['col'] + 1) % 5];
        } elseif ($index1['col'] == $index2['col']) {
            $ciphertext .= $matrix[($index1['row'] + 1) % 5][$index1['col']];
            $ciphertext .= $matrix[($index2['row'] + 1) % 5][$index2['col']];
        } else {
            $ciphertext .= $matrix[$index1['row']][$index2['col']];
            $ciphertext .= $matrix[$index2['row']][$index1['col']];
        }
    }

    return $ciphertext;
}

function playfairDecrypt($ciphertext, $key)
{
    $matrix = generatePlayfairMatrix($key);
    $ciphertext = str_replace('J', 'I', strtoupper($ciphertext));
    $ciphertext = str_split(preg_replace("/[^A-Z]/", "", $ciphertext));

    $plaintext = '';

    for ($i = 0; $i < count($ciphertext); $i += 2) {
        $char1 = $ciphertext[$i];
        $char2 = isset($ciphertext[$i + 1]) ? $ciphertext[$i + 1] : 'X';

        $index1 = findCharIndex($char1, $matrix);
        $index2 = findCharIndex($char2, $matrix);

        if ($index1['row'] == $index2['row']) {
            $plaintext .= $matrix[$index1['row']][($index1['col'] - 1 + 5) % 5];
            $plaintext .= $matrix[$index2['row']][($index2['col'] - 1 + 5) % 5];
        } elseif ($index1['col'] == $index2['col']) {
            $plaintext .= $matrix[($index1['row'] - 1 + 5) % 5][$index1['col']];
            $plaintext .= $matrix[($index2['row'] - 1 + 5) % 5][$index2['col']];
        } else {
            $plaintext .= $matrix[$index1['row']][$index2['col']];
            $plaintext .= $matrix[$index2['row']][$index1['col']];
        }
    }

    return $plaintext;
}

// Contoh penggunaan:
$key = "KEYWORD";
$plaintext = "HELLO";

$encryptedText = playfairEncrypt($plaintext, $key);
echo "Encrypted Text: $encryptedText\n";

$decryptedText = playfairDecrypt($encryptedText, $key);
echo "Decrypted Text: $decryptedText\n";

?>
