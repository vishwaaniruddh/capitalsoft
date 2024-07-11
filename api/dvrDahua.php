<?php
include('../config.php');

function getCameraTime($ip, $port, $username, $password) {
    $apiEndpoint = "http://$ip:$port/ISAPI/System/time";
    // echo $apiEndpoint = "http://$ip:$port/ISAPI/ContentMgmt/Storage/status";

    
    
    // Create cURL session
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST); // Use Digest authentication
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    
    // Execute cURL session
    $response = curl_exec($ch);
    
    // Check for cURL errors
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return "cURL Error: " . $error;
    }
    
    // Check HTTP response code
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Close cURL session
    curl_close($ch);
    
    // Handle HTTP response code and response
    if ($httpCode != 200) {
        return "Failed to retrieve camera time. HTTP Code: $httpCode";
    }
    
    // Parse XML response
    $xml = simplexml_load_string($response);
    if ($xml === false) {
        return "Failed to parse XML response";
    }
    
    // Extract relevant data
    $timeMode = (string) $xml->timeMode;
    $localTime = (string) $xml->localTime;
    $timeZone = (string) $xml->timeZone;
    
    // Construct result array
    $result = array(
        'timeMode' => $timeMode,
        'localTime' => $localTime,
        'timeZone' => $timeZone
    );
    
    return $result;
}

// Usage example
$cameraTime = getCameraTime('172.16.10.27', 82, 'admin', '12345abcde');
echo "<pre>";
print_r($cameraTime);
echo "</pre>";




return ; 
// Function to execute cURL request for each DVR
function executeRequest($username, $password, $ip, $port) {
    $apiEndpoint = "http://$ip:$port";
    
    // Create cURL session
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST); // Use Digest authentication
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Set timeout to 30 seconds
    
    // Execute cURL session
    $response = curl_exec($ch);
    
    // Check for cURL errors
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return "cURL Error: " . $error;
    }
    
    // Check HTTP response code
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Close cURL session
    curl_close($ch);
    
    // Check HTTP response code and handle response
    if ($httpCode == 200) {
        return "DVR login successful!";
    } else {
        return "DVR login failed. HTTP Code: $httpCode";
    }
}

// Main query to fetch DVRs and process requests
$sql = mysqli_query($con, "SELECT * FROM all_dvr_live WHERE live='Y' AND dvrname='Hikvision'");
$curlHandles = [];

while ($row = mysqli_fetch_array($sql)) {
    $username = $row['UserName'];
    $password = $row['Password'];
    $ip = $row['IPAddress'];
    $port = $row['port'];

    $port = 82;
    // Create individual cURL handle for each request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://$ip:$port");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout in seconds

    $curlHandles[] = $ch;
}

// Initialize multi-handle
$mh = curl_multi_init();

// Add all individual handles to the multi-handle
foreach ($curlHandles as $ch) {
    curl_multi_add_handle($mh, $ch);
}

$active = null;

// Execute the handles
do {
    $mrc = curl_multi_exec($mh, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);

while ($active && $mrc == CURLM_OK) {
    if (curl_multi_select($mh) == -1) {
        usleep(100);
    }

    do {
        $mrc = curl_multi_exec($mh, $active);
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);
}

// Process each handle's response
foreach ($curlHandles as $ch) {
    $response = curl_multi_getcontent($ch);
    $info = curl_getinfo($ch);
    
    if ($info['http_code'] == 200) {
        echo "DVR login successful for {$info['url']}!";
    } else {
        echo "DVR login failed for {$info['url']}. HTTP Code: {$info['http_code']}\n";
    }
    
    echo '<br />';
    curl_multi_remove_handle($mh, $ch);
    curl_close($ch);
}

// Close the multi-handle
curl_multi_close($mh);

?>
