function fetchFlights() {
    const departure = document.getElementById('departure').value;
    const destination = document.getElementById('destination').value;
    const flightDate = document.getElementById('flight_date').value;

    fetch(`fetch_flights.php?departure=${departure}&destination=${destination}&date=${flightDate}`)
        .then(response => response.json())
        .then(data => {
            const resultsContainer = document.getElementById('flight-results');
            resultsContainer.innerHTML = "";

            if (data.length === 0) {
                resultsContainer.innerHTML = "<p>No flights found</p>";
                return;
            }

            data.forEach(flight => {
                const flightCard = document.createElement("div");
                flightCard.classList.add("flight-card");

                flightCard.innerHTML = `
                <div class="flight-details">
                    <strong>${flight.airline}</strong>
                    <p>${flight.departure} ➝ ${flight.destination}</p>
                    <p>Departure: ${flight.departure_time} | Arrival: ${flight.arrival_time}</p>
                    <p class="flight-price">€${flight.price}</p>
                </div>
                <a href="booking.php?flight_id=${flight.id}" class="book-btn">Book Now</a>
            `;

            flightCard.onclick = () => {
                window.location.href = `booking.php?flight_id=${flight.id}`;
            };

            resultsContainer.appendChild(flightCard);
            });
        })
        .catch(error => console.error('Error fetching flights:', error));
}