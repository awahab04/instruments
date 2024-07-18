<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Inquiry</title>
	<style type="text/css">
	</style>
</head>
<body>

	<?php include 'navbar.php'?>
	<div id="inquiry">
		<div class="inquiry">
			<div class="items">
				<h1>Cart</h1>
				<div class="no-items">
					<p>Your Cart is Empty</p>
				</div>
			</div>
			<div>
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
	</div>
	<?php include 'footer.php'?>
	<script type="text/javascript" src="js/script.js"></script>

	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function () {
			function setCookie(name, value) {
				document.cookie = `${name}=${JSON.stringify(value)}; path=/`;
			}
			function getCookie(name) {
				const value = `; ${document.cookie}`;
				const parts = value.split(`; ${name}=`);
				if (parts.length === 2) return JSON.parse(parts.pop().split(';').shift());
				return [];
            }

			function loadInquiryItems() {
				const products = getCookie("products") || [];
				const itemsContainer = document.querySelector('.items');
				const noItemsDiv = document.querySelector('.no-items');
				let totalQuantity = 0;

				if (products.length === 0) {
					noItemsDiv.style.display = 'flex';
				} else {
					noItemsDiv.style.display = 'none';
				}

				products.forEach(product => {
					const itemDiv = document.createElement('div');
					itemDiv.classList.add('item');
					const imageSrc = `LS Instrument Website Images/${product.productName}/${product.categoryName}/${product.fileName}`;
					itemDiv.innerHTML = `
						<div class="image">
							<img src="${imageSrc}" alt="${product.fileName}">
						</div>
						<div class="details">
							<p>${product.fileName.slice(0, -4)}</p>
							<input type="number" value="${product.quantity}" min="1"><br>
							<button class="btn updateBtn">Update</button>
						</div>
							<i class="fas fa-xmark removeBtn"></i>
					`;
					itemsContainer.appendChild(itemDiv);

					totalQuantity += product.quantity;

					itemDiv.querySelector('.removeBtn').addEventListener('click', () => {
						removeProductFromCart(product);
					});

					itemDiv.querySelector('.updateBtn').addEventListener('click', () => {
						updateTotalQuantity(product, itemDiv.querySelector('input').value);
					});
				});

				document.getElementById('totalQuantity').innerText = totalQuantity;
			}

			function removeProductFromCart(product) {
				let products = getCookie("products") || [];
				products = products.filter(p => p.productName !== product.productName || p.categoryName !== product.categoryName || p.fileName !== product.fileName);
				setCookie("products", products);
				location.reload();
			}

			function updateTotalQuantity(product, newQuantity) {
				let products = getCookie("products") || [];
				products = products.map(p => {
					if (p.productName === product.productName && p.categoryName === product.categoryName && p.fileName === product.fileName) {
						p.quantity = parseInt(newQuantity, 10);
					}
					return p;
				});
				setCookie("products", products);

				const quantities = document.querySelectorAll('.items input[type="number"]');
				let totalQuantity = 0;

				quantities.forEach(input => {
					totalQuantity += parseInt(input.value, 10);
				});

				document.getElementById('totalQuantity').innerText = totalQuantity;
			}

			loadInquiryItems();
		});
	</script>

</body>
</html>
