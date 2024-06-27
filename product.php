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
    <div class="loader"></div> <!-- Loader element added here -->
    <div id="product">
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
        <div id="selection">
        <?php
            function generateHTML($productName, $categoryName, $imageName, $productIndex, $categoryIndex)
            {
                $className = 'p' . ($productIndex + 1) . '-cat' . ($categoryIndex + 1) . '-item';
                return '<div class="hidden item ' . $className . '">
                            <img src="LS Instrument Website Images/' . $productName . '/' . $categoryName . '/' . $imageName . '">
                            <h2>' . htmlspecialchars(substr($imageName, 0, -4)) . '</h2>
                            <div class="btn addToCart">add to cart</div>
                        </div>';
            }

            foreach ($data as $productIndex => $product) {
                if (!isset($product['contents']) || !is_array($product['contents'])) {
                    continue;
                }
                foreach ($product['contents'] as $categoryIndex => $category) {
                    if (!isset($category['name'], $category['contents'])) {
                        continue;
                    }
                    foreach ($category['contents'] as $item) {
                        if (!isset($item['name'])) {
                            continue;
                        }
                        echo generateHTML($product['name'], $category['name'], $item['name'], $productIndex, $categoryIndex);
                    }
                }
            }
        ?>
        </div>
    </div>
    <div id="banner">
        <p>The Product is added to your Cart </p><i class="fas fa-xmark"></i>
      </div>
    <?php include 'footer.php'?>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.loader').style.display = 'block';

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

            function showBannerTemporarily() {
                var banner = document.getElementById('banner');
                var bannerP = document.querySelector('#banner p');
                var bannerIcon = document.querySelector('#banner i');
                
                var originalWidth = banner.style.width;
                var originalPadding = banner.style.padding;
                
                banner.style.width = '30%';
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
                banner.style.padding = '10px';
                bannerP.style.display = 'none';
                bannerIcon.style.display = 'none';
            })

            function addProductToCart(event) {
                event.preventDefault();

                const h2Text = event.target.closest('.item').querySelector('h2').innerText;
                let products = getCookie("products") || [];

                if (!products.includes(h2Text)) {
                    products.push(h2Text);
                    setCookie("products", products);
                }

                showBannerTemporarily();
            }

            document.querySelectorAll('.addToCart').forEach(button => {
                button.addEventListener('click', addProductToCart);
            });

            function hideAllItems() {
                document.querySelectorAll('.item').forEach(item => item.style.display = "none");
            }

            function showItemsByClass(className) {
                hideAllItems();
                document.querySelectorAll(`.${className}`).forEach(item => item.style.display = "block");
            }

            function resetCategoryColors() {
                document.querySelectorAll('#categories li > ul > li').forEach(element => {
                    element.style.color = "#a5a5a5";
                });
            }

            function addCategoryClickListener(categoryId, className) {
                const categoryElement = document.getElementById(categoryId);
                if (categoryElement) {
                    categoryElement.addEventListener('click', () => {
                        resetCategoryColors();
                        categoryElement.style.color = "black";
                        showItemsByClass(className);
                    });
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

            <?php
                foreach ($data as $productIndex => $product) {
                    $productId = 'p' . ($productIndex + 1);
                    echo "toggleCategoryList('$productId');\n";

                    foreach ($product['contents'] as $categoryIndex => $category) {
                        $categoryId = 'p' . ($productIndex + 1) . '-cat' . ($categoryIndex + 1);
                        $className = 'p' . ($productIndex + 1) . '-cat' . ($categoryIndex + 1) . '-item';
                        echo "addCategoryClickListener('$categoryId', '$className');\n";
                    }
                }
            ?>
            if(prod!==null){
                document.getElementById(prod).click();
                document.getElementById(`${prod}-cat1`).click();
            }

            document.querySelector('.loader').style.display = 'none';
        });

    </script>

</body>
</html>