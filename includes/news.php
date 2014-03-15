<?php
//error_reporting(E_ALL|E_STRICT);
/* Session sa musí inicializovať ešte *pred* odoslaním akéhokoľvek výstupu */
// @see http://php.net/session-start
session_start();

// zapnutie output bufferingu (nemám iný spôsob posielania hlavičiek po výstupe) 
// @see http://php.net/ob-start
@ob_start();

// pridaná HTTP hlavička určujúca kódovanie (neviem, čo máš v head.php, ale pre istotu, keďže 
// si mi písal, že ti nejde utf8) -- diakritika by už mala fachať 
@header("Content-Type: text/html; charset=utf-8", true, 200);

// pre odkomentovanie doctypu jednoducho odstráň sekvenciu -- zo začiatku aj z konca
?>
<!--DOCTYPE HTML-->
<center>NAJ z fóra Diggy's Helper
<br>
<table border="0">
	<tr>
		<td style='background-color:#33CC00' width='200' align='center'><font color="#FFF">Najnovší člen</font></td> <td style='background-color:#33CC00' width='200' align='center'><font color="#FFF">Najaktívnejší člen</font></td> <td style='background-color:#33CC00' width='200' align='center'><font color="#FFF">Najnovšia téma</font></td> <td style='background-color:#33CC00' width='200' align='center'><font color="#FFF">Najzobrazovanejšia téma</font></td>
	</tr>
	<tr>
		<td align='center'>???</td> <td align='center'>???</td> <td align='center'>???</td> <td align='center'>???</td>
	</tr>
</table>
</center>