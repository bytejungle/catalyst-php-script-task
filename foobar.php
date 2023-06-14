<?php

    $output = [];

    for ($i = 0; $i < 100; $i++) {

        $number = $i+1;

        // what the numbers are divisible by
        $is_divisible_by_three = $number % 3 === 0;
        $is_divisible_by_five = $number % 5 === 0;

        // Where the number is divisible by three (3) output the word “foo”
        if ($is_divisible_by_three) {
            $output[] = "foo";
            continue;
        }

        // Where the number is divisible by five (5) output the word “bar”
        if ($is_divisible_by_five) {
            $output[] = "bar";
            continue;
        }

        // Where the number is divisible by three (3) and (5) output the word “foobar”
        if ($is_divisible_by_three && $is_divisible_by_five) {
            $output[] = "foobar";
            continue;
        }

        $output[] = $number;
    }

    // add delimiters
    echo implode(", ", $output);