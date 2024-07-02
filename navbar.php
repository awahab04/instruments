<div id="nav">
	<i class="fas fa-lg fa-bars" onclick="show()"></i>
	<div class="logo"><img src="images/logo.png"></div>
	<div class="menu">
		<i class="fas fa-2x fa-times" onclick="closemenu()"></i>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="about.php">About Us</a></li>
			<li class="hidden products-list"><a href="product.php?p=1">Products</a></li>
			<li class="products-dropdown">
				<a>Products <i class="fas fa-angle-down" style="color: black;"></i></a>
				<ul class="dropdown">
					<div class="column">
						<?php
							$products = [
								"Areola Markers, Breast Dissect",
								"NEUROSURGERY INSTRUMENTS",
								"Cardiovascular &amp; Thoracic",
								"Stethoscopes &amp; Magill Forc",
								"Inteatinal and Rectal Instumen",
								"Urology Instruments",
								"Gynecology/Obstetrics",
								"Liposuction cannulas and Sets",
								"Spine Instruments Products",
								"Ophthalmic Instruments",
								"Root Elevator",
								"Trocars, suction tubes, needle",
								"Diagnostic Instrument",
								"Articulators",
								"Bone Rounger",
								"Bone Surgery Instruments",
								"Dermatomes Transplantation Kni",
								"Dissecting&amp;Gynecological S",
								"Amal Gum Instruments"
							];

							$totalProducts = count($products);
							$productsPerColumn = ceil($totalProducts / 3);

							for ($i = 0; $i < $totalProducts; $i++) {
								if ($i > 0 && $i % $productsPerColumn == 0) {
									echo '</div><div class="column">';
								}
								$n = $i + 1;
								echo '<li><a href="product.php?p=' . $n . '">' . $products[$i] . '</a></li>';
							}
						?>
					</div>
				</ul>
			</li>

			<li><a href="customer-service.php">Customer Services</a></li>
			<li><a href="exhibition.php">Exhibition</a></li>
			<li><a href="factoryview.php">Factory View</a></li>
			<li><a href="catalogue.php">Catalogue</a></li>
			<li><a href="inquiry.php">Inquiry</a></li>
		</ul>
	</div>
	<a href="contactus.php" class="btn">Contact Us</a>
</div>