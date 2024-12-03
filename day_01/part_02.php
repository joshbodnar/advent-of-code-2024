<?php declare(strict_types=1);

$contents = file(__DIR__ . '/input.txt');
if (!$contents) {
    die("Could not open problem file");
}
$left = [];
$right = [];

foreach ($contents as $line) {
    $parts = explode('   ', $line);
    $left[] = (int) trim($parts[0]);

    $rightNum = (int)trim($parts[1]);
    if (!array_key_exists($rightNum, $right)) {
        $right[$rightNum] = 1;
        continue;
    }
    $right[$rightNum] += 1;
}

$counter = 0;
foreach ($left as $leftVal) {
    $rightCount = array_key_exists($leftVal, $right) ? $right[$leftVal] : 0;
    $counter += $leftVal * $rightCount;
}

echo $counter . "\n";