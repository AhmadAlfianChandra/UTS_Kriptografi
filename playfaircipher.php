<?php

class PlayfairCipher
{
    private $keyMatrix = array();
    private $key = '';

    public function setKey($key)
    {
        $this->key = strtoupper($key);
        $this->generateKeyMatrix();
    }

    private function generateKeyMatrix()
    {
        $key = $this->removeDuplicateChars($this->key . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $keyLength = strlen($key);

        $this->keyMatrix = array();
        $index = 0;

        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $this->keyMatrix[$i][$j] = $key[$index++];
            }
        }
    }

    private function removeDuplicateChars($str)
    {
        $result = '';
        for ($i = 0; $i < strlen($str); $i++) {
            if (strpos($result, $str[$i]) === false) {
                $result .= $str[$i];
            }
        }
        return $result;
    }

    public function encrypt($plaintext)
    {
        $plaintext = strtoupper($this->prepareText($plaintext));
        $ciphertext = '';

        for ($i = 0; $i < strlen($plaintext); $i += 2) {
            $char1 = $plaintext[$i];
            $char2 = $plaintext[$i + 1];
            list($row1, $col1) = $this->getCharPosition($char1);
            list($row2, $col2) = $this->getCharPosition($char2);

            if ($row1 == $row2) {
                $ciphertext .= $this->keyMatrix[$row1][($col1 + 1) % 5];
                $ciphertext .= $this->keyMatrix[$row2][($col2 + 1) % 5];
            } elseif ($col1 == $col2) {
                $ciphertext .= $this->keyMatrix[($row1 + 1) % 5][$col1];
                $ciphertext .= $this->keyMatrix[($row2 + 1) % 5][$col2];
            } else {
                $ciphertext .= $this->keyMatrix[$row1][$col2];
                $ciphertext .= $this->keyMatrix[$row2][$col1];
            }
        }

        return $ciphertext;
    }

    public function decrypt($ciphertext)
    {
        $ciphertext = strtoupper($this->prepareText($ciphertext));
        $plaintext = '';

        for ($i = 0; $i < strlen($ciphertext); $i += 2) {
            $char1 = $ciphertext[$i];
            $char2 = $ciphertext[$i + 1];
            list($row1, $col1) = $this->getCharPosition($char1);
            list($row2, $col2) = $this->getCharPosition($char2);

            if ($row1 == $row2) {
                $plaintext .= $this->keyMatrix[$row1][($col1 - 1 + 5) % 5];
                $plaintext .= $this->keyMatrix[$row2][($col2 - 1 + 5) % 5];
            } elseif ($col1 == $col2) {
                $plaintext .= $this->keyMatrix[($row1 - 1 + 5) % 5][$col1];
                $plaintext .= $this->keyMatrix[($row2 - 1 + 5) % 5][$col2];
            } else {
                $plaintext .= $this->keyMatrix[$row1][$col2];
                $plaintext .= $this->keyMatrix[$row2][$col1];
            }
        }

        return $plaintext;
    }

    private function prepareText($text)
    {
        $text = strtoupper(preg_replace("/[^A-Z]/", '', $text));
        $text = str_replace('J', 'I', $text);
        return $text;
    }

    private function getCharPosition($char)
    {
        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($this->keyMatrix[$i][$j] == $char) {
                    return array($i, $j);
                }
            }
        }
        return array();
    }
}

// Contoh penggunaan
//$playfairCipher = new PlayfairCipher();
//$key = 'KEYWORD';
//$playfairCipher->setKey($key);

//$plaintext = 'HELLO';
//echo "Plaintext: $plaintext\n";

//$ciphertext = $playfairCipher->encrypt($plaintext);
//echo "Encrypted: $ciphertext\n";

//$decryptedText = $playfairCipher->decrypt($ciphertext);
//echo "Decrypted: $decryptedText\n";
?>
