<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Examples Page</title>
</head>
<body>
<?php
# Task #1
$a = 10;
$b = 20;
echo "Task 1: a = $a, b = $b <br>";

# Task #2
$c = $a + $b;
echo "Task 2: c = $c <br>";

# Task 3
$c *= 3;
echo "Task 3: $c <br>";

# Task 4
$c /= $b - $a;
echo "Task 4: $c <br>";

# Task 5
$p = 'Програма';
$b = 'працює';
echo "Task 5: p = $p; b = $b <br>";

# Task 6
$result = $p . ' ' . $b;
echo "Task 6: result = $result <br>";

# Task 7
$result .= ' добре';
echo "Task 7: result = $result <br>";

# Task 8
$q = 5;
$w = 7;

$q += $w;
$w = $q - $w;
$q -= $w;

echo "Task 8: q = $q; w = $w <br>";
?>
</body>
</html>