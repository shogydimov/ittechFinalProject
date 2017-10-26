<?php
use \model\orders\Order;
use \model\products\Product;
use \model\users\User;
use \model\DataBase\DBManager;
use \model\DataBase\OrderDao;
use \model\DataBase\ProductDao;
use \model\DataBase\UserDao;

function __autoload($class_name)
{
	$class_name = '..\\' . $class_name;
	$class_name = str_replace("\\", "/", $class_name);
	require_once $class_name . '.php';
}

session_start();
if (isset($_POST['userCart'])) {
	$userCartArrayObject = json_decode($_POST['userCart']);
	$resultDBOnStockQuantity = ProductDao ::getInstance() -> checkQuantity($userCartArrayObject);
	if ($resultDBOnStockQuantity === true) {
		for ($i = 0; $i < count($userCartArrayObject); $i ++) {
			$currentProductId = $userCartArrayObject[$i] -> product_id;
			$productIdUserCart = $_SESSION['cart'][$i] -> product_id;
			if ($currentProductId == $productIdUserCart) {
				$orderedQuantity = $userCartArrayObject[$i] -> orderedQuantity;
				$_SESSION['cart'][$i] -> orderedQuantity = $orderedQuantity;
			}
		}
		echo json_encode($_SESSION['cart'], JSON_UNESCAPED_SLASHES);
	}
}
	
//	for ($i = 0; $i < count($userCartArrayObject); $i ++) {
//		$orderedQuantity = $userCartArrayObject[$i] -> orderedQuantity;
//		$currentProductId = $userCartArrayObject[$i] -> product_id;
//		$resultDBOnStockQuantity = ProductDao ::getInstance() -> checkQuantity($currentProductId, $orderedQuantity);
//		if ($resultDBOnStockQuantity['quontity'] >= $orderedQuantity) {
//			$_SESSION['cart'][$i] -> orderedQuantity = $orderedQuantity;
//		}
//	}
//	for ($i = 0; $i < count($userCartArrayObject); $i ++) {
//		$currentProductId = $userCartArrayObject[$i] -> product_id;
//		$productIdUserCart = $_SESSION['cart'][$i] -> product_id;
//		if ($currentProductId == $productIdUserCart) {
//			$orderedQuantity = $userCartArrayObject[$i] -> orderedQuantity;
//			$resultDBOnStockQuantity = ProductDao ::getInstance() -> checkQuantity($userCartArrayObject[$i]);
//			if ($resultDBOnStockQuantity['quontity'] >= $orderedQuantity) {
//				$_SESSION['cart'][$i] -> orderedQuantity = $orderedQuantity;
//			}
//		}
//	}
//	echo json_encode($_SESSION['cart'], JSON_UNESCAPED_SLASHES);
//}