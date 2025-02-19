document.addEventListener("DOMContentLoaded", function () {
    let selectedSeat = null;

    document.querySelectorAll(".seat").forEach(seat => {
        seat.addEventListener("click", function () {
            if (!this.classList.contains("occupied")) {
                document.querySelectorAll(".seat").forEach(s => s.classList.remove("selected"));
                this.classList.add("selected");
                selectedSeat = this.getAttribute("data-seat");
            }
        });
    });

    document.getElementById("confirm-btn").addEventListener("click", function () {
        if (!selectedSeat) {
            alert("Please select a seat.");
            return;
        }

        fetch("process_seat.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `seat=${selectedSeat}`
        })
        .then(response => response.text())
        .then(response => {
            if (response === "success") {
                alert("Seat booked successfully.");
                location.reload();
            } else {
                alert("Seat already booked. Try another.");
            }
        });
    });
});

