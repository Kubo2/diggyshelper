/* ***********************************************************
 * Tento skript bol vytvorený pre Diggy's Helper fórum,
 * a jeho autor sa úzko podieľal na vzniku tohoto fóra.
 * Skript je voľne šíriteľný a upravovateľný. Nesmie sa
 * však vydávať za svoj výtvor. Ak ho niekde použijete,
 * vždy uveďte, odkiaľ ste ho získali.
 * Za uvedenie zdroja sa považuje obdoba nasledovného:
 * Zdroj: Diggy's Helper Project
 *
 * @author Kubo2
 * @author WladinQ
 * Copyright (c) Diggy's Helper Project
 *
 */

// http://djpw.cz/templates/djpw.js
function getHttpRequest()
{
  return !window.XMLHttpRequest ? !window.ActiveXObject ? null : new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
}

// nadstavba nad document.cookie
// neberie do úvahy prípadné neskoršie nastavenie cookie AJAXom, externými skriptami apod.
document.cookies = (function(){
	function encodeURIComponent(unescaped) {
		// console.log('used euc')
		return window.encodeURIComponent(unescaped).replace(/%20/g, '+');
	}
	function decodeURIComponent(escaped) {
		// console.log('used duc')
		return window.decodeURIComponent(escaped.replace(/\+/g, '%20'));
	}

	var cookies = document.cookie.split(';')
	for(var cookie, len = cookies.length, r = 0; r < len; r++) {
		cookie = cookies[r].trim().split('=');
		cookies[cookie[0].toString()] = cookie[1];
		delete cookies[r];
	}

	return {
		/**
		 * General constant value for cookies being deleted
		 * 
		 * @constant
		 * @type {String}
		 */
		DELETED: 'deleted',
		/**
		 * Sets a new cookie.
		 * 
		 * @param  {string} name 	The name of cookie being set.
		 * @param  {string} value 	The value of new cookie.
		 * @param  {int} 	lifetime 	Number of seconds to store cookie for (not absolute date).
		 */
		create: function(name, value, lifetime /*, flags */) {
			document.cookie =
				encodeURIComponent(name)
				+ '='
				+ encodeURIComponent(value)
				+ (lifetime ? '; expires=' + (n = new Date(), n.setTime(n.getTime() + lifetime * 1000), n.toGMTString()) : '')
			;

			if(typeof(lifetime) === 'undefined' || lifetime >= 0) { // not deleted, but session or higher
				cookies[encodeURIComponent(name)] = encodeURIComponent(value);
			} else { // lower than session
				delete cookies[encodeURIComponent(name)];
			}
		},
		// document.cookies.set() is an alias for .create()
		set: function() {
			this.create.apply(null, arguments);
		},
		/**
		 * Returns value of a cookie specified by the name.
		 * 
		 * @param  {string} name 	Cookie name
		 * @return {string|boolean} 	Actual value of the cookie or false if cookie does not exist
		 */
		get: function(name) {
			name = encodeURIComponent(name);
			if(!cookies[name]) { // cookie does not exist (yet/no longer)
				return false;
			}
			return decodeURIComponent(cookies[name]);
		}
	};
})();

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

//updateBoard('<p>Ospravedlňujeme sa za neočakávanú funkčnosť niektorých prvkov tohoto webu.<br>Stránka je momentálne v prestavbe, čoskoro bude nasadená nová, vylepšená verzia.<p>Ďakujeme za pochopenie.<br><span style="text-align:right">~ Tím Diggy\'s Helper</span>', "warning");

/**********************************
 *******     BB Kódy - UI    *******
 **********************************/

function vlozitBBTag(tag, text /*, oblast */ ) {
 	if(window.operamini) return;
 	try { // môže to hádzať chybu (viď djpw.js:299)
 		if(typeof(oblast) != "object") {
 			var oblast = (document.forms["vytvor-temu"] || document.forms["zasli-prispevok"] || document.forms[0]).elements["prispevok"];
 			if(!oblast) return;
 		}
 		var bb = {
 			b: {
 				parovy: true
 			},
 			i: {
 				parovy: true
 			},
 			u: {
 				parovy: true
 			},
 			del: {
 				parovy: true,
 				atributy: []
 			},
 			img: {
 				parovy: false
 			}
 		};
 		if(!bb[tag]) return;
 		var startTag = "", endTag = "";
 		startTag = "[" + tag + "]";
 		if(bb[tag].parovy) endTag = "[/" + tag + "]";
 		
 		oblast.focus();

 		if(!text) {
 			// rýchly trik na overenie, či vlastnosti nie sú undefined a zároveň je označený nejaký text
 			if(oblast.selectionStart != oblast.selectionEnd) {
 				text = oblast.value.substr(oblast.selectionStart, oblast.selectionEnd - oblast.selectionStart);
 				if(oblast.setRangeText) {
 					oblast.setRangeText(startTag + text + endTag);
 				}

 				oblast.value = oblast.value.substr(0, oblast.selectionStart) + startTag + text + endTag + oblast.value.substr(oblast.selectionEnd); // bolo by dobré napísať si k tomu nejaký ten polyfill
 				// nastavenie pozície kurzoru
 				oblast.selectionStart = oblast.selectionEnd;
 			} else if(document.selection && document.selection.createRange) {
 				var range = document.selection.createRange();
 				range.text = startTag + range.text + endTag;
 				range.move('character', range.text.length);
 				range.select();
 				oblast.focus();
 				return;
 			} else {
 				oblast.value += startTag + endTag;
 			}
 		}

 	} catch(ex) {  }
} 

// inicializačná anonymná funkcia, ktorá naviaže na buttony s príslušným {@code id} akciu
(function(formular){
	if(!formular) return;
	var buttony = [];
	for(var el = 0, len = formular.elements.length; el < len; el++) { // iteration has compatibility reason - IE 7
		if(formular.elements[el].className == "button") {
			buttony.push(formular.elements[el]);
		}
	}
	if(!buttony) return;

	for(var btn in buttony) {
		buttony[btn].onclick = function() {
			vlozitBBTag(this.id);
			return false;
		};
	}

})(document.forms["vytvor-temu"] || document.forms["zasli-prispevok"]);

/**
 * Inicializačná anonymná funkcia, ktorá vráti email v profile späť do pôvodného tvaru.
 */
(function() {
	var email;
	var sTable = {
		" (bodka) ": '.',
		" (zavináč) ": '@' // ,
	};

	try {
		email = document
			.getElementsByClassName('user-info')[0]
			.getElementsByTagName('table')[0]
			.rows[2]
			.cells[1]
			.innerHTML;
		if(!email) { // email may be empty, even if dom access succeeds
			throw new Error();
		}
	} catch(e) {
		return;
	}

	for(var s in sTable) {
		while(email.indexOf(s) > -1) {
			email = email.replace(s, sTable[s]);
		}
	}

	document // set raw email back to its field
		.getElementsByClassName('user-info')[0]
		.getElementsByTagName('table')[0]
		.rows[2]
		.cells[1]
		.innerHTML = email;
})();