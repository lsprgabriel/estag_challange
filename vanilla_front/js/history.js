const doc = "history_document"
const routeDocument = "route_document"

const getHistoryStorage = () => JSON.parse(localStorage.getItem(doc)) ?? []

const getRoute = () => JSON.parse(localStorage.getItem(routeDocument)) ?? []
const setRoute = (route) => localStorage.setItem(routeDocument, JSON.stringify(route))

let storage = getHistoryStorage();

console.log(storage)

for (let i = 0; i < storage.length; i++) {
    let data = storage[i];

    let cellData = [data.code, data.tax, data.total,
    `<td><button onClick="viewHistory(${i})">View</button></td>`,
    ]

    var tbodyRef = document.getElementById('historyTable').getElementsByTagName('tbody')[0];

    var newRow = tbodyRef.insertRow();

    for (let j = 0; j < 4; j++) {
        let cell = newRow.insertCell(j);
        if (j == 1 || j == 2) {
            cell.innerHTML = `$${cellData[j].toFixed(2)}`
        } else {
            cell.innerHTML = (cellData[j])
        }
    }
}

const viewHistory = (index) => {
    setRoute(index);
    window.location.href = "/pages/details.html"
}