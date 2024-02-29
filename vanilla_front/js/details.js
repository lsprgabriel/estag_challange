const historyDocument = "history_document"
const routeDocument = "route_document"

const getHistoryStorage = () => JSON.parse(localStorage.getItem(historyDocument)) ?? []
const getRoute = () => JSON.parse(localStorage.getItem(routeDocument)) ?? []

let historyStorage = getHistoryStorage();
let route = getRoute();

const historyQuery = (code) => {
    let historyObject;
    historyStorage.map((history) => {
        if (history["code"] == code) {
            historyObject = history
        }
    });
    return historyObject;
}

const products = historyQuery(route)["products"];

for (let i = 0; i < products.length; i++) {
    let data = products[i];

    let cellData = [data.product, data.price, data.amount, data.total]

    var tbodyRef = document.getElementById('detailsTable').getElementsByTagName('tbody')[0];

    var newRow = tbodyRef.insertRow();

    for (let j = 0; j < 4; j++) {
        let cell = newRow.insertCell(j);
        if (j == 1 || j == 3) {
            cell.innerHTML = `$${cellData[j]}`
        } else {
            cell.innerHTML = cellData[j]
        }
    }
}