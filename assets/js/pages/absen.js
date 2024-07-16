document.addEventListener("DOMContentLoaded", function () {
	var openMap = L.map("map").setView(
		[-7.646184381200605, 111.54685615306134],
		13
	);

	L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
		attribution:
			'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	}).addTo(openMap);

	var marker = L.marker([-7.646184381200605, 111.54685615306134]).addTo(
		openMap
	);

	// Function to get address from coordinates
	function getAddress(lat, lon) {
		fetch(
			`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`
		)
			.then((response) => response.json())
			.then((data) => {
				document.getElementById("location").innerText = data.display_name;
			})
			.catch((error) => console.error("Error:", error));
	}

	// Get address for initial marker position
	getAddress(-7.646184381200605, 111.54685615306134);

	// Geolocation to get user's current position
	navigator.geolocation.getCurrentPosition(
		function (position) {
			var lat = position.coords.latitude;
			var lon = position.coords.longitude;
			console.log("User location found: ", lat, lon); // Debugging log
			openMap.setView([lat, lon], 13); // Set the view to the user's location with zoom level 13
			marker.setLatLng([lat, lon]);
			getAddress(lat, lon);
		},
		function (error) {
			console.error("Geolocation error: " + error.message);
		}
	);
});
