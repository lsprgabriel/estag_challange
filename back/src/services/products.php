<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");

require_once('pdo.php');

class Products {
    public function getProducts() {
        $stmt = myDB->prepare('SELECT * FROM products');
        $stmt->execute();
        $mock_data = $stmt->fetchAll();

        return json_encode($mock_data);
    }

    public function postProducts($name, $price, $amount, $category) {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT);
        $amount = filter_var($amount, FILTER_SANITIZE_NUMBER_INT);
        $category = filter_var($category, FILTER_SANITIZE_NUMBER_INT);

        $stmt = myDB->prepare('INSERT INTO products (name, price, amount, category_code) VALUES (:name, :price, :amount, :category)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':category', $category);
        $stmt->execute();

        return json_encode(['message' => 'Product added']);
    }

    public function deleteProduct($id) {
        $stmt = myDB->prepare('DELETE FROM products WHERE code = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return json_encode(['message' => 'Product deleted']);
    }

    public function putProduct($id, $amount) {
        $stmt = myDB->prepare('UPDATE products SET amount = :amount WHERE code = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':amount', $amount);
        $stmt->execute();
        return json_encode(['message' => 'Product updated']);
    }
}