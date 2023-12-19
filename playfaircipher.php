<?php

function generateKeySquare($key) {
    $key = str_replace("J", "I", strtoupper($key));
    $keySquare = array();
    $alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ";

    $key = str_split($key);
    $key = array_unique($key);

    $key = array_merge($key, str_split($alphabet));

    $key = array_unique($key);

    $index = 0;
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            $keySquare[$i][$j] = $ke   [$index] ?? ''; // Tambahkan operator null coalescing untuk mengatasi undefined array key
            $index++;
        }
    }

    return $keySquare;
}

function getCharPosition($keySquare, $char) {
    $charPosition = array('row' => -1, 'col' => -1); // Inisialisasi nilai default jika karakter tidak ditemukan

    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            if ($keySquare[$i][$j] == $char) {
                $charPosition['row'] = $i;
                $charPosition['col'] = $j;
                return $charPosition;
            }
        }
    }

    return $charPosition; // Mengembalikan nilai default jika karakter tidak ditemukan
}

function encrypt($plaintext, $key) {
    $keySquare = generateKeySquare($key);
    $ciphertext = "";
    $plaintext = str_replace("J", "I", strtoupper($plaintext));
    $plaintext = str_split($plaintext);

    // Tambahkan karakter 'X' jika jumlah karakter ganjil
    if (count($plaintext) % 2 != 0) {
        $plaintext[] = 'X';
    }

    for ($i = 0; $i < count($plaintext); $i += 2) {
        $char1 = $plaintext[$i];
        $char2 = $plaintext[$i + 1];

        $pos1 = getCharPosition($keySquare, $char1);
        $pos2 = getCharPosition($keySquare, $char2);

        if ($pos1['row'] == -1 || $pos2['row'] == -1) {
            // Tambahkan penanganan jika karakter tidak ditemukan
            // Anda dapat memilih untuk mengabaikan karakter yang tidak ditemukan atau menangani situasi ini sesuai kebutuhan
            continue;
        }

        if ($pos1['row'] == $pos2['row']) {
            $ciphertext .= $keySquare[$pos1['row']][($pos1['col'] + 1) % 5];
            $ciphertext .= $keySquare[$pos2['row']][($pos2['col'] + 1) % 5];
        } elseif ($pos1['col'] == $pos2['col']) {
            $ciphertext .= $keySquare[($pos1['row'] + 1) % 5][$pos1['col']];
            $ciphertext .= $keySquare[($pos2['row'] + 1) % 5][$pos2['col']];
        } else {
            $ciphertext .= $keySquare[$pos1['row']][$pos2['col']];
            $ciphertext .= $keySquare[$pos2['row']][$pos1['col']];
        }
    }

    return $ciphertext;
}

function decrypt($ciphertext, $key) {
    $keySquare = generateKeySquare($key);
    $plaintext = "";
    $ciphertext = str_split($ciphertext);

    // Tambahkan karakter 'X' jika jumlah karakter ganjil
    if (count($ciphertext) % 2 != 0) {
        $ciphertext[] = 'X';
    }

    for ($i = 0; $i < count($ciphertext); $i += 2) {
        $char1 = $ciphertext[$i];
        $char2 = $ciphertext[$i + 1];

        $pos1 = getCharPosition($keySquare, $char1);
        $pos2 = getCharPosition($keySquare, $char2);

        if ($pos1['row'] == -1 || $pos2['row'] == -1) {
            // Tambahkan penanganan jika karakter tidak ditemukan
            // Anda dapat memilih untuk mengabaikan karakter yang tidak ditemukan atau menangani situasi ini sesuai kebutuhan
            continue;
        }

        if ($pos1['row'] == $pos2['row']) {
            $plaintext .= $keySquare[$pos1['row']][($pos1['col'] - 1 + 5) % 5];
            $plaintext .= $keySquare[$pos2['row']][($pos2['col'] - 1 + 5) % 5];
        } elseif ($pos1['col'] == $pos2['col']) {
            $plaintext .= $keySquare[($pos1['row'] - 1 + 5) % 5][$pos1['col']];
            $plaintext .= $keySquare[($pos2['row'] - 1 + 5) % 5][$pos2['col']];
        } else {
            $plaintext .= $keySquare[$pos1['row']][$pos2['col']];
            $plaintext .= $keySquare[$pos2['row']][$pos1['col']];
        }
    }

    return $plaintext;
}

/* Contoh penggunaan
$plaintext = "HELLO";
$key = "KEYWORD";

echo "Plaintext: " . $plaintext . "\n";
echo "Key: " . $key . "\n";

$ciphertext = encrypt($plaintext, $key);
echo "Ciphertext: " . $ciphertext . "\n";

$decryptedText = decrypt($ciphertext, $key);
echo "Decrypted Text: " . $decryptedText . "\n";
*/
?>
