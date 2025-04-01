<?php

function solution(array &$input): void {
    $index = 0; // to put not 0 number
    for ($i = 0; $i < count($input); $i++) {
        if ($input[$i] !== 0) {
            if ($i !== $index) {
                $temp = $input[$index];   // store $input[$index] value in $temp
                $input[$index] = $input[$i];  // put $input[$i] into $index
                $input[$i] = $temp;   // put $temp into $i
            }
            $index++;
        }
    }
}

$input = [0, 0, 0, 2, 0, 1, 3, 4, 0, 0];
solution($input);
print_r($input);
