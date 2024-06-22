<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Inquiry</title>
</head>
<body>

	<?php include 'navbar.php'?>
	<div id="inquiry">
		<div class="inquiry">
			<div class="items">
		<h1>Cart</h1></div>
			<div class="summary">
				<p class="sum-head">Information about order</p>
				<p>Total Quantity: <span id="totalQuantity">0</span></p>
				<div class="btn">	
					<a href="product.php?p=1" >Add More Products</a>
				</div>
				<div class="btn">
					<a href="inquiryform.php">Send Inquiry</a>
				</div>
			</div>
		</div>
	</div>
	<?php include 'footer.php'?>
	<script type="text/javascript" src="js/script.js"></script>

	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function () {
			function setCookie(name, value) {
				document.cookie = `${name}=${JSON.stringify(value)}; path=/`;
			}
			function getCookie(name) {
				const nameEQ = `${name}=`;
				const ca = document.cookie.split(';');
				for (let i = 0; i < ca.length; i++) {
					let c = ca[i].trim();
					if (c.indexOf(nameEQ) === 0) return JSON.parse(c.substring(nameEQ.length));
				}
				return null;
			}
			 function loadInquiryItems() {
				const products = getCookie("products") || [];
				const itemsContainer = document.querySelector('.items');
				let totalQuantity = 0;

				products.forEach(product => {
					const itemDiv = document.createElement('div');
					itemDiv.classList.add('item');
					itemDiv.innerHTML = `
						<div class="image">
							<img src="images/inq-i1.jpg" alt="${product}">
						</div>
						<div class="details">
							<p>${product}</p>
							<input type="number" value="1"><br>
							<button class="btn updateBtn">Update</button>
						</div>
							<i class="fas fa-xmark removeBtn"></i>
					`;
					itemsContainer.appendChild(itemDiv);

					totalQuantity += 1;

					itemDiv.querySelector('.removeBtn').addEventListener('click', () => {
						removeProductFromCart(product);
					});

					itemDiv.querySelector('.updateBtn').addEventListener('click', () => {
						updateTotalQuantity();
					});
				});

				document.getElementById('totalQuantity').innerText = totalQuantity;
			}

			function removeProductFromCart(product) {
				let products = getCookie("products") || [];
				products = products.filter(p => p !== product);
				setCookie("products", products);
				location.reload();
			}

			function updateTotalQuantity() {
				const quantities = document.querySelectorAll('.items input[type="number"]');
				let totalQuantity = 0;

				quantities.forEach(input => {
					totalQuantity += parseInt(input.value, 10);
				});

				document.getElementById('totalQuantity').innerText = totalQuantity;
			}

			loadInquiryItems();
		})
	</script>

</body>
</html>