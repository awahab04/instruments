<?php 
	if (isset($_GET['p'])) {
		$product = $_GET['p'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Product</title>
</head>
<body>

	<?php include 'navbar.php'?>
	<div id="product">
		<div id="categories">
			<ul>
				<li>
					<p id="p1" class="p-s">
						<span>Product 1</span>
						<i class="fas fa-angle-down"></i><hr>
					</p>
					<ul id="p1-items">
						<li id="p1-cat1">- P1-Category</li>
						<li id="p1-cat2">- P1-Category</li>
						<li id="p1-cat3">- P1-Category</li>
						<li id="p1-cat4">- P1-Category</li>
						<li id="p1-cat5">- P1-Category</li>
					</ul>
				</li>
				<li>
					<p id="p2" class="p-s">
						<span>Product 2</span>
						<i class="fas fa-angle-down"></i><hr>
					</p>
					<ul id="p2-items">
						<li id="p2-cat1">- P2-Category</li>
						<li id="p2-cat2">- P2-Category</li>
						<li id="p2-cat3">- P2-Category</li>
						<li id="p2-cat4">- P2-Category</li>
						<li id="p2-cat5">- P2-Category</li>
					</ul>
				</li>
				<li>
					<p id="p3" class="p-s">
						<span>Product 3</span>
						<i class="fas fa-angle-down"></i><hr>
					</p>
					<ul id="p3-items">
						<li id="p3-cat1">- P3-Category</li>
						<li id="p3-cat2">- P3-Category</li>
						<li id="p3-cat3">- P3-Category</li>
						<li id="p3-cat4">- P3-Category</li>
						<li id="p3-cat5">- P3-Category</li>
					</ul>
				</li>
				<li>
					<p id="p4" class="p-s">
						<span>Product 4</span>
						<i class="fas fa-angle-down"></i><hr>
					</p>
					<ul id="p4-items">
						<li id="p4-cat1">- P4-Category</li>
						<li id="p4-cat2">- P4-Category</li>
						<li id="p4-cat3">- P4-Category</li>
						<li id="p4-cat4">- P4-Category</li>
						<li id="p4-cat5">- P4-Category</li>
					</ul>
				</li>
				<li>
					<p id="p5" class="p-s">
						<span>Product 5</span>
						<i class="fas fa-angle-down"></i><hr>
					</p>
					<ul id="p5-items">
						<li id="p5-cat1">- P5-Category</li>
						<li id="p5-cat2">- P5-Category</li>
						<li id="p5-cat3">- P5-Category</li>
						<li id="p5-cat4">- P5-Category</li>
						<li id="p5-cat5">- P5-Category</li>
					</ul>
				</li>
			</ul>
		</div>
		<div id="selection">













<?php

function scanFolder($dir)
{
    $result = [];

    $contents = scandir($dir);
    foreach ($contents as $item) {
        if ($item != '.' && $item != '..') {
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                $result[] = [
                    'name' => $item,
                    'type' => 'folder',
                    'contents' => scanFolder($path)
                ];
            } else {
                $result[] = [
                    'name' => $item,
                    'type' => 'file',
                    'code' => pathinfo($item, PATHINFO_FILENAME)
                ];
            }
        }
    }

    return $result;
}

$folderStructure = scanFolder('C:\xampp\htdocs\project\LS Instrument Website Images');

$products = [];

// Function to traverse the folder structure and extract products and categories
function extractProducts($structure, &$products)
{
    foreach ($structure as $item) {
        if ($item['type'] == 'folder') {
            $product = $item['name'];
            $categories = [];
            foreach ($item['contents'] as $category) {
                if ($category['type'] == 'folder') {
                    $categories[] = [
                        'name' => $category['name'],
                        'code' => ''
                    ];
                } elseif ($category['type'] == 'file') {
                    $categories[] = [
                        'name' => $category['name'],
                        'code' => $category['code']
                    ];
                }
            }
            $products[$product] = $categories;
        }
    }
}

// Extract products and categories
extractProducts($folderStructure, $products);

// Start generating HTML
$html = '';
foreach ($products as $product => $categories) {
    $productSlug = str_replace(' ', '-', strtolower($product));
    foreach ($categories as $index => $category) {
        $categorySlug = str_replace([' ', '&amp;', ''], '-', strtolower($category['name']));
        $html .= '
        <p>
            ' . $productSlug . '/' . $categorySlug . '/' . $category['code'] . '
        </p><br><br>';
    }
}

// Print the generated HTML
echo $html;

?>


			<div class="item p1-cat1-item hidden">
				<img src="images/demo.jpg">
				<h2>P103</h2>
				<div class="btn addToCart">add to cart</div>
			</div>
			<div class="item p1-cat3-item hidden">
				<img src="images/demo.jpg">
				<h2>P123</h2>
				<div class="btn addToCart">add to cart</div>
			</div>
			<div class="item p1-cat4-item hidden">
				<img src="images/demo.jpg">
				<h2>P111</h2>
				<div class="btn addToCart">add to cart</div>
			</div>
			<div class="item p2-cat1-item hidden">
				<img src="images/demo.jpg">
				<h2>P172</h2>
				<div class="btn addToCart">add to cart</div>
			</div>
			<div class="item p2-cat5-item hidden">
				<img src="images/demo.jpg">
				<h2>P190</h2>
				<div class="btn addToCart">add to cart</div>
			</div>
			<div class="item p3-cat2-item hidden">
				<img src="images/demo.jpg">
				<h2>P176</h2>
				<div class="btn addToCart">add to cart</div>
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

			function addProductToCart(event) {
				event.preventDefault();

				const h2Text = event.target.closest('.item').querySelector('h2').innerText;
				let products = getCookie("products") || [];

				if (!products.includes(h2Text)) {
					products.push(h2Text);
					setCookie("products", products);
				}

				window.location.href = "inquiry.php";
			}

			document.querySelectorAll('.addToCart').forEach(button => {
				button.addEventListener('click', addProductToCart);
			});

			const product = `p<?php echo $product; ?>`;

			function toggleDisplay(itemId) {
				const item = document.getElementById(itemId);
				if (item) {
					item.style.display = (item.style.display === "block") ? "none" : "block";
				}
			}

			function hideAllItems() {
				document.querySelectorAll('.hidden').forEach(item => item.style.display = "none");
			}

			function showItems(productId, className) {
				const productElement = document.getElementById(productId);
				if (productElement) {
					productElement.addEventListener('click', () => {
						hideAllItems();
						document.querySelectorAll(`.${className}`).forEach(element => element.style.display = "block");
					});
				}
			}

			function resetCategoryColors() {
				const categoryPattern = /-cat\d+$/;
				document.querySelectorAll('*').forEach(element => {
					if (categoryPattern.test(element.id)) {
						element.style.color = "#a5a5a5";
					}
				});
			}

			function changeCategoryColorOnClick(categoryId) {
				const categoryElement = document.getElementById(categoryId);
				if (categoryElement) {
					categoryElement.addEventListener('click', () => {
						resetCategoryColors();
						categoryElement.style.color = "black";
					});
				}
			}

			const products = ['p1', 'p2', 'p3', 'p4', 'p5'];
			const categories = ['cat1', 'cat2', 'cat3', 'cat4', 'cat5'];

			products.forEach(product => {
				const productElement = document.getElementById(product);
				if (productElement) {
					productElement.addEventListener('click', () => toggleDisplay(`${product}-items`));

					categories.forEach(category => {
						showItems(`${product}-${category}`, `${product}-${category}-item`);
						changeCategoryColorOnClick(`${product}-${category}`);
					});
				}
			});

			if (product) {
				toggleDisplay(`${product}-items`);
				const initialCategory = document.getElementById(`${product}-cat1`);
				if (initialCategory) {
					initialCategory.click();
					initialCategory.style.color = "black";
				}
			}
		});
	</script>

</body>
</html>