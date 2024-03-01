<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");

require_once('pdo.php');

return [
    'getOrderItems' => function (): string {
        $stmt = myDB->prepare('SELECT * FROM order_item');
        $stmt->execute();
        $mock_data = $stmt->fetchAll();

        return json_encode($mock_data);
    },
    'postOrderItems' => function ($order_code, $product_code, $amount, $tax, $price, $total) {

        $stmt = myDB->prepare('INSERT INTO order_item (order_code, product_code, amount, tax, price, total) VALUES (:order_code, :product_code, :amount, :tax, :price, :total)');

        $stmt->bindParam(':order_code', $order_code);
        $stmt->bindParam(':product_code', $product_code);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':tax', $tax);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':total', $total);
        $stmt->execute();
        
        return json_encode(['message' => 'Order item added']);
    },
];