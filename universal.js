// @author Kubo2
// appends text "in development" to div#header

if(!prevOnload)
	var prevOnload;
prevOnload = window.onload;

window.onload = function(){
	if(typeof(prevOnload) == "function")
		prevOnload();

	(function(header){
		var text = document.createElement("p");
		text.appendChild(document.createTextNode("\
Ospravedlňujeme sa za neočakávanú funkčnosť niektorých prvkov tohoto webu. \
"));
		text.appendChild(document.createElement("br"));
		text.appendChild(document.createTextNode("\
Fórum je momentálne v prestavbe, čoskoro bude nasadená nová, vylepšená verzia.\
"));
		text.appendChild(document.createElement("br"));
		text.appendChild(document.createElement("br"));
		text.appendChild(document.createTextNode("\
Ďakujeme za pochopenie. ~ Tím Diggy's Helper\
"));
		text.className = "warning in-development";
		text.style.color = "#FF0000";
		text.style.fontSize = "115%";
		header.appendChild(text);
	})(document.getElementById("header"))
}