<?php include('../header.php'); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize variables
$selectedPanel = '';
$data = [];

if (isset($_GET['panelName'])) {
    $selectedPanel = $_GET['panelName'];

    // Query to fetch data based on selected panelName
    $query = "SELECT * FROM $selectedPanel"; // Assuming $selectedPanel is the table name
    $result = mysqli_query($con, $query);

    // Fetch data into an array
    while ($row = mysqli_fetch_assoc($result)) {
        // Exclude rows where the column is 'comfort_code'
        $filtered_row = array_filter($row, function($key){
            return $key !== 'comfort_code';
        }, ARRAY_FILTER_USE_KEY);

        // Only add the filtered row to the $data array
        $data[] = $filtered_row;
    }
}

?>


<div class="page-content">

    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-3">
        <select name="panelName" id="panelName" class="form-control form-control-sm" required>
            <option value="">Select</option>
            <?php
            // Fetch panel names from database
            $panelNamesql = mysqli_query($con, "SELECT DISTINCT panelName FROM panel_health");
            while ($panelNamesqlResult = mysqli_fetch_assoc($panelNamesql)) {
                $panelName = $panelNamesqlResult["panelName"];
                $selected = ($panelName == $selectedPanel) ? 'selected' : '';
                echo "<option value='$panelName' $selected>$panelName</option>";
            }
            ?>
        </select>
        <button type="submit" class="badge bg-primary">Show Data</button>
    </form>

    <?php if (!empty($selectedPanel) && !empty($data)) : ?>
        <h3>Data for <?php echo $selectedPanel; ?></h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <?php
                        // Output table headers based on the first row
                        $headers = array_keys($data[0]);
                        foreach ($headers as $header) {
                            echo "<th>$header</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Output table rows
                    foreach ($data as $row) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>$value</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php elseif (!empty($selectedPanel) && empty($data)) : ?>
        <div class="alert alert-warning" role="alert">
            No data found for <?php echo $selectedPanel; ?>
        </div>
    <?php endif; ?>

</div>

<?php include('../footer.php'); ?>
