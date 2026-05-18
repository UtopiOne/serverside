<?php
$a = 27;
$b = 12;
$c = sqrt($a * $a - $b * $b);

$angle1 = atan($b / $a) * 180 / pi();
$angle2 = atan($c / $b) * 180 / pi();
$angle3 = 180 - $angle1 - $angle2;

echo round($angle1, 2) . "°<br>";
echo round($angle2, 2) . "°<br>";
echo round($angle3, 2) . "°<br>";
