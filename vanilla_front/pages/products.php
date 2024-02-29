<!DOCTYPE html>
<html lang="en">

<?php 
    $categories = file_get_contents('http://localhost/api/categories');
    $categories = json_decode($categories);

    $products = file_get_contents('http://localhost/api/products');
    $products = json_decode($products);
?>

<head>
    <meta charset="UTF-8">
    <script src="../js/products.js" defer></script>
    <style>
        <?php include './styles/products.css'; ?>
    </style>
    <link rel="stylesheet" href="../styles/products.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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
        <section class="form-section">
            <form id="productForm">
                <div class="form-input">
                    <input type="text" placeholder="Product name" name="product" required>
                </div>
                <div class="form-inputs">
                    <div>
                        <input type="number" placeholder="Amount" name="amount" min="1" required>
                    </div>
                    <div>
                        <input type="number" placeholder="Unit price" name="price" min="1" required>
                    </div>
                    <div>
                        <select id="categorySelector" name="category" required>
                            <option value="" disabled selected>Select a category</option>
                            <?php
                                foreach ($categories as $category) {
                                    echo "<option value='" . $category->code . "'>" . $category->name . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </form>
            <button onclick='postProduct();'>Add Product</button>
        </section>
        <section class="table-section">
            <table id="productsTable">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Unit price</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($products as $product) {
                        echo "<tr>";
                        echo "<td>" . $product->code . "</td>";
                        echo "<td>" . $product->name . "</td>";
                        echo "<td>" . $product->amount . "</td>";
                        echo "<td>" . $product->price . "</td>";
                        echo "<script>
                                getCategoryNameByCode(" . $product->category_code . ").then((name) => {
                                    console.log(name);
                                    document.write('<td>' + name + '</td>');
                                });

                                async function getCategoryNameByCode(code){
                                    let categories = " . json_encode($categories) . ";
                                    for(let i = 0; i < categories.length; i++){
                                        if(categories[i].code == code){
                                            console.log(categories[i].name);
                                            return categories[i].name;
                                        }
                                    }
                                }
                             </script>"; 
                        echo "<td><button onClick='onProductDelete(". $product->code .")'>Delete</button></td>";
                        echo "</tr>";
                    }
                    
                    echo '
                        <script>
                            async function postProduct(){
                                await fetch("http://localhost/api/products", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: new URLSearchParams(new FormData(document.getElementById("productForm")))
                                });
                                document.getElementById("productForm").reset();
                                location.reload();
                            }

                            async function onProductDelete(id){
                                await fetch("http://localhost/api/products/" + id, {
                                    method: "DELETE"
                                });
                                location.reload();
                            }
                        </script>
                    ';
                ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>