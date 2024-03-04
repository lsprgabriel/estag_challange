<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");

require_once('pdo.php');

return [
    'getProducts' => function (): string {
        $stmt = myDB->prepare('SELECT * FROM products');
        $stmt->execute();
        $mock_data = $stmt->fetchAll();

        return json_encode($mock_data);
    },
    'postProducts' => function ($name, $price, $amount, $category) {

        $stmt = myDB->prepare('INSERT INTO products (name, price, amount, category_code) VALUES (:name, :price, :amount, :category)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        
        return json_encode(['message' => 'Product added']);
        
    },
    'deleteProduct' => function ($id) {
        $stmt = myDB->prepare('DELETE FROM products WHERE code = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return json_encode(['message' => 'Product deleted']);
    },
    'putProduct' => function ($id, $amount) {
        $stmt = myDB->prepare('UPDATE products SET amount = :amount WHERE code = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':amount', $amount);
        $stmt->execute();
        return json_encode(['message' => 'Product updated']);
    }
];