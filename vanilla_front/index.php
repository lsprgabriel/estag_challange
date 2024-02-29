<?php

$request = $_SERVER['REQUEST_URI'];
$pageDir = '/pages/';

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $pageDir . 'home.php';
        break;

    case '/products':
        require __DIR__ . $pageDir . 'products.php';
        break;

    case '/categories':
        require __DIR__ . $pageDir . 'categories.php';
        break;
    
    case '/history':
        require __DIR__ . $pageDir . 'history.php';
        break;

    default:
        if(str_contains($request, 'details/')){
                require __DIR__ . $pageDir . 'details.php';
                break;
        }
        http_response_code(404);
        require __DIR__ . $pageDir . '404.php';
}
?>