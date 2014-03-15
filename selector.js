window.onload = function(){
  document.getElementById('status').onkeyup = function(){
    var dlzka = (this.value || this.innerHTML).length;
    var label = document.getElementsByClassName("first")[0] || document.querySelector(".first");
    if(!label) return;
    if(!dlzka) {
      label.innerHTML = '';
      label.className = "first";
    } else if(dlzka <= 4) {
      label.innerHTML = 'SLABÉ HESLO';
      label.className = "first red";
    } else if(dlzka <= 8) {
      label.innerHTML = "DOBRÉ/PRIEMERNÉ HESLO";
      label.className = "first orange";
    } else {
      label.innerHTML = "SILNÉ HESLO";
      label.className = "first green";
    }
  }
}