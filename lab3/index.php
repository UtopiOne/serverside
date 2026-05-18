<?php
$equation = "22 * x = 220";

[$lhs, $rhs] = array_map('trim', explode('=', $equation));
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

echo "Equation : $equation\n";
echo "Operator : $operator\n";
echo "x position: $position operand\n";
echo "x = $x\n";
