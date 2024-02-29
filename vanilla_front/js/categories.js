const doc = "categories_document"

const getCategoryStorage = () => JSON.parse(localStorage.getItem(doc)) ?? []
const setCategoryStorage = (data) => localStorage.setItem(doc, JSON.stringify(data))

const addCategoryData = (data) => {
    const dbCart = getCategoryStorage();
    dbCart.push(data);
    setCategoryStorage(dbCart);
}

const deleteCategoryData = (index) => {
    const dbCart = getCategoryStorage();
    dbCart.splice(index, 1);
    setCategoryStorage(dbCart);
}

let storage = getCategoryStorage();

const setInitialCategoryStorage = () => {
    let categoryCode = 0;
    if (storage.length == 0) {
        let initCategoryData = [
            {
                code: 0,
                category: "Food",
                tax: 10,
            },
            {
                code: 0,
                category: "Electro",
                tax: 40,
            },
            {
                code: 0,
                category: "Clothing",
                tax: 20,
            }
        ]
        initCategoryData.map((data) => {
            addCategoryData({
                code: categoryCode,
                category: data.category,
                tax: data.tax,
            })
            categoryCode += 1
        })
    }
}

setInitialCategoryStorage();

for (let i = 0; i < storage.length; i++) {
    let data = storage[i];

    let cellData = [data.code, data.category, data.tax,
    `<td><button onClick='onCategoryDelete(${i})'>Delete</button></td>`
    ]

    var tbodyRef = document.getElementById('categoriesTable').getElementsByTagName('tbody')[0];

    var newRow = tbodyRef.insertRow();

    for (let j = 0; j < 4; j++) {
        let cell = newRow.insertCell(j);
        if (j == 2) {
            cell.innerHTML = `${cellData[j]}%`
        } else {
            cell.innerHTML = cellData[j]
        }
    }
    
}

const onCategorySubmit = (form) => {
    alert("Category successfully added!");

    addCategoryData({
        code: storage.length,
        category: sanitizeHtml(form.category.value),
        tax: form.tax.value
    })
}

function sanitizeHtml(str) {
    return str.replace(/[^\w. ]/gi, function (c) {
        return "&#" + c.charCodeAt(0) + ";";
    });
}

const onCategoryDelete = (index) => {
    deleteCategoryData(index);
    window.location.reload();
}
