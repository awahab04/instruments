<?php 
	if (isset($_GET['p'])) {
		$product = htmlspecialchars($_GET['p']);
	} else {
		$product = null;
	}
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'http://localhost/project/data.php');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);

	if($response === false) {
		die('Error: Curl request failed: ' . curl_error($ch));
	}

	curl_close($ch);

	$data = json_decode($response, true);

	if($data === null) {
		die('Error: Unable to decode JSON data.');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script> var prod = 'p<?php if ($product !== null) {echo $product;} ?>' </script>
	<title>Product</title>
</head>
<body>
	<?php include 'navbar.php'?>
	<div id="product">
		<div>
			<div id="categories">
				<ul>
					<?php
						function generateCatHTML($productName, $productIndex, $categories)
						{
							$html = '<li>
										<p id="p' . ($productIndex + 1) . '" class="p-s product">
											<span>' . $productName . '</span>
											<i class="fas fa-angle-down"></i><hr>
										</p>
										<ul class="hidden" id="p' . ($productIndex + 1) . '-items">';

							foreach ($categories as $categoryIndex => $category) {
								$html .= '<li id="p' . ($productIndex + 1) . '-cat' . ($categoryIndex + 1) . '">- ' . $category['name'] . '</li>';
							}

							$html .= '  </ul>
									</li>';

							return $html;
						}

						foreach ($data as $productIndex => $product) {
							if (!isset($product['contents']) || !is_array($product['contents'])) {
								continue;
							}
							echo generateCatHTML($product['name'], $productIndex, $product['contents']);
						}
					?>
				</ul>
			</div>
		</div>
		<div id="selection">
			<div class="products" id="product-container">

			</div>
		</div>
	</div>
	<div id="banner">
		<p>The Product is added to your Cart </p><i class="fas fa-xmark"></i>
	</div>
	<?php include 'footer.php'?>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function () {
			const data = <?php echo json_encode($data); ?>;

			function setCookie(name, value) {
				document.cookie = `${name}=${JSON.stringify(value)}; path=/`;
			}

			function getCookie(name) {
				const value = `; ${document.cookie}`;
				const parts = value.split(`; ${name}=`);
				if (parts.length === 2) return JSON.parse(parts.pop().split(';').shift());
				return [];
			}

			function showBannerTemporarily() {
				var banner = document.getElementById('banner');
				var bannerP = document.querySelector('#banner p');
				var bannerIcon = document.querySelector('#banner i');
				
				var originalWidth = banner.style.width;
				var originalPadding = banner.style.padding;
				
				banner.style.width = '20em';
				banner.style.padding = '10px';
				setTimeout(function() {
					bannerP.style.display = 'block';
					bannerIcon.style.display = 'block';
				}, 200);
				
				setTimeout(function() {
					banner.style.width = originalWidth;
					banner.style.padding = originalPadding;
					bannerP.style.display = 'none';
					bannerIcon.style.display = 'none';
				}, 5000);
			}

			document.querySelector('#banner i').addEventListener('click', () => {
				var banner = document.getElementById('banner');
				var bannerP = document.querySelector('#banner p');
				var bannerIcon = document.querySelector('#banner i');

				banner.style.width = '0';
				banner.style.padding = '0';
				bannerP.style.display = 'none';
				bannerIcon.style.display = 'none';
			});

			function addProductToCart(event) {
				event.preventDefault();

				const itemElement = event.target.closest('.item');
				const h2Text = itemElement.querySelector('h2').innerText;

				let productObject = findProductInData(data, h2Text);

				if (productObject) {
					productObject.quantity = 1;

					let products = getCookie("products") || [];

					const isDuplicate = products.some(
						(product) =>
							product.productName === productObject.productName &&
							product.categoryName === productObject.categoryName &&
							product.fileName === productObject.fileName
					);

					if (!isDuplicate) {
						products.push(productObject);
						setCookie("products", products);
					}

					showBannerTemporarily();
				} else {
					console.error('Product not found in data');
				}
			}

			function findProductInData(data, h2Text) {
				for (const item of data) {
					if (item.type === 'folder') {
						for (const subItem of item.contents) {
							if (subItem.type === 'folder') {
								for (const file of subItem.contents) {
									if (file.type === 'image' && file.name.includes(h2Text)) {
										return {
											productName: item.name,
											categoryName: subItem.name,
											fileName: file.name
										};
									}
								}
							}
						}
					}
				}
				return null;
			}

			document.querySelectorAll('.addToCart').forEach(button => {
				button.addEventListener('click', addProductToCart);
			});

			function loadProducts(productIndex, categoryIndex) {
				const product = data[productIndex];
				const category = product.contents[categoryIndex];
				const productContainer = document.getElementById('product-container');

				productContainer.innerHTML = '';

				for (const item of category.contents) {
					if (item.type === 'image') {
						const div = document.createElement('div');
						div.classList.add('item', `p${productIndex + 1}-cat${categoryIndex + 1}-item`);
						div.innerHTML = `
							<img src="LS Instrument Website Images/${product.name}/${category.name}/${item.name}">
							<h2>${item.name.substring(0, item.name.length - 4)}</h2>
							<div class="btn addToCart">add to cart</div>
						`;
						productContainer.appendChild(div);

						div.querySelector('.addToCart').addEventListener('click', addProductToCart);
					}
				}
			}

			function toggleCategoryList(productId) {
				const productElement = document.getElementById(productId);
				const categoryList = document.getElementById(productId + '-items');
				if (productElement && categoryList) {
					productElement.addEventListener('click', () => {
						categoryList.style.display = (categoryList.style.display === "block") ? "none" : "block";
					});
				}
			}

			function addCategoryClickListener(categoryId, productIndex, categoryIndex) {
				const categoryElement = document.getElementById(categoryId);
				if (categoryElement) {
					categoryElement.addEventListener('click', () => {
						loadProducts(productIndex, categoryIndex);
						resetCategoryColors();
						categoryElement.style.color = "black";
					});
				}
			}

			function resetCategoryColors() {
				document.querySelectorAll('#categories li > ul > li').forEach(element => {
					element.style.color = "#a5a5a5";
				});
			}

			<?php
				foreach ($data as $productIndex => $product) {
					$productId = 'p' . ($productIndex + 1);
					echo "toggleCategoryList('$productId');\n";

					foreach ($product['contents'] as $categoryIndex => $category) {
						$categoryId = 'p' . ($productIndex + 1) . '-cat' . ($categoryIndex + 1);
						echo "addCategoryClickListener('$categoryId', $productIndex, $categoryIndex);\n";
					}
				}
			?>
			if(prod !== null){
				document.getElementById(prod).click();
				document.getElementById(`${prod}-cat1`).click();
			}
		});
	</script>
</body>
</html>
