<?php
$equation = "22 * x = 220";

$trimmed_array = array_map('trim', explode('=', $equation));
[$lhs, $rhs] = $trimmed_array;
$result = (float)trim($rhs);

preg_match('/^(.+?)\s*([\+\-\*\/])\s*(.+)$/', trim($lhs), $matches);
$operand1 = trim($matches[1]);
$operator  = trim($matches[2]);
$operand2 = trim($matches[3]);

if ($operand1 === 'x') {
    $position = 'left';
    $known = (float)$operand2;
} else {
    $position = 'right';
    $known = (float)$operand1;
}

switch ($operator) {
    case '+':
        $x = $result - $known;
        break;
    case '-':
        $x = ($position === 'left') ? $result + $known : $known - $result;
        break;
    case '*':
        $x = $result / $known;
        break;
    case '/':
        $x = ($position === 'left') ? $result * $known : $known / $result;
        break;
    default:
        die("Unsupported operator: $operator\n");
}

echo "Equation : $equation" . "<br>";
echo "Operator : $operator" . "<br>";
echo "x position: $position operand" . "<br>";
echo "x = $x" . "<br>";
?>

<img src="./lab3.drawio.png" alt="Equation Diagram">