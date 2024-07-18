<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Contact Us</title>
</head>
<body>

	<?php include 'navbar.php'?>
	<div id="contact">
		<div class="contactform">
			<div class="info">
				<h3>CONTACT INFORMATION</h3>
				<h3>PAKISTAN OFFICE:</h3>
				<p>LS Instruments
				Address ; C-115-116, S.I.E Sialkot - Pakistan</p>
				<p>
					<br><b>Mob: </b> +92-300-9611909
					<br><b>Email: </b> info@lsinstruments.com
					<br><b>Web: </b> www.lsinstruments.com
				</p>
			</div>
			<div class="form">
					<h2>FEEDBACK</h2>
				<form>
					<div class="input-box">
						<input type="text" name="name" id="name" class="field" required>
						<span>Name</span>
					</div>
					<div class="input-box">
						<input type="text" name="mobile" id="mobile" class="field" required>
						<span>Mobile</span>
					</div>
					<div class="input-box full-width">
						<input type="email" name="email" id="email" class="field" required>
						<span>Email</span>
					</div>
					<div class="input-box full-width">
						<input type="text" name="message" id="message" class="field" required>
						<span>Write Your message here....</span>
					</div>
					<button class="btn" onclick="sendMessage()">Send Message</button>
				</form>
			</div>
		</div>
		<div class="map">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2990.274257380938!2d-70.56068388481569!3d41.45496659976631!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e52963ac45bbcb%3A0xf05e8d125e82af10!2sDos%20Mas!5e0!3m2!1sen!2sus!4v1671220374408!5m2!1sen!2sus" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
	</div>
	<?php include 'footer.php'?>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function() {
			const inputElements = document.querySelectorAll('.field');

			function handleInputChange(event) {
				const inputElement = event.target;
				const inputLabel = inputElement.parentElement.querySelector('span');

				if (inputElement.value) {
					moveSpan(inputLabel, true);
				} else {
					moveSpan(inputLabel, false);
				}
			}

			function moveSpan(inputLabel, isActive) {
				inputLabel.style.fontSize = '10px';
				inputLabel.style.letterSpacing = '1px';

				if (isActive) {
					inputLabel.style.transform = 'translateY(-20px)';
				} else {
					inputLabel.style.transform = 'translateY(0)';
					inputLabel.style.fontSize = '18px';
					inputLabel.style.fontWeight = '300';
					inputLabel.style.letterSpacing = '0';
				}
			}

			inputElements.forEach(function(inputElement) {
				inputElement.addEventListener('input', handleInputChange);
			});
		});

		function sendMessage() {
			const name = document.getElementById('name').value.trim();
			const mobile = document.getElementById('mobile').value.trim();
			const email = document.getElementById('email').value.trim();
			const messageText = document.getElementById('message').value.trim();

			if (name === '' || mobile === '' || email === '' || messageText === '') {
				alert('Please fill in all fields.');
				return false;
			}
			
			const message = `New Contact Form Submission:
			\nName: ${name}
			\nMobile: ${mobile}
			\nEmail: ${email}
			\nMessage: ${messageText}`;

			const whatsappUrl = `https://api.whatsapp.com/send?phone=+923083731896&text=${encodeURIComponent(message)}`;

			window.open(whatsappUrl, '_blank');
		}
	</script>

</body>
</html>
