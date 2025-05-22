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
                    window.location.href = `authorize.php?redirect=booking.php&flight_id=${flight.id}`;
                };

                resultsContainer.appendChild(flightCard);
            });
        })
        .catch(error => console.error('Error fetching flights:', error));
}

function updateDestinationCities() {
    const departure = document.getElementById('departure').value;

    const destinationSelect = document.getElementById('destination');
    destinationSelect.innerHTML = "<option value=''>Select Destination City</option>";

    if (!departure) {
        return; 
    }

    fetch(`get_destinations.php?departure=${departure}`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                data.forEach(destination => {
                    const option = document.createElement("option");
                    option.value = destination;
                    option.textContent = destination;
                    destinationSelect.appendChild(option);
                });
            } else {
                const option = document.createElement("option");
                option.value = '';
                option.textContent = "No destinations found";
                destinationSelect.appendChild(option);
            }
        })
        .catch(error => console.error('Error fetching destinations:', error));
}


function updateAvailableDates() {
    fetch('get_available_dates.php')
        .then(response => response.json())
        .then(data => {
            const flightDateInput = document.getElementById('flight_date');
            
            flightDateInput.removeAttribute("min");
            flightDateInput.removeAttribute("max");

            const availableDates = data;

            availableDates.forEach(date => {
                const formattedDate = date;

                let dateOption = document.createElement("option");
                dateOption.value = formattedDate;
                dateOption.setAttribute("disabled", "disabled");
            });

        })
        .catch(error => console.error('Error fetching available dates:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    updateAvailableDates();
});

let fpInstance = null;

function fetchAndDisableDates() {
    const departure = document.getElementById('departure').value;
    const destination = document.getElementById('destination').value;

    if (!departure || !destination) return;

    fetch(`get_available_dates.php?departure=${encodeURIComponent(departure)}&destination=${encodeURIComponent(destination)}`)
        .then(response => response.json())
        .then(availableDates => {

            if (window.flightDatePicker) {
                window.flightDatePicker.destroy();
            }

            window.flightDatePicker = flatpickr("#flight_date", {
                dateFormat: "Y-m-d",
                mode: "single",
                enable: availableDates,
                onChange: function(selectedDates, dateStr) {
                
                    fetchFlights();
                }
            });
        })
        .catch(err => console.error('Error fetching available dates:', err));
}


document.addEventListener('DOMContentLoaded', fetchAndDisableDates);
document.getElementById('departure').addEventListener('change', fetchAndDisableDates);
document.getElementById('destination').addEventListener('change', fetchAndDisableDates);