<?php declare(strict_types=1);

$contents = file(__DIR__ . '/input.txt');
if (!$contents) {
    die("Could not open problem file");
}

$lines = [];
foreach ($contents as $lineNum => $line) {
    $parts = explode(' ', $line);
    foreach ($parts as $columnNum => $part) {
        $lines[$lineNum][$columnNum] = (int) trim($part);
    }
}

// ensure numbers are no more than 1 to 3 numbers apart
// and either in ascending or descending order
// return 1 if valid, 0 when invalid
function checkNumbers(array $nums): int
{
    $minDistance = 1;
    $maxDistance = 3;
    $asc = 'asc';
    $desc = 'desc';
    $order = '';

    foreach ($nums as $key => $num) {
        if ($key === 0) {
            continue;
        }

        $previousNum = $nums[$key - 1];
        $currentOrder = $previousNum > $num ? $desc : $asc;

        // initialize order
        if (empty($order)) {
            $order = $currentOrder;
        }

        // failing order constraints
        if ($order !== $currentOrder) {
            return 0;
        }

        // get the difference between last iteration and this iteration based on order
        $diff = $order === $desc ? $previousNum - $num : $num - $previousNum;

        // failing diff constraint
        if ($diff > $maxDistance || $diff < $minDistance) {
            return 0;
        }
    }

    return 1;
}

$count = 0;
foreach ($lines as $lineNum => $line) {
    $count += checkNumbers($line);
}

echo $count . "\n";
