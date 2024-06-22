		let menubtn = document.querySelector('.fa-bars');
		let menuclose = document.querySelector('.menu .fa-times')
		let menu = document.querySelector('.menu');
		function show() {
			menu.style.display="block";
			menu.style.left="0";
		}
		function closemenu() {
			menu.style.left="-100%";
		}