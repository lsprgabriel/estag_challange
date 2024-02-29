<!DOCTYPE html>
<html lang="en">

<?php 
    $products = file_get_contents('http://localhost/api/products');
    $products = json_decode($products);

    $categories = file_get_contents('http://localhost/api/categories');
    $categories = json_decode($categories);
?>

<head>
    <meta charset="UTF-8">
    <script src="./js/index.js" defer></script>
    <style>
        <?php include './styles/index.css'; ?>
    </style>
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suite Store</title>
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
        <section class="form-container">
            <form onsubmit="onCartSubmit(this)">
                <div class="form-input">
                    <select id="productsSelector" name="product" required>
                        <option value="" disabled selected>Select a product</option>
                        <?php
                            foreach ($products as $product) {
                                echo "<option value='" . $product->code . "'>" . $product->name . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-inputs">
                    <div class="amount-input">
                        <input type="number" placeholder="Amount" name="amount" id="amount" min="1" required>
                    </div>
                    <div class="tax-value-input">
                        <input type="number" placeholder="Tax" name="tax" id="tax" disabled>
                    </div>
                    <div class="unit-price-input">
                        <input type="number" placeholder="Price" name="price" id="price" disabled>
                    </div>
                </div>
                <button type="submit">Add Product</button>
            </form>
        </section>
        <div class="vl"></div>
        <section class="table-section">
            <table id="cartTable">
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
            <div class="tax-total">
                <div class="tax-total-input">
                    <label for="">Tax:</label>
                    <input type="text" placeholder="$0"  name="" id="totalTax" disabled>
                </div>
                <div class="tax-total-input">
                    <label for="">Total:</label>
                    <input type="text" placeholder="$0" name="" id="totalPrice" disabled>
                </div>
            </div>
            <div class="table-section-buttons">
                <button onClick="onCancel()">Cancel</button>
                <button onClick="onFinish()">Finish</button>
            </div>
        </section>
    </main>
    <?php 
        echo "
            <script>
                document.getElementById('productsSelector').addEventListener('change', (e) => {
                    let product = " . json_encode($products) . ".find((product) => product.code == e.target.value);
                    console.log(product);
                    document.getElementById('tax').value = getTaxByCode(product.category_code);
                    document.getElementById('price').value = product.price;
                });

                function getTaxByCode(code){
                    let category = " . json_encode($categories) . ".find((category) => category.code == code);
                    return category.tax;
                }
            </script>
        ";
    
    ?>
</body>
</html>