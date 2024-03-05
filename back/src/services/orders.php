<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");

require_once('pdo.php');

class Orders {
    public function getOrders() {
        $stmt = myDB->prepare('SELECT * FROM orders');
        $stmt->execute();
        $mock_data = $stmt->fetchAll();

        return json_encode($mock_data);
    }

    public function postOrders($total, $tax) {
        $stmt = myDB->prepare('INSERT INTO orders (total, tax) VALUES (:total, :tax)');
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':tax', $tax);
        $stmt->execute();

        return json_encode(['message' => 'Order added']);
    }
}