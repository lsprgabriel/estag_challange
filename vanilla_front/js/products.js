const doc = "products_document"
const categoriesDocument = "categories_document"

const getProductsStorage = () => JSON.parse(localStorage.getItem(doc)) ?? []
const getCategoriesStorage = () => JSON.parse(localStorage.getItem(categoriesDocument)) ?? []

const setProductsStorage = (data) => localStorage.setItem(doc, JSON.stringify(data))

const addProductsData = (data) => {
    const dbProduct = getProductsStorage();
    dbProduct.push(data);
    setProductsStorage(dbProduct);
}

const deleteProductsData = (index) => {
    const dbProduct = getProductsStorage();
    dbProduct.splice(index, 1);
    setProductsStorage(dbProduct);
}

const clearProductsStorage = () => {
    setProductsStorage([]);
}

let productsStorage = getProductsStorage();
let categoriesStorage = getCategoriesStorage();

const categoriesQuery = (code) => {
    let categoryObject;
    categoriesStorage.map((category) => {
        if(category["code"] == code) {
            categoryObject = category
        }
    });
    return categoryObject;
}

categoriesStorage.map((category) => {
    let select = document.getElementById("categorySelector");
    let option = document.createElement("option");
    option.text = category.category;
    option.value = category.code;
    select.add(option);
})

for (let i = 0; i < productsStorage.length; i++) {
    let data = productsStorage[i];

    let cellData = [data.code, data.product, data.amount, data.unitPrice, data.unitTax, data.totalUnitPrice, data.category,
    `<td><button onClick='onProductsDelete(${i})'>Delete</button></td>`,
    ]

    var tbodyRef = document.getElementById('productsTable').getElementsByTagName('tbody')[0];

    var newRow = tbodyRef.insertRow();

    for (let j = 0; j < 8; j++) {
        let cell = newRow.insertCell(j);
        if (j == 3 || j == 4 || j == 5) {
            cell.innerHTML = `$${cellData[j]}`
        } else {
            cell.innerHTML = (cellData[j])
        }
    }

}

const onProductSubmit = (form) => {
    alert("Product successfully added!");

    const taxPercentage = categoriesQuery(form.category.value).tax / 100

    addProductsData({
        code: productsStorage.length,
        product: sanitizeHtml(form.product.value),
        amount: form.amount.value,
        unitPrice: form.price.value,
        unitTax: (taxPercentage * form.price.value).toFixed(2),
        totalUnitPrice: ((1 + taxPercentage) * form.price.value).toFixed(2),
        category: categoriesQuery(form.category.value).category
    })
}

function sanitizeHtml(str) {
    return str.replace(/[^\w. ]/gi, function (c) {
        return "&#" + c.charCodeAt(0) + ";";
    });
}

const onProductsDelete = (index) => {
    deleteProductsData(index);
    window.location.reload();
}

const onProductsView = (index) => {
    console.log("VIEWING ", index)
}