// =========================
// Dashboard JS --- starts
// =========================

$(document).ready(function() {
    // Function to create table rows from dynamic data
    function createTableRows(data) {
        let tableBody = $('tbody');
        tableBody.empty(); // Clear existing rows
        let baseURL='http://localhost:3000/img/'

        data.forEach((row, index) => {
            // Create main data row
            let statusClass = `status-${row.status.toLowerCase()}`
            const dayOfWeek = new Date(row.date).toLocaleDateString('en-US', { weekday: 'long' }).toLocaleLowerCase();
            let dayClass, daystat;
            if(dayOfWeek == 'sunday'){
                dayClass = 'sunday-blue';
            } else if(dayOfWeek == 'saturday'){
                dayClass = 'saturday-class';
            } else {
                dayClass = '';
            }
            if(row.daystat != '' ){
                daystat = row.daystat=='leave'?' L':row.daystat=='holiday'?'H':'W';
            } else{
                daystat = 'W'
            }
            const totalFoodExpense = row.foodExpense.reduce((sum, expense) => {
                        return sum +
                            parseFloat(expense.breakfast.amount) +
                            parseFloat(expense.lunch.amount) +
                            parseFloat(expense.dinner.amount);
            }, 0);
            const totalTravelExp = row.travelEntries.reduce((sum, expense) => {
                        return sum +
                            parseFloat(expense.tollCharges) +
                            parseFloat(expense.fuelCharges);
            }, 0);
            const totalMiscExp = row.miscExpense.reduce((sum, expense) => {
                        return sum +
                            parseFloat(expense.amount);
            }, 0);
            const grandTotal = parseFloat(totalMiscExp) + parseFloat(totalTravelExp) + parseFloat(totalFoodExpense);
            let mainRow = `
                <tr class="${dayClass}">
                    <td>
                        <div class="checkbox-wrapper">
                            <input type="checkbox" class="form-check-input row-checkbox">
                        </div>
                    </td>
                    <td>${row.date}<span class="d-stat">${daystat}<span></td>
                    <td>${row.inTime}</td>
                    <td>${row.outTime}</td>
                    <td>${totalTravelExp}</td>
                    <td>${totalFoodExpense}</td>
                    <td>${totalMiscExp}</td>
                    <td>${grandTotal}</td>
                    <td><span class="${statusClass}">${row.status}</span></td>
                    <td>
                        <i class="bi bi-chevron-down toggle-icon" data-bs-toggle="collapse" data-bs-target="#collapse${index}"></i>
                    </td>
                </tr>`;

            // Create collapsible content row
            let contentRow = `
                <tr>
                    <td colspan="10" class="p-0">
                        <div id="collapse${index}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="exp-card-wrapper">
                                    <div class="exp-data-wrapper food-exp-data">
                                        <div class="exp-card-title">Expense Details</div>
                                        <div class="exp-data">
                                            <span class="exp-title">Date</span>
                                            <span class="exp-value">${row.date}</span>
                                        </div>
                                        <div class="exp-data">
                                            <span class="exp-title">In Time</span>
                                            <span class="exp-value">${row.inTime}</span>
                                        </div>
                                        <div class="exp-data">
                                            <span class="exp-title">Out Time</span>
                                            <span class="exp-value">${row.outTime}</span>
                                        </div>                
                                    </div>
                                    <div class="exp-data-wrapper food-exp-data">
                                        <div class="exp-card-title">Food Expense</div>
                                        <div class="exp-data">
                                            <span class="exp-title">Breakfast</span>
                                            <span class="exp-value">&#8377;${row.foodExpense[0].breakfast.amount || 0}</span>
                                            <span class="exp-bill-copy"><a href="${baseURL}${row.foodExpense[0].breakfast.files[0].name}"><i class="fa-solid fa-file"></i></a></span>
                                        </div>
                                        <div class="exp-data">
                                            <span class="exp-title">Lunch</span>
                                            <span class="exp-value">&#8377;${row.foodExpense[0].lunch.amount || 0}</span>
                                            <span class="exp-bill-copy"><a href="${baseURL}${row.foodExpense[0].lunch.files[0].name}"><i class="fa-solid fa-file"></i></a></span>
                                        </div>
                                        <div class="exp-data">
                                            <span class="exp-title">Dinner</span>
                                            <span class="exp-value">&#8377;${row.foodExpense[0].dinner.amount || 0}</span>
                                            <span class="exp-bill-copy"><a href="${baseURL}${row.foodExpense[0].dinner.files[0].name}"><i class="fa-solid fa-file"></i></a></span>
                                        </div>                
                                    </div>
                                    <div class="exp-data-wrapper misc-exp-data">
                                        <div class="exp-card-title">Miscellaneous Expense</div>
                                        ${row.miscExpense.map(misc => `
                                        <div class="exp-data">
                                            <span class="exp-title">${misc.type}</span>
                                            <span class="exp-value">&#8377;${misc.amount}</span>
                                            <span class="exp-bill-copy">
                                                ${misc.files?.map(file => `
                                                    <a href="${baseURL}${file.name}"><i class="fa-solid fa-file"></i></a>
                                                `).join('')}
                                            </span>
                                        </div>
                                        `).join('')}
                                    </div>
                                    <div class="exp-data-wrapper travel-exp-data">
                                        <div class="exp-card-title">Travel Expense</div>
                                        <div class="exp-data exp-table">
                                            <div class="exp-row row-header">
                                                <span class="exp-title">Transport Mode</span>
                                                <span class="exp-title">Starting Meter</span>
                                                <span class="exp-title">Closing Meter</span>
                                                <span class="exp-title">Total KM</span>
                                                <span class="exp-title">Places Visited</span>
                                                <span class="exp-title">Claim</span>
                                                 <span class="exp-title">Toll</span>
                                                <span class="exp-title exp-bill-copy">Bill Copy</span>
                                            </div>
                                            <div class="row-body">
                                                ${row.travelEntries.map(travelEntry => `
                                                    <div class="exp-row">
                                                        <span class="exp-value">${travelEntry.typeOfTransport} - ${travelEntry.modeOfTransport}</span>
                                                        <span class="exp-value">${travelEntry.startingMeter}</span>
                                                        <span class="exp-value">${travelEntry.closingMeter}</span>
                                                        <span class="exp-value">${travelEntry.totalKms}</span>
                                                        <span class="exp-value">${travelEntry.placesVisited}</span>
                                                        <span class="exp-value">&#8377;${travelEntry.fuelCharges}</span>
                                                        <span class="exp-value">&#8377;${travelEntry.tollCharges}</span>
                                                        <span class="exp-value exp-bill-copy">
                                                            ${travelEntry.files?.map(file => `
                                                                <a href="${baseURL}${file.name}"><i class="fa-solid fa-file"></i></a>
                                                            `).join('')}
                                                        </span>
                                                    </div>
                                                `).join('')}
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>`;

            tableBody.append(mainRow + contentRow);
        });
    }

    // Example data structure
    const expenseData = [
        {
            date: '01-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"leave",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"100",
                fuelCharges:"745",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            },
            {
                modeOfTransport:"Demo Van",
                typeOfTransport:"Bike",
                startingMeter:"20003",
                closingMeter:"80303",
                totalKms:"300",
                tollCharges:"100",
                fuelCharges:"745",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"10.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"100.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"20.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"Courier Bill",
                amount:"10.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            },
            {
                type:"Xerox & Stationary",
                amount:"200.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            },
            {
                type:"Office Expense",
                amount:"982.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        },
        {
            date: '02-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"holiday",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        },
        {
            date: '03-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:'',
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        },
        {
            date: '04-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        },
        {
            date: '05-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        },
        {
            date: '06-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        },
        {
            date: '07-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        },
        {
            date: '08-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        },
        {
            date: '09-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        },
        {
            date: '10-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        }
        ,
        {
            date: '11-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        }
        ,
        {
            date: '12-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        }
        ,
        {
            date: '13-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        }
        ,
        {
            date: '14-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        }
        ,
        {
            date: '15-Jan-2024',
            inTime:"07:00",
            outTime:"21:00",
            daystat:"",
            travelEntries:[{
                modeOfTransport:"Personal Vehicle",
                typeOfTransport:"Bike",
                startingMeter:"10003",
                closingMeter:"10303",
                totalKms:"300",
                tollCharges:"200",
                fuelCharges:"245",
                placesVisited:"Koralur",
                files:[{name: "LTC.pdf", type: "application/pdf", timestamp: 1734171449052},{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            foodExpense: [{
                breakfast:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                lunch:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]},
                dinner:{"amount":"0.00","files":[{name: "das.png", type: "application/png", timestamp: 1734171449052}]}
            }],
            miscExpense: [{
                type:"",
                amount:"0.00",
                files:[{name: "das.png", type: "application/png", timestamp: 1734171449052}]
            }],
            total: '₹1200',
            status: 'Pending'
        }
    ];


    // Initialize table with data
    createTableRows(expenseData);

    // Re-initialize event handlers after creating rows
    initializeEventHandlers();
});

function initializeEventHandlers() {
    // Select All checkbox functionality
    $('#selectAll').change(function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Individual checkbox handler
    $('.row-checkbox').change(function() {
        let allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
        $('#selectAll').prop('checked', allChecked);
    });

    // Accordion toggle handler
    $('.toggle-icon').click(function() {
        var $this = $(this);
        var $target = $($this.data('bs-target'));
        
        // Close all other accordions
        $('.accordion-collapse.show').not($target).collapse('hide');
        $('.toggle-icon.rotated').not($this).removeClass('rotated');
        
        // Toggle the clicked accordion
        $target.collapse('toggle');
        $this.toggleClass('rotated');
    });

    // Accordion events
    $('.accordion-collapse').on('show.bs.collapse', function() {
        $(this).closest('tr').prev()
            .find('.toggle-icon')
            .addClass('rotated');
    });

    $('.accordion-collapse').on('hide.bs.collapse', function() {
        $(this).closest('tr').prev()
            .find('.toggle-icon')
            .removeClass('rotated');
    });
}
// ===========================
// Dashboard JS --- Ends Here
// ===========================