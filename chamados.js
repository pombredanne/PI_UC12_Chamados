var linguagens = document.getElementById("selectFilterStatus");

linguagens.addEventListener("onchange", function() {

	var options = this.options;
	var itemAtual = this.selectedIndex;

	console.log(options[itemAtual].text);
});