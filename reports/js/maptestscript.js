// script.js

// Initialize Leaflet map
const map = L.map("map").setView([51.505, -0.09], 13); // Set initial map center and zoom level
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);

// Function to copy location to clipboard
function copyLocationToClipboard(latitude, longitude) {
    // Format the location as a string
    const location = `Latitude: ${latitude.toFixed(6)}, Longitude: ${longitude.toFixed(6)}`;

    // Create a textarea element to temporarily hold the location text
    const tempTextarea = document.createElement("textarea");
    tempTextarea.value = location;
    document.body.appendChild(tempTextarea);

    // Select the text inside the textarea
    tempTextarea.select();
    tempTextarea.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text to the clipboard
    document.execCommand("copy");

    // Remove the temporary textarea
    document.body.removeChild(tempTextarea);

    // Provide feedback to the user (you can customize this part)
    alert("Location copied to clipboard: " + location);
}

// Add a click event listener to the map
map.on("click", function (e) {
    // When the map is clicked, capture the latitude and longitude and store them in variables
    const latitude = e.latlng.lat;
    const longitude = e.latlng.lng;

    // Store the latitude and longitude in a data attribute of the button
    const copyButton = document.getElementById("copy-location-button");
    copyButton.dataset.latitude = latitude;
    copyButton.dataset.longitude = longitude;
});

// Add a click event listener to the copy location button
const copyButton = document.getElementById("copy-location-button");
if (copyButton) {
    copyButton.addEventListener("click", function () {
        const latitude = parseFloat(copyButton.dataset.latitude);
        const longitude = parseFloat(copyButton.dataset.longitude);
        copyLocationToClipboard(latitude, longitude);
    });
}
