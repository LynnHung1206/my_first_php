<?php

function solution(string $input): string
{
    $words = preg_split('/\s+/', trim($input)); // use space to split

    $reversed = array_reverse($words);

    return implode(' ', $reversed); // just like java's concat
}

echo solution("this dog");
echo "\n";
echo solution("     this   dog ");
echo "\n";
