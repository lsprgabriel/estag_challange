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

        $code = file_get_contents('http://localhost/api/categories');
        $code = json_decode($code);
        $code = count($code) + 1;

        $stmt = myDB->prepare('INSERT INTO categories (name, tax, code) VALUES (:category, :tax, :code)');
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':tax', $tax);
        $stmt->bindParam(':code', $code);
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

