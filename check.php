
<?php
echo(round(1.4569875,0,PHP_ROUND_HALF_UP) . "<br>");
echo(round(-1.5,0,PHP_ROUND_HALF_UP) . "<br>");

echo(round(1.5,0,PHP_ROUND_HALF_DOWN) . "<br>");
echo(round(-1.5,0,PHP_ROUND_HALF_DOWN) . "<br>");

echo(round(1.5,0,PHP_ROUND_HALF_EVEN) . "<br>");
echo(round(-1.5,0,PHP_ROUND_HALF_EVEN) . "<br>");

echo(round(1.5,0,PHP_ROUND_HALF_ODD) . "<br>");
echo(round(-1.5,0,PHP_ROUND_HALF_ODD));
?>