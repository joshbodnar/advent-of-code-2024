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
// returns first key that failed (for possible retry), otherwise null
function checkLine(array $nums): int|bool
{
    $minDistance = 1;
    $maxDistance = 3;
    $asc = 'asc';
    $desc = 'desc';
    $order = '';

    for ($i = 1; $i < count($nums); $i++) {
        $key = $i;
        $num = $nums[$i];

        $previousNum = $nums[$key - 1];
        $currentOrder = $previousNum > $num ? $desc : $asc;

        // initialize order
        if ($i === 1) {
            $order = $currentOrder;
        }

        // failing order constraints
        if ($order !== $currentOrder) {
            return $key;
        }

        // get the difference between last iteration and this iteration based on order
        $diff = $order === $desc ? $previousNum - $num : $num - $previousNum;

        // failing diff constraint
        if ($diff > $maxDistance) {
            return false;
        }

        // failing diff constraint
        if ($diff < $minDistance) {
            return $key;
        }
    }

    return true;
}

$count = 0;
foreach ($lines as $lineNum => $currentLine) {
    // initial test, happy path
    $failedKey = checkLine($currentLine);
    if (false === $failedKey) {
        continue;
    }

    if (true === $failedKey) {
        $count++;
        continue;
    }

    // eliminate the bad apple
    unset($currentLine[$failedKey]);
    $failedKey = checkLine(array_values($currentLine));

    // retest, add to count if passes
    if (false === $failedKey) {
        continue;
    }

    if (true === $failedKey) {
        $count++;
    }
}

echo $count . "\n";
