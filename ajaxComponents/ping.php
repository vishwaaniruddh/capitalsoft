<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

function sendMsg($msg) {
    echo "data: $msg\n\n";
    ob_flush();
    flush();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ip'])) {
    // Retrieve the IP address from the GET parameter
    $ip = $_GET['ip'];

    // Validate IP (optional)
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        sendMsg('Invalid IP address');
        exit;
    }

    // Command to execute
    $cmd = 'ping ' . escapeshellarg($ip); // Adjust options as needed

    // Execute ping command and capture output
    $descriptorspec = array(
        0 => array('pipe', 'r'), // stdin
        1 => array('pipe', 'w'), // stdout
        2 => array('pipe', 'w')  // stderr
    );

    $process = proc_open($cmd, $descriptorspec, $pipes);

    if (is_resource($process)) {
        stream_set_blocking($pipes[1], 0);
        stream_set_blocking($pipes[2], 0);

        // Read stdout and stderr
        while (($stdout = fgets($pipes[1])) !== false || ($stderr = fgets($pipes[2])) !== false) {
            if (!empty($stdout)) {
                sendMsg($stdout);
            }
            if (!empty($stderr)) {
                sendMsg($stderr);
            }
        }

        // Close all pipes
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
    } else {
        sendMsg('Error running ping command');
    }

} else {
    sendMsg('Method Not Allowed');
}
?>
