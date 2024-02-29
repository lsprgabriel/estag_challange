<!DOCTYPE html>
<html lang="en">
<?php 
    $categories = file_get_contents('http://localhost/api/categories');
    $categories = json_decode($categories);
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/categories.css">
    <style>
        <?php include './styles/categories.css'; ?>
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
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
        <form id="categoryForm">
            <div class="">
                <input type="text" placeholder="Category name" name="category" id="categoryValue" >
            </div>
            <div class="">
                <input type="number" placeholder="Tax" name="tax" id="taxValue" >
            </div>
        </form>
        <button onclick='postCategory();'>Add Category</button>
    </section>
    <section class="table-section">
        <table id="categoriesTable">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Tax</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($categories as $category) {
                        echo "<tr>";
                        echo "<td>" . $category->code . "</td>";
                        echo "<td>" . $category->name . "</td>";
                        echo "<td>" . $category->tax . "</td>";
                        echo "<td><button onClick='onCategoryDelete(". $category->code .")'>Delete</button></td>";
                        echo "</tr>";
                    }
                    
                    echo '
                        <script>
                            async function postCategory(){
                                await fetch("http://localhost/api/categories", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: new URLSearchParams(new FormData(document.getElementById("categoryForm")))
                                });
                                document.getElementById("categoryForm").reset();
                                location.reload();
                            } 

                            async function onCategoryDelete(id){
                                await fetch("http://localhost/api/categories/" + id, {
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
