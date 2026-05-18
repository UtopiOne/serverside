<?php
function factorial($n)
{
    if ($n < 0) return null;
    if ($n == 0) return 1;
    return $n * factorial($n - 1);
}

function isValid($expr)
{
    return preg_match('/^[0-9+\-*\/^().!a-z ]+$/', $expr);
}

function parseConstants($expr)
{
    $expr = str_replace("pi", pi(), $expr);
    $expr = str_replace("e", exp(1), $expr);
    return $expr;
}

function evalExpr($expr)
{
    $expr = parseConstants($expr);
    $expr = str_replace(" ", "", $expr);

    if (strlen($expr) > 0 && $expr[0] === '-') {
        $expr = '0' . $expr;
    }

    while (preg_match('/\(([^()]+)\)/', $expr, $matches)) {
        $result = evalExpr($matches[1]);
        $expr = str_replace($matches[0], $result, $expr);
    }

    if (preg_match('/sqrt(.+)/', $expr)) {
        return sqrt(evalExpr(substr($expr, 4)));
    }
    if (preg_match('/ln(.+)/', $expr)) {
        return log(evalExpr(substr($expr, 2)));
    }
    if (preg_match('/log(.+)/', $expr)) {
        return log10(evalExpr(substr($expr, 3)));
    }

    if (preg_match('/(\d+)!/', $expr, $matches)) {
        return factorial((int)$matches[1]);
    }

    if (preg_match('/(.+)\^(.+)/', $expr, $matches)) {
        return pow(evalExpr($matches[1]), evalExpr($matches[2]));
    }

    if (preg_match('/(\d+(?:\.\d+)?)([\+\-\*\/])(\d+(?:\.\d+)?)/', $expr, $matches)) {
        $a = (float)$matches[1];
        $op = $matches[2];
        $b = (float)$matches[3];

        switch ($op) {
            case '+':
                return $a + $b;
            case '-':
                return $a - $b;
            case '*':
                return $a * $b;
            case '/':
                return $b != 0 ? $a / $b : "Error: Division by zero";
        }
    }

    return floatval($expr);
}

$expr = $_GET['expression'] ?? '';
if (!isValid($expr)) {
    echo "Error: Invalid expression";
} else {
    echo evalExpr($expr);
}
