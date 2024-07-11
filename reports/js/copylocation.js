// script.js

// Function to copy dynamic location to clipboard
function copyDynamicLocationToClipboard() {
    // Check if geolocation is available in the browser
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            const location = `https://www.google.com/maps?q=${latitude},${longitude}`;

            // const location = `Latitude: ${latitude}, Longitude: ${longitude}`;

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
            alert("Dynamic location copied to clipboard: " + location);
        });
    } else {
        alert("Geolocation is not available in your browser.");
    }
}

// Add a click event listener to the copy location button
const copyButton = document.getElementById("copy-location-button");
if (copyButton) {
    copyButton.addEventListener("click", copyDynamicLocationToClipboard);
}
