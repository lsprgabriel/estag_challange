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
            <form id="cartForm" onsubmit="onCartSubmit(this)">
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
            </form>
            <button onclick="onCartSubmit();">Add Product</button>
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
            doc = 'cart_document';
            getCartStorage = () => JSON.parse(localStorage.getItem(doc)) ?? []

            const cart = getCartStorage();

            let totalTax = 0;
            let totalPrice = 0;
            cart.forEach((product, index) => {
                const { name, amount, tax, price, total } = product;
                totalTax += (tax * amount);
                totalPrice += total;
                document.querySelector('#cartTable tbody').innerHTML += `
                    <tr>
                        <td>` + name + `</td>
                        <td>` + price + `</td>
                        <td>` + amount + `</td>
                        <td>` + total + `</td>
                        <td><button onClick='deleteCartData(` + index + `)'>Delete</button></td>
                    </tr>
                `
            });

            document.getElementById('totalTax').placeholder = totalTax.toFixed(2);
            document.getElementById('totalPrice').placeholder = totalPrice.toFixed(2);

        </script>";
    ?>
    <?php 
        echo "
            <script>
                document.getElementById('productsSelector').addEventListener('change', (e) => {
                    let product = " . json_encode($products) . ".find((product) => product.code == e.target.value);
                    document.getElementById('tax').value = ((getTaxByCode(product.category_code) / 100) * product.price).toFixed(2);
                    document.getElementById('price').value = product.price;
                });

                function getTaxByCode(code){
                    let category = " . json_encode($categories) . ".find((category) => category.code == code);
                    return category.tax;
                }

                let doc = 'cart_document';
                const getCartStorage = () => JSON.parse(localStorage.getItem(doc)) ?? []
                const setCartStorage = (data) => localStorage.setItem(doc, JSON.stringify(data)) 

                const addCartData = (data) => {
                    const dbCart = getCartStorage();
                    dbCart.push(data);
                    setCartStorage(dbCart);
                }

                const deleteCartData = (index) => {
                    const dbCart = getCartStorage();
                    dbCart.splice(index, 1);
                    setCartStorage(dbCart);
                    location.reload();
                }

                function getProductByCode(code){
                    let products = " . json_encode($products) . ";
                    for(let i = 0; i < products.length; i++){
                        if(products[i].code == code){
                            return products[i].name;
                        }
                    }
                }

                async function onCartSubmit(){
                    let name = document.getElementById('productsSelector').value;
                    let amount = document.getElementById('amount').value;
                    let tax = document.getElementById('tax').value;
                    let price = document.getElementById('price').value;
                    let total = amount * price;
                    code = parseInt(name);
                    name = getProductByCode(parseInt(name));

                    const products = await fetch('http://localhost/api/products');
                    const productsData = await products.json();

                    const product = productsData.find((product) => product.code == code);

                    if (amount < 1) {
                        alert('Amount must be greater than 0');
                        return;
                    } 

                    if (amount > product.amount) {
                        alert('Not enough stock');
                        return;
                    } else {
                        let newAmount = product.amount - amount;
                        console.log(newAmount);
                        await fetch('http://localhost/api/products/' + code, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({
                                amount: newAmount,
                            })
                        })
                    }

                    addCartData({code, name, amount, tax, price, total});

                    document.getElementById('cartForm').reset();
                    location.reload();
                }

                function onCancel(){
                    localStorage.removeItem('cart_document');
                    location.reload();
                }

                function onFinish() {
                    let cart = getCartStorage();
                    let totalTax = 0;
                    let totalPrice = 0;
                    cart.forEach((product) => {
                        totalTax += (product.tax * product.amount);
                        totalPrice += product.total;
                    });

                    fetch('http://localhost/api/orders', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            total: totalPrice,
                            tax: totalTax
                        })
                    }).then(async (order) => {

                            const response = await fetch('http://localhost/api/orders')

                            const data = await response.json();

                            const orderCode = data[data.length - 1].code;

                            cart.forEach((product) => {
                                fetch('http://localhost/api/order_items', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: new URLSearchParams({
                                        order_code: orderCode,
                                        product_code: product.code,
                                        amount: product.amount,
                                        tax: product.tax,
                                        price: product.price
                                    })
                                })
                            })
                        }).then(() => {
                            alert('Order finished');
                            localStorage.removeItem('cart_document');
                            location.reload();
                        })
                        
                }
            </script>";
    
    ?>
</body>
</html>