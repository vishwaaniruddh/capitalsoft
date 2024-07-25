<?php include ('../header.php'); ?>

<div class="page-content">


<style>
		th,
		td {
			white-space: nowrap;
		}

		.table>:not(caption) tr {
			background-color: inherit;
		}

		.dangeralertClass td {
			background-color: #fd3550 !important;
			color: white;
		}

		.successalertClass td {
			background-color: #15ca20 !important;
			color: white;
		}
	</style>
	<script>
		function a(strPage, perpg) {
			$('#show').html('');
			var atmid = document.getElementById("atmid").value;
			var customer = document.getElementById("customer").value;

			var Page = "";
			if (strPage != "") {
				Page = strPage;
			}
			$('#loadingmessage').show(); // show the loading message.
			$.ajax({
				type: 'POST',
				url: '../ajaxComponents/getTempretureData.php',
				data: {
					atmid: atmid,
					customer: customer,
					Page: Page,
					perpg: perpg, // Use the perpg variable passed into the function
				},
				success: function (msg) {
					$('#loadingmessage').hide(); // hide the loading message
					document.getElementById("show").innerHTML = msg;
				}
			});
		}

	</script>


<form id="searchForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<div class="row">
			<div class="col">
				<label for="">ATMID</label>
				<input type="text" name="atmid" id="atmid" class="form-control form-control-sm mb-3"
					value="<?php echo isset($_REQUEST['atmid']) ? $_REQUEST['atmid'] : ''; ?>" />
			</div>
			<div class="col">
				<label for="">Customer:</label>
				<select name="customer" class="form-control form-control-sm mb-3" id="customer">
					<option value="">Select Customer Name</option>
					<?php
					$xyzz = "SELECT name FROM customer WHERE status = 1";
					$runxyzz = mysqli_query($con, $xyzz);
					while ($xyzfetchcus = mysqli_fetch_array($runxyzz)) {
						$selected = '';
						if (isset($_REQUEST['customer']) && $_REQUEST['customer'] == $xyzfetchcus['name']) {
							$selected = 'selected';
						}
						echo '<option value="' . $xyzfetchcus['name'] . '" ' . $selected . '>' . $xyzfetchcus['name'] . '</option>';
					}
					?>
				</select>

			</div>
			
		</div>
		<input type="hidden" name="Page" id="currentPage" value="<?php echo $page; ?>">
		<input type="hidden" name="perpg" id="perPage" value="<?php echo $records_per_page; ?>">

		<input type="button" class="btn btn-primary px-5 rounded-0" id="submitForm" name="submit" onclick="a('','')"
			value="search"></button>
	</form>








<div id='loadingmessage' style='display:none;'>
		<div class="spinner-grow" role="status" style="margin: auto;
	display: block;"> <span class="visually-hidden">Loading...</span>
		</div>
	</div>

	<div id="show"></div>



</div>
<?php include ('../footer.php'); ?>
