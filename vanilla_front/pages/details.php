<!DOCTYPE html>
<html lang="en">
<?php 
    $orders = file_get_contents('http://localhost/api/orders');
    $orders = json_decode($orders);
?>

<head>
    <meta charset="UTF-8">
    <script src="../js/details.js" defer></script>
    <style>
        <?php include './styles/details.css'; ?>
    </style>
    <link rel="stylesheet" href="../styles/details.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
</head>

<body>
    <header class="navbar">
        <a class="logo" href="/">Suite Store</a>
        <ul>
            <li><a href="/products">Products</a></li>
            <li><a href="/categories">Categories</a></li>
            <li><a href="/history">History</a></li>
        </ul>
    </header>
    <main>
        <section class="product-section">
            <div class="product-name">
                <h1>Your purchase:</h1>
            </div>
                <table id="detailsTable">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $request = $_SERVER['REQUEST_URI'];

                        function getDetailsIdFromUrl($url){
                            $url = explode('/', $url);
                            return $url[count($url) - 1];
                        }

                        $order_items = file_get_contents('http://localhost/api/order_items');
                        $order_items = json_decode($order_items);

                        function getProductNameByCode($code){
                            $products = file_get_contents('http://localhost/api/products');
                            $products = json_decode($products);
                            foreach ($products as $product) {
                                if ($product->code == $code) {
                                    return $product->name;
                                }
                            }
                        }

                        foreach ($order_items as $order_item) {
                            if ($order_item->order_code == getDetailsIdFromUrl($request)) {
                                echo "<tr>";
                                echo "<td>" . getProductNameByCode($order_item->product_code) . "</td>";
                                echo "<td>" . $order_item->price . "</td>";
                                echo "<td>" . $order_item->amount . "</td>";
                                echo "<td>" . $order_item->price * $order_item->amount . "</td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                    </tbody>
                </table>
        </section>
    </main>
</body>
</html>
