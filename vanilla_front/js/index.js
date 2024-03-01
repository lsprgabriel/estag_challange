const doc = "cart_document"
const productsDocument = "products_document"
const historyDocument = "history_document"

const getCartStorage = () => JSON.parse(localStorage.getItem(doc)) ?? []
const getProductsStorage = () => JSON.parse(localStorage.getItem(productsDocument)) ?? []
const getHistoryStorage = () => JSON.parse(localStorage.getItem(historyDocument)) ?? []

const setCartStorage = (data) => localStorage.setItem(doc, JSON.stringify(data)) 
const setHistoryStorage = (data) => localStorage.setItem(historyDocument, JSON.stringify(data))

const addCartData = (data) => {
    const dbCart = getCartStorage();
    dbCart.push(data);
    setCartStorage(dbCart);
}

const addHistoryData = (data) => {
    const dbHist = getHistoryStorage();
    dbHist.push(data);
    setHistoryStorage(dbHist);
}

const deleteCartData = (index) => {
    const dbCart = getCartStorage();
    dbCart.splice(index, 1);
    setCartStorage(dbCart);
}

const clearCartStorage = () => {
    setCartStorage([]);
}

let storage = getCartStorage();
let productsStorage = getProductsStorage();
let historyStorage = getHistoryStorage();

const productsQuery = (code) => {
    let productObject;
    productsStorage.map((product) => {
        if (product["code"] == code) {
            productObject = product
        }
    });
    return productObject;
}


let totalPrice = 0;
let totalTax = 0;

for(let i = 0; i < storage.length; i++) {
    let data = storage[i];
    totalPrice = totalPrice + data.total;
    totalTax = totalTax + productsQuery(data.code).unitTax * data.amount
    let cellData = [ data.product, data.price, data.amount, data.total,
        `<td><button onClick='onCartDelete(${i})'>Delete</button></td>`
    ]
    
    var tbodyRef = document.getElementById('cartTable').getElementsByTagName('tbody')[0];
    
    var newRow = tbodyRef.insertRow();
    
    for(let j = 0; j < 5; j++) {
        let cell = newRow.insertCell(j);
        if (j == 1 || j == 3) {
            cell.innerHTML = `$${cellData[j]}`
        } else {
            cell.innerHTML = cellData[j]
        }
    }
}

document.getElementById("totalPrice").value = `$${ (totalPrice).toFixed(2) }`;
document.getElementById("totalTax").value = `$${(totalTax).toFixed(2)}`;

const onCartSubmit = (form) => {
    alert("Product successfully added!");
    
    addCartData({
        code: form.product.value,
        product: productsQuery(form.product.value).product,
        price: productsQuery(form.product.value).totalUnitPrice,
        amount: form.amount.value,
        total: Number((productsQuery(form.product.value).totalUnitPrice * form.amount.value).toFixed(2)),
    })
}

const onCartDelete = (index) => {
    deleteCartData(index);
    window.location.reload();
}

const onCancel = () => {
    alert("Purchase successfully canceled!");
    clearCartStorage();
    window.location.reload();
}

const onFinish = () => {
    alert("Success! You finished your purchase!");
    addHistoryData({
        code: historyStorage.length,
        products: storage,
        tax: totalTax,
        total: totalPrice
    })
    clearCartStorage();
    window.location.reload();
}