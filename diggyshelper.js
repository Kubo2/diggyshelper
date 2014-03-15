/**
 **********************************************************
 *                                                        |
 * Tento skript bol vytvorený pre Diggy's Helper fórum,   |
 * a jeho autor sa úzko podieľal na vzniku tohoto fóra.   |
 * Skript je voľne šíriteľný a upravovateľný. Nesmie sa   |
 * však vydávať za svoj výtvor. Ak ho niekde použijete,   |
 * vždy uveďte, odkiaľ ste ho získali.                    |
 * Za uvedenie zdroja sa považuje obdoba nasledovného:    |
 * Zdroj: Diggy's Helper Project                          |
 *                                                        |
 * @author Kubo2                                          |
 * @author WladinQ                                        |
 * Copyright (c) Diggy's Helper Project                   |
 *                                                        |
 **********************************************************
 */

// http://djpw.cz/templates/djpw.js
function getHttpRequest()
{
  return !window.XMLHttpRequest ? !window.ActiveXObject ? null : new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
}

// oznámenie / hlavička
function updateBoard(text, classification) {
	if(!classification) classification = "notice";
	var board = document.getElementById('provizorne');
	if(!board) {
		board = document.createElement('div');
		board.id = 'provizorne';
		document.getElementById('header').appendChild(board);
	}
	board.className = classification;
	board.innerHTML = text;

}

// kontrola hesla na stránke registrácia
var pswfield = document.getElementById('status');
if(pswfield) {
	pswfield.onkeyup = function(){
		var psw = this.value || this.innerHTML;
		var label = document.getElementsByClassName("first")[0] || document.querySelector(".first");
		if(!label) return;
		if(!psw.length) {
			label.innerHTML = '';
			label.className = 'first';
		} else if(psw.match(/^[a-z\d-]{3,6}$/i) || psw.length <= 2) {
			label.innerHTML = 'SLABÉ HESLO';
			label.className = "first red";
		} else if(psw.match(/^[\x20-\x7E]{7,12}$/i)) {
			label.innerHTML = 'POKROČILÉ HESLO';
			label.className = "first orange";
		} else if(psw.match(/^[\x20-\xFF]{8,}$/i)) {
			if(psw.length > 8 && psw.match(/^[a-z\d-]+$/))
				return;
			label.innerHTML = "<b>SILNÉ</b> HESLO";
			label.className = "first green";
		}
	}
}

// dočasne - po dokončení sa bude tzv. board používať pre zobrazovanie notifikácií
updateBoard('<p>Ospravedlňujeme sa za neočakávanú funkčnosť niektorých prvkov tohoto webu.<br>Stránka je momentálne v prestavbe, čoskoro bude nasadená nová, vylepšená verzia.<p>Ďakujeme za pochopenie.<br><span style="text-align:right">~ Tím Diggy\'s Helper</span>', "warning");


// zobrazenie userprofile dialógu, ak sme na hlavnej stránke a existuje hash #member
var uzivatelDialog = location.hash.match(/#member=(\d+)$/);
if((document.getElementsByClassName("cat_links") || document.querySelector(".cat_links")) && uzivatelDialog != null) {
	var req = getHttpRequest();
	if(req) {
		req.open('GET', "members-new.php");
		req.setRequestHeader('X-Requested-With', "XMLHttpRequest");
		try {
		req.setRequestHeader('X-User-Id', uzivatelDialog[1]);
		} catch(e) {  }
		req.onreadystatechange = function(){
			if(this.readyState != 4) return;
			var fce = this;
			var info = new Function("return " + fce.responseText)();
			if("chyba" in info) {
				alert("Pri načítaní používateľského profilu nastala chyba: " + info.chyba);
				return;
			}
			var dialog = document.createElement('div');
			dialog.className = "js-object profile dialog";

			// since the stylesheet doesn't contain definitions for above classes

			dialog.innerHTML = "\
<h3>Profil používateľa " + info.prezyvka + "</h3>\
<img src='' align='left'>\
<table id='profilinfo' border='0'>\
	<tr>\
		<td colspan=2>Oprávnenie: <b>" + info.prava + "</b></td>\
	</tr>\
	<tr>\
		<td>E-mail: </td>\
	</tr>\
	<tr>\
		<td>Počet príspevkou: </td>\
	</tr>\
	<tr>\
		<td>Posledná návšteva: </td>\
	</tr>\
	<tr>\
		<td>Registrovaný dňa: " + info.registrovany + "</td>\
	</tr>\
	<tr>\
		<td><p style='text-align:right'><a href='#'>Viac</a></p></td>\
	</tr>\
</table>\
";
		var menu = document.getElementById('menu');
		menu.parentElement.insertBefore(dialog, menu);
		}
		req.send();
	}
}