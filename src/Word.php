<?php

namespace Totara;

use Totara\Exception\InvalidParameterException;

class Word
{
    const LINE_SPACE = ' ';

    /**
     * @param string $string
     * @param string $length
     * @throws InvalidParameterException
     * @return string
     */
    public function wrap($string, $length)
    {
        if (!is_int($length) || $length <= 0) {
            throw new InvalidParameterException("Invalid length parameter");
        }

        if ($this->isLengthNotExceed($string, $length)) {
            return $string;
        }

        $wrapText = '';
        $pointer = 0;
        $words = preg_split('@[\s+　]@u', $string);
        $numberOfWords = count($words);

        foreach ($words as $index=>$word) {
            $wordWidth = $this->getStringLength($word);

            if ($this->isWordExceedLineMaxLength($wordWidth, $length)) {
                for ($i = 0; $i < strlen($word); $i++) {
                    $wordLength = $this->getStringLength(substr($word, $i, 1));
                    if ($this->isLineNotFilled($pointer, $wordLength, $length)) {
                        $pointer += $wordLength;
                        $wrapText .= substr($word, $i, 1);
                    } else {
                        $pointer = $wordLength;
                        $wrapText = $wrapText . "\n" . substr($word, $i, 1);
                    }

                }
            } else {
                $wordLength = $wordWidth + $this->getStringLength(self::LINE_SPACE);

                if ($this->isLineNotFilled($pointer, $wordLength, $length)) {
                    $pointer += $wordLength;
                    $wrapText .= $word ;
                } else {
                    if (!$this->isSpace($word)) {
                        $pointer = $wordLength;
                        $wrapText = trim($wrapText) . "\n" . $word ;
                    }
                }
            }
            if($index+1 != $numberOfWords){
                $wrapText .= self::LINE_SPACE;
            }

        }

        return $wrapText;
    }

    private function isLengthNotExceed($string, $wrapLength)
    {
        return (strlen($string) <= $wrapLength);
    }

    private function isWordExceedLineMaxLength($wordWidth, $wrapLength)
    {
        return ($wordWidth > $wrapLength);
    }

    private function isLineNotFilled($lineWidth, $wordLength, $wrapLength)
    {
        return $lineWidth + $wordLength <= $wrapLength;
    }

    private function getStringLength($string)
    {
        return strlen(utf8_decode($string));
    }

    private function isSpace($word)
    {
        return empty($word);
    }

} 
