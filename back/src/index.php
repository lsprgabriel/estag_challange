<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");

$pageDir = '/services/';
['intro' => $intro] = require __DIR__ . $pageDir . 'miscellaneous.php';
[ 'postCategories' => $postCategories] = require __DIR__ . $pageDir . 'categories.php';
[ 'getCategories' => $getCategories] = require __DIR__ . $pageDir . 'categories.php';
[ 'deleteCategories' => $deleteCategory] = require __DIR__ . $pageDir . 'categories.php';
[ 'postProducts' => $postProducts] = require __DIR__ . $pageDir . 'products.php';
[ 'getProducts' => $getProducts] = require __DIR__ . $pageDir . 'products.php';
[ 'deleteProduct' => $deleteProduct] = require __DIR__ . $pageDir . 'products.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '':
    case '/':
        echo $intro("API feita por @lsprgabriel"); 
        break;
    case '/api/phpinfo':
        require __DIR__ . $pageDir . 'phpinfo.php';
        break;
    case '/api/categories':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postCategories($_POST['category'], $_POST['tax']);
            break;
        } else {
            echo $getCategories();
            break;
        }
    case '/api/products':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postProducts($_POST['product'], $_POST['price'], $_POST['amount'], $_POST['category']);
            break;
        } else {
            echo $getProducts();
            break;
        }
    default:
        if(str_contains($request, 'categories/')) {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $deleteCategory(getIdFromUrl($request));
                break;
            }
        } else if(str_contains($request, 'products/')) {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $deleteProduct(getIdFromUrl($request));
                break;
            }
        }
}

function getIdFromUrl($url){
        $url = explode('/', $url);
        return $url[count($url) - 1];
    }
?>