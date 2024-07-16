$(document).ready(function () {
	function updateClock() {
		const clockElement = document.getElementById("clock");
		const now = new Date();
		const hours = now.getHours().toString().padStart(2, "0");
		const minutes = now.getMinutes().toString().padStart(2, "0");
		clockElement.textContent = `${hours}:${minutes}`;
	}

	// Update the clock immediately when the page loads
	updateClock();

	// Update the clock every minute
	setInterval(updateClock, 60000);
});
