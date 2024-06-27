<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Inquiry Form</title>
</head>
<body>

	<?php include 'navbar.php'?>
	<div id="inquiryform">
		<div class="inquiryform">
			<div class="info">
				<h2>Inquiry Form</h2>
			</div>
			<div class="form">
					<h2>Send Inquiry</h2>
				<form>
					<div class="input-box">
						<input type="text" name="fname" id="fname" class="field" required>
						<span>First Name</span>
					</div>
					<div class="input-box">
						<input type="text" name="lname" id="lname" class="field" required>
						<span>Last Name</span>
					</div>
					<div class="input-box">
						<input type="text" name="mobile" id="mobile" class="field" required>
						<span>Mobile</span>
					</div>
					<div class="input-box full-width">
						<input type="email" name="email" id="email" class="field" required>
						<span>Email</span>
					</div>
					<button class="btn" onclick="sendInquiry()">Send Inquiry</button>
				</form>
			</div>
		</div>
	</div>
	<?php include 'footer.php'?>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function() {
			const inputElements = document.querySelectorAll('.field');

			function handleInputChange(event) {
				const inputLabels = document.querySelectorAll('.input-box span');
				inputLabels.forEach(function(inputLabel, index) {
					inputLabel.style.fontSize = '12px';
					inputLabel.style.fontWeight = '400';
					inputLabel.style.letterSpacing = '1px';
					inputLabel.style.transform = 'translateY(-20px)';
				});
			}

			inputElements.forEach(function(inputElement) {
				inputElement.addEventListener('input', handleInputChange);
			});
		});
		function getCookie(name) {
			const value = `; ${document.cookie}`;
			const parts = value.split(`; ${name}=`);
			if (parts.length === 2) return JSON.parse(parts.pop().split(';').shift());
			return [];
		}

		function deleteCookie(name) {
			document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
		}

		function sendInquiry() {
			const fname = document.getElementById('fname').value;
			const lname = document.getElementById('lname').value;
			const mobile = document.getElementById('mobile').value;
			const email = document.getElementById('email').value;
			const products = getCookie('products');

			if (!fname || !lname || !mobile || !email) {
				alert('Please fill in all the fields.');
				return;
			}

			const productsList = products.map(product => `${product.fileName.slice(0, -4)} (Quantity: ${product.quantity})`).join(', ');
			const message = `Hello, I would like to make a Purchase. Here are my details:
			\nFirst Name: ${fname}
			\nLast Name: ${lname}
			\nMobile: ${mobile}
			\nEmail: ${email}
			\nProducts: ${productsList}`; 

			const whatsappUrl = `https://api.whatsapp.com/send?phone=+923043349349&text=${encodeURIComponent(message)}`;

			window.open(whatsappUrl, '_blank');

			deleteCookie('products');
		}
	</script>
</body>
</html>