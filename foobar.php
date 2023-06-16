<?php

    $output = [];

    for ($i = 1; $i <= 100; $i++) {

        // what the numbers are divisible by
        $is_divisible_by_three = $i % 3 === 0;
        $is_divisible_by_five = $i % 5 === 0;

        // Where the number is divisible by three (3) and (5) output the word “foobar”
        if ($is_divisible_by_three && $is_divisible_by_five) {
            $output[] = "foobar";
            continue;
        }

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

        $output[] = $i;
    }

    // add delimiters
    echo implode(", ", $output);