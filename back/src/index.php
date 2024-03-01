<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");

$pageDir = '/services/';
[ 'postCategories' => $postCategories] = require __DIR__ . $pageDir . 'categories.php';
[ 'getCategories' => $getCategories] = require __DIR__ . $pageDir . 'categories.php';
[ 'deleteCategories' => $deleteCategory] = require __DIR__ . $pageDir . 'categories.php';
[ 'postProducts' => $postProducts] = require __DIR__ . $pageDir . 'products.php';
[ 'getProducts' => $getProducts] = require __DIR__ . $pageDir . 'products.php';
[ 'deleteProduct' => $deleteProduct] = require __DIR__ . $pageDir . 'products.php';
[ 'postOrders' => $postOrders] = require __DIR__ . $pageDir . 'orders.php';
[ 'getOrders' => $getOrders] = require __DIR__ . $pageDir . 'orders.php';
[ 'postOrderItems' => $postOrderItems] = require __DIR__ . $pageDir . 'items.php';
[ 'getOrderItems' => $getOrderItems] = require __DIR__ . $pageDir . 'items.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '':
    case '/':
        $response = [
            'message' => 'API feita por @lsprgabriel',
            'endpoints' => [
                '/api/phpinfo' => 'Mostra informações do PHP',
                '/api/categories' => 'GET: Retorna todas as categorias | POST: Adiciona uma categoria',
                '/api/products' => 'GET: Retorna todos os produtos | POST: Adiciona um produto',
                '/api/categories/{id}' => 'DELETE: Deleta uma categoria',
                '/api/products/{id}' => 'DELETE: Deleta um produto',
                '/api/orders' => 'GET: Retorna todos os pedidos | POST: Adiciona um pedido',
                '/api/order_items' => 'GET: Retorna todos os itens dos pedidos | POST: Adiciona um item ao pedido'
            ]
        ];

        echo json_encode($response);
        
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
    case '/api/orders':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postOrders($_POST['total'], $_POST['tax']);
            break;
        } else {
            echo $getOrders();
            break;
        }
    case '/api/order_items':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postOrderItems($_POST['order_code'], $_POST['product_code'], $_POST['amount'], $_POST['tax'], $_POST['price']);
            break;
        } else {
            echo $getOrderItems();
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