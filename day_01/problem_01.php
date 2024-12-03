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
    $right[] = (int) trim($parts[1]);
}

sort($left);
sort($right);


$counter = 0;
foreach ($left as $key => $leftVal) {
    $rightVal = $right[$key];
    if ($rightVal > $leftVal) {
        $counter += $rightVal - $leftVal;
        continue;
    }

   $counter += $leftVal - $rightVal;
}

echo $counter . "\n";