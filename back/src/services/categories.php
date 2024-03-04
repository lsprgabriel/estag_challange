<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");

require_once('pdo.php');

return [
    'getCategories' => function (): string {
        $stmt = myDB->prepare('SELECT * FROM categories');
        $stmt->execute();
        $mock_data = $stmt->fetchAll();

        return json_encode($mock_data);
    },
    'postCategories' => function ($category, $tax) {
        $category = filter_var($category, FILTER_SANITIZE_STRING);
        $tax = filter_var($tax, FILTER_SANITIZE_NUMBER_FLOAT);
        $stmt = myDB->prepare('INSERT INTO categories (name, tax) VALUES (:category, :tax)');
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':tax', $tax);
        $stmt->execute();

        return json_encode(['message' => 'Category added']);
        
    },
    'deleteCategories' => function ($code) {
        $stmt = myDB->prepare('DELETE FROM categories WHERE code = :code');
        $stmt->bindParam(':code', $code);
        $stmt->execute();

        return json_encode(['message' => 'Category deleted']);
    },
];

