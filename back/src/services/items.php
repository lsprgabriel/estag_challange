<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");

require_once('pdo.php');

class OrderItems {
    public function getOrderItems() {
        $stmt = myDB->prepare('SELECT * FROM order_item');
        $stmt->execute();
        $mock_data = $stmt->fetchAll();

        return json_encode($mock_data);
    }

    public function postOrderItems($order_code, $product_code, $amount, $tax, $price) {
        $stmt = myDB->prepare('INSERT INTO order_item (order_code, product_code, amount, tax, price) VALUES (:order_code, :product_code, :amount, :tax, :price)');
        $stmt->bindParam(':order_code', $order_code);
        $stmt->bindParam(':product_code', $product_code);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':tax', $tax);
        $stmt->bindParam(':price', $price);
        $stmt->execute();

        return json_encode(['message' => 'Order item added']);
    }
}