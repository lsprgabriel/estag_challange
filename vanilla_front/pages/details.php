<!DOCTYPE html>
<html lang="en">

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
                    </tbody>
                </table>
        </section>
    </main>
</body>
</html>

<?php 
    $request = $_SERVER['REQUEST_URI'];

    echo getDetailsIdFromUrl($request);

    function getDetailsIdFromUrl($url){
        $url = explode('/', $url);
        return $url[count($url) - 1];
    }
?>