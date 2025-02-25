function fetchFlights() {
    const departure = document.getElementById('departure').value;
    const destination = document.getElementById('destination').value;
    const flightDate = document.getElementById('flight_date').value;

    fetch(`fetch_flights.php?departure=${departure}&destination=${destination}&date=${flightDate}`)
        .then(response => response.json())
        .then(data => {
            const resultsTable = document.getElementById('flight-results');
            resultsTable.innerHTML = "";

            if (data.length === 0) {
                resultsTable.innerHTML = "<tr><td colspan='7'>No flights found</td></tr>";
                return;
            }

            data.forEach(flight => {
                const row = `<tr>
                    <td>${flight.airline}</td>
                    <td>${flight.departure}</td>
                    <td>${flight.destination}</td>
                    <td>${flight.departure_time}</td>
                    <td>${flight.arrival_time}</td>
                    <td>€${flight.price}</td>
                    <td>${flight.flight_date}</td>
                </tr>`;
                resultsTable.innerHTML += row;
            });
        })
        .catch(error => console.error('Error fetching flights:', error));
}