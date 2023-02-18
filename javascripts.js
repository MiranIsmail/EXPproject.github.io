// JavaScript code
function search_event() {
	let input = document.getElementById('searchQueryInput').value
	input=input.toLowerCase();
	let x = document.getElementsByClassName('card-title');
    let xcard = document.getElementsByClassName('eventCards');

	for (i = 0; i < x.length; i++) {
		if (!xcard[i].innerHTML.toLowerCase().includes(input)) {
			xcard[i].style.display="none";
		}
		else {
			xcard[i].style.display="list-item";
		}
	}
}
