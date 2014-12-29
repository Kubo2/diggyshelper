<?php 

/**
 * Before include()ing this one, there MUST be sent a "503 Service unavailable" status header.
 *
 * @internal
 * @subpackage Application Includes
 * @version  1.0.0
 *
 * @author   Kubo2
 */
@ header('HTTP/1.1 503 Service Unvailable');
@ header('Retry-After: 600'); // 10 minutes

?>

<h1>Databáza dočasne nedostupná</h1>
<p>Ospravedlňujeme sa, náš databázový server je na pár chvíľ nedostupný. Skúste sa sem vrátiť o niečo neskôr.</p>
<p>Za pochopenie ďakujeme. <i>~ Tím dh Forum</i></p>
