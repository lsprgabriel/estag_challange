<!DOCTYPE html>
<html lang="en">

<?php 
    $orders = file_get_contents('http://localhost/api/orders');
    $orders = json_decode($orders);
?>


<head>
    <meta charset="UTF-8">
    <script src="../js/history.js" defer></script>
    <style>
        <?php include './styles/history.css'; ?>
    </style>
    <link rel="stylesheet" href="../styles/history.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
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
        <section class="table-section">
            <table id="historyTable">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Tax</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($orders as $order) {
                            echo "<tr>";
                            echo "<td>" . $order->code . "</td>";
                            echo "<td>" . $order->tax . "</td>";
                            echo "<td>" . $order->total . "</td>";
                            echo "<td><button onclick='onOrderClick(" . $order->code . ")'>Details</button></td>";
                            echo "</tr>";
                        }
                        
                        echo "
                            <script>
                                function onOrderClick(orderCode) {
                                    window.location.href = '/details/' + orderCode;
                                }
                            </script>
                        ";
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>