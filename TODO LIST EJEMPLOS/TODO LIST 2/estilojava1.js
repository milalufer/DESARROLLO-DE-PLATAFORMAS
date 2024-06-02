
function agregarBotonCerrar(li) {
  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  span.onclick = function() {
    var div = this.parentElement;
    div.style.display = "none";
  }
}

var lista = document.querySelector('ul');
lista.addEventListener('click', function(ev) {
  if (ev.target.tagName === 'LI') {
    ev.target.classList.toggle('checked');
  }
}, false);

function nuevoElemento() {
  var li = document.createElement("li");
  var inputValue = document.getElementById("miEntrada").value;
  var t = document.createTextNode(inputValue);
  li.appendChild(t);
  if (inputValue === '') {
    alert("¡Debes escribir algo!");
  } else {
    document.getElementById("miUL").appendChild(li);
    agregarBotonCerrar(li);
  }
  document.getElementById("miEntrada").value = "";
}
