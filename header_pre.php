<?php include ('config.php');


$token = ($_SESSION['cftoken'] ? $_SESSION['cftoken'] : 'NA');



if (!function_exists('verifyToken')) {
	function verifyToken($token)
	{
		global $con;

		$sql = mysqli_query($con, "select * from loginusers where token='" . $token . "' and user_status=1");
		if ($sql_result = mysqli_fetch_assoc($sql)) {
			return 1;
		} else {
			return 0;
		}
	}
}


if (verifyToken($token) != 1 || $token == 'NA') {

	ob_start();
	header('Location: /vertical/auth/login.php');
	exit;
}


?>
<!doctype html>
<html lang="en" class="semi-dark">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?php echo BASE_URL; ?>/assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="<?php echo BASE_URL; ?>/assets/plugins/notifications/css/lobibox.min.css" rel="stylesheet" />
	<link href="<?php echo BASE_URL; ?>/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />

	<link href="<?php echo BASE_URL; ?>/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />

	<link href="<?php echo BASE_URL; ?>/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="<?php echo BASE_URL; ?>/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="<?php echo BASE_URL; ?>/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="<?php echo BASE_URL; ?>/assets/css/pace.min.css" rel="stylesheet" />
	<script src="<?php echo BASE_URL; ?>/assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="<?php echo BASE_URL; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo BASE_URL; ?>/assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="<?php echo BASE_URL; ?>/assets/css/app.css" rel="stylesheet">
	<link href="<?php echo BASE_URL; ?>/assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/dark-theme.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/semi-dark.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/header-colors.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css" />

	<title>Capital Softs </title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
</head>

<!-- onload="info_noti()" -->

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header" style="
	background: white;">
				<a href="<?php echo BASE_URL; ?>">
					<div style="text-align: center;">
						<img src="<?php echo BASE_URL; ?>assets/images/logo.jpg" class="logo-icon" alt="logo icon"
							style="filter:none;width: 75%;">
					</div>
				</a>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">


			<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-lock"></i>
						</div>
						<div class="menu-title">Admin</div>
					</a>
					<ul>
						<li><a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>Masters</a>
							<ul>
								<li><a href="<?php echo $base_url . 'admin/city.php'; ?>"><i
											class='bx bx-radio-circle'></i>City</a></li>
								<li><a href="<?php echo $base_url . 'admin/state.php'; ?>"><i
											class='bx bx-radio-circle'></i>State</a></li>
								<li><a href="<?php echo $base_url . 'admin/customer.php'; ?>"><i
											class='bx bx-radio-circle'></i>Cutomer</a></li>
								<li><a href="<?php echo $base_url . 'admin/dvr.php'; ?>"><i
											class='bx bx-radio-circle'></i>DVR</a></li>
							</ul>
						</li>
						<li><a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>User</a>
							<ul>
								<li><a href="<?php echo $base_url . 'admin/adduser.php'; ?>" ><i
											class='bx bx-radio-circle'></i>Add User</a></li>
								<li><a href="<?php echo $base_url . 'admin/viewUser.php'; ?>" ><i
											class='bx bx-radio-circle'></i>View User</a></li>
							
							</ul>
						</li>
						<li><a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>With Header
								Footer</a>
							<ul>
								<li><a href="auth-header-footer-signin.html" ><i
											class='bx bx-radio-circle'></i>Sign In</a></li>
								<li><a href="auth-header-footer-signup.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Sign Up</a></li>
								<li><a href="auth-header-footer-forgot-password.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Forgot Password</a></li>
								<li><a href="auth-header-footer-reset-password.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Reset Password</a></li>
							</ul>
						</li>
					</ul>
				</li>




				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-repeat"></i>
						</div>
						<div class="menu-title">Sites</div>
					</a>
					<ul>

						<li> <a href="<?php echo $base_url . 'sites/add_sites.php'; ?>"><i
									class='bx bx-radio-circle'></i>Add Site</a>
						</li>
						<li> <a href="<?php echo $base_url . $folder . 'sites/view_sites.php'; ?>"><i
									class='bx bx-radio-circle'></i>View Sites</a>
						</li>
						<!-- <li> <a href="content-text-utilities.html"><i class='bx bx-radio-circle'></i>Text Utilities</a>
						</li> -->
					</ul>
				</li>


				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-error"></i>
						</div>
						<div class="menu-title">Alerts</div>
					</a>
					<ul>
						<li> <a href="<?php echo $base_url . $folder . 'alert/viewalert.php'; ?>"><i
									class='bx bx-radio-circle'></i>View Alert</a>
						</li>
						<li> <a href="<?php echo $base_url . $folder . 'alert/view_monitoring_alert.php'; ?>"><i
									class='bx bx-radio-circle'></i>Monitoring Alert</a>
						</li>
					</ul>
				</li>


				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Reports</div>
					</a>
					<ul>
						<li> <a href="<?php echo $base_url . $folder . 'reports/cams_report.php'; ?>"><i class='bx bx-radio-circle'></i>Cams</a>
						</li>
						<li> <a href="<?php echo $base_url . $folder . 'reports/chestdoor_report.php'; ?>"><i class='bx bx-radio-circle'></i>ChestDoor</a>
						</li>
						<li> <a href="<?php echo $base_url . $folder . 'reports/health_check_report.php'; ?>"><i class='bx bx-radio-circle'></i>Health Check</a>
						</li>

						<li> <a href="<?php echo $base_url . $folder . 'reports/panel_up_down.php'; ?>"><i class='bx bx-radio-circle'></i>Panel Up-Down</a>
						</li>

						<li> <a href="<?php echo $base_url . $folder . 'reports/power_ups_report.php'; ?>"><i class='bx bx-radio-circle'></i>Power Ups</a>
						</li>
						
						
					</ul>
				</li>







				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
					<ul>
						<li> <a href="index.html"><i class='bx bx-radio-circle'></i>Default</a>
						</li>
						<li> <a href="index2.html"><i class='bx bx-radio-circle'></i>Alternate</a>
						</li>
						<li> <a href="index3.html"><i class='bx bx-radio-circle'></i>Graphical</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Application</div>
					</a>
					<ul>
						<li> <a href="app-emailbox.html"><i class='bx bx-radio-circle'></i>Email</a>
						</li>
						<li> <a href="app-chat-box.html"><i class='bx bx-radio-circle'></i>Chat Box</a>
						</li>
						<li> <a href="app-file-manager.html"><i class='bx bx-radio-circle'></i>File Manager</a>
						</li>
						<li> <a href="app-contact-list.html"><i class='bx bx-radio-circle'></i>Contatcs</a>
						</li>
						<li> <a href="app-to-do.html"><i class='bx bx-radio-circle'></i>Todo List</a>
						</li>
						<li> <a href="app-invoice.html"><i class='bx bx-radio-circle'></i>Invoice</a>
						</li>
						<li> <a href="app-fullcalender.html"><i class='bx bx-radio-circle'></i>Calendar</a>
						</li>
					</ul>
				</li>
				<li class="menu-label">UI Elements</li>
				<li>
					<a href="widgets.html">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Widgets</div>
					</a>
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-cart'></i>
						</div>
						<div class="menu-title">eCommerce</div>
					</a>
					<ul>
						<li> <a href="ecommerce-products.html"><i class='bx bx-radio-circle'></i>Products</a>
						</li>
						<li> <a href="ecommerce-products-details.html"><i class='bx bx-radio-circle'></i>Product
								Details</a>
						</li>
						<li> <a href="ecommerce-add-new-products.html"><i class='bx bx-radio-circle'></i>Add New
								Products</a>
						</li>
						<li> <a href="ecommerce-orders.html"><i class='bx bx-radio-circle'></i>Orders</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
						</div>
						<div class="menu-title">Components</div>
					</a>
					<ul>
						<li> <a href="component-alerts.html"><i class='bx bx-radio-circle'></i>Alerts</a>
						</li>
						<li> <a href="component-accordions.html"><i class='bx bx-radio-circle'></i>Accordions</a>
						</li>
						<li> <a href="component-badges.html"><i class='bx bx-radio-circle'></i>Badges</a>
						</li>
						<li> <a href="component-buttons.html"><i class='bx bx-radio-circle'></i>Buttons</a>
						</li>
						<li> <a href="component-cards.html"><i class='bx bx-radio-circle'></i>Cards</a>
						</li>
						<li> <a href="component-carousels.html"><i class='bx bx-radio-circle'></i>Carousels</a>
						</li>
						<li> <a href="component-list-groups.html"><i class='bx bx-radio-circle'></i>List Groups</a>
						</li>
						<li> <a href="component-media-object.html"><i class='bx bx-radio-circle'></i>Media Objects</a>
						</li>
						<li> <a href="component-modals.html"><i class='bx bx-radio-circle'></i>Modals</a>
						</li>
						<li> <a href="component-navs-tabs.html"><i class='bx bx-radio-circle'></i>Navs & Tabs</a>
						</li>
						<li> <a href="component-navbar.html"><i class='bx bx-radio-circle'></i>Navbar</a>
						</li>
						<li> <a href="component-paginations.html"><i class='bx bx-radio-circle'></i>Pagination</a>
						</li>
						<li> <a href="component-popovers-tooltips.html"><i class='bx bx-radio-circle'></i>Popovers &
								Tooltips</a>
						</li>
						<li> <a href="component-progress-bars.html"><i class='bx bx-radio-circle'></i>Progress</a>
						</li>
						<li> <a href="component-spinners.html"><i class='bx bx-radio-circle'></i>Spinners</a>
						</li>
						<li> <a href="component-notifications.html"><i class='bx bx-radio-circle'></i>Notifications</a>
						</li>
						<li> <a href="component-avtars-chips.html"><i class='bx bx-radio-circle'></i>Avatrs & Chips</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-repeat"></i>
						</div>
						<div class="menu-title">Content</div>
					</a>
					<ul>
						<li> <a href="content-grid-system.html"><i class='bx bx-radio-circle'></i>Grid System</a>
						</li>
						<li> <a href="content-typography.html"><i class='bx bx-radio-circle'></i>Typography</a>
						</li>
						<li> <a href="content-text-utilities.html"><i class='bx bx-radio-circle'></i>Text Utilities</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"> <i class="bx bx-donate-blood"></i>
						</div>
						<div class="menu-title">Icons</div>
					</a>
					<ul>
						<li> <a href="icons-line-icons.html"><i class='bx bx-radio-circle'></i>Line Icons</a>
						</li>
						<li> <a href="icons-boxicons.html"><i class='bx bx-radio-circle'></i>Boxicons</a>
						</li>
						<li> <a href="icons-feather-icons.html"><i class='bx bx-radio-circle'></i>Feather Icons</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="form-froala-editor.html">
						<div class="parent-icon"><i class='bx bx-code-alt'></i>
						</div>
						<div class="menu-title">Froala Editor</div>
					</a>
				</li>
				<li class="menu-label">Forms & Tables</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-message-square-edit'></i>
						</div>
						<div class="menu-title">Forms</div>
					</a>
					<ul>
						<li> <a href="form-elements.html"><i class='bx bx-radio-circle'></i>Form Elements</a>
						</li>
						<li> <a href="form-input-group.html"><i class='bx bx-radio-circle'></i>Input Groups</a>
						</li>
						<li> <a href="form-radios-and-checkboxes.html"><i class='bx bx-radio-circle'></i>Radios &
								Checkboxes</a>
						</li>
						<li> <a href="form-layouts.html"><i class='bx bx-radio-circle'></i>Forms Layouts</a>
						</li>
						<li> <a href="form-validations.html"><i class='bx bx-radio-circle'></i>Form Validation</a>
						</li>
						<li> <a href="form-wizard.html"><i class='bx bx-radio-circle'></i>Form Wizard</a>
						</li>
						<li> <a href="form-text-editor.html"><i class='bx bx-radio-circle'></i>Text Editor</a>
						</li>
						<li> <a href="form-file-upload.html"><i class='bx bx-radio-circle'></i>File Upload</a>
						</li>
						<li> <a href="form-date-time-pickes.html"><i class='bx bx-radio-circle'></i>Date Pickers</a>
						</li>
						<li> <a href="form-select2.html"><i class='bx bx-radio-circle'></i>Select2</a>
						</li>
						<li> <a href="form-repeater.html"><i class='bx bx-radio-circle'></i>Form Repeater</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-grid-alt"></i>
						</div>
						<div class="menu-title">Tables</div>
					</a>
					<ul>
						<li> <a href="table-basic-table.html"><i class='bx bx-radio-circle'></i>Basic Table</a>
						</li>
						<li> <a href="table-datatable.html"><i class='bx bx-radio-circle'></i>Data Table</a>
						</li>
					</ul>
				</li>
				<li class="menu-label">Pages</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-lock"></i>
						</div>
						<div class="menu-title">Authentication</div>
					</a>
					<ul>
						<li><a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>Basic</a>
							<ul>
								<li><a href="auth-basic-signin.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Sign In</a></li>
								<li><a href="auth-basic-signup.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Sign Up</a></li>
								<li><a href="auth-basic-forgot-password.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Forgot Password</a></li>
								<li><a href="auth-basic-reset-password.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Reset Password</a></li>
							</ul>
						</li>
						<li><a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>Cover</a>
							<ul>
								<li><a href="auth-cover-signin.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Sign In</a></li>
								<li><a href="auth-cover-signup.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Sign Up</a></li>
								<li><a href="auth-cover-forgot-password.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Forgot Password</a></li>
								<li><a href="auth-cover-reset-password.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Reset Password</a></li>
							</ul>
						</li>
						<li><a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>With Header
								Footer</a>
							<ul>
								<li><a href="auth-header-footer-signin.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Sign In</a></li>
								<li><a href="auth-header-footer-signup.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Sign Up</a></li>
								<li><a href="auth-header-footer-forgot-password.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Forgot Password</a></li>
								<li><a href="auth-header-footer-reset-password.html" target="_blank"><i
											class='bx bx-radio-circle'></i>Reset Password</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="user-profile.html">
						<div class="parent-icon"><i class="bx bx-user-circle"></i>
						</div>
						<div class="menu-title">User Profile</div>
					</a>
				</li>
				<li>
					<a href="timeline.html">
						<div class="parent-icon"> <i class="bx bx-video-recording"></i>
						</div>
						<div class="menu-title">Timeline</div>
					</a>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-error"></i>
						</div>
						<div class="menu-title">Errors</div>
					</a>
					<ul>
						<li> <a href="errors-404-error.html" target="_blank"><i class='bx bx-radio-circle'></i>404
								Error</a>
						</li>
						<li> <a href="errors-500-error.html" target="_blank"><i class='bx bx-radio-circle'></i>500
								Error</a>
						</li>
						<li> <a href="errors-coming-soon.html" target="_blank"><i class='bx bx-radio-circle'></i>Coming
								Soon</a>
						</li>
						<li> <a href="error-blank-page.html" target="_blank"><i class='bx bx-radio-circle'></i>Blank
								Page</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="faq.html">
						<div class="parent-icon"><i class="bx bx-help-circle"></i>
						</div>
						<div class="menu-title">FAQ</div>
					</a>
				</li>
				<li>
					<a href="pricing-table.html">
						<div class="parent-icon"><i class="bx bx-diamond"></i>
						</div>
						<div class="menu-title">Pricing</div>
					</a>
				</li>
				<li class="menu-label">Charts & Maps</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-line-chart"></i>
						</div>
						<div class="menu-title">Charts</div>
					</a>
					<ul>
						<li> <a href="charts-apex-chart.html"><i class='bx bx-radio-circle'></i>Apex</a>
						</li>
						<li> <a href="charts-chartjs.html"><i class='bx bx-radio-circle'></i>Chartjs</a>
						</li>
						<li> <a href="charts-highcharts.html"><i class='bx bx-radio-circle'></i>Highcharts</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-map-alt"></i>
						</div>
						<div class="menu-title">Maps</div>
					</a>
					<ul>
						<li> <a href="map-google-maps.html"><i class='bx bx-radio-circle'></i>Google Maps</a>
						</li>
						<li> <a href="map-vector-maps.html"><i class='bx bx-radio-circle'></i>Vector Maps</a>
						</li>
					</ul>
				</li>
				<li class="menu-label">Others</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-menu"></i>
						</div>
						<div class="menu-title">Menu Levels</div>
					</a>
					<ul>
						<li> <a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>Level One</a>
							<ul>
								<li> <a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>Level
										Two</a>
									<ul>
										<li> <a href="javascript:;"><i class='bx bx-radio-circle'></i>Level Three</a>
										</li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="https://codervent.com/rocker/documentation/index.html" target="_blank">
						<div class="parent-icon"><i class="bx bx-folder"></i>
						</div>
						<div class="menu-title">Documentation</div>
					</a>
				</li>
				<li>
					<a href="https://themeforest.net/user/codervent" target="_blank">
						<div class="parent-icon"><i class="bx bx-support"></i>
						</div>
						<div class="menu-title">Support</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand gap-3">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>

					<div class="search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal"
						style="display: none !important;">
						<a href="avascript:;" class="btn d-flex align-items-center"><i
								class='bx bx-search'></i>Search</a>
					</div>


					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center gap-1">
							<li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal"
								data-bs-target="#SearchModal">
								<a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
								</a>
							</li>

							<li class="nav-item dark-mode d-none d-sm-flex">
								<a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
								</a>
							</li>

							<li class="nav-item dropdown dropdown-app" style="display:none;">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"
									href="javascript:;"><i class='bx bx-grid-alt'></i></a>
								<div class="dropdown-menu dropdown-menu-end p-0">
									<div class="app-container p-2 my-2">
										<div class="row gx-0 gy-2 row-cols-3 justify-content-center p-2">
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/slack.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Slack</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/behance.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Behance</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/google-drive.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Dribble</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/outlook.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Outlook</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/github.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">GitHub</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/stack-overflow.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Stack</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/figma.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Stack</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/twitter.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Twitter</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/google-calendar.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Calendar</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/spotify.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Spotify</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/google-photos.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Photos</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/pinterest.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Photos</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/linkedin.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">linkedin</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/dribble.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Dribble</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/youtube.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">YouTube</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/google.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">News</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/envato.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Envato</p>
														</div>
													</div>
												</a>
											</div>
											<div class="col">
												<a href="javascript:;">
													<div class="app-box text-center">
														<div class="app-icon">
															<img src="<?php echo BASE_URL; ?>assets/images/app/safari.png"
																width="30" alt="">
														</div>
														<div class="app-name">
															<p class="mb-0 mt-1">Safari</p>
														</div>
													</div>
												</a>
											</div>

										</div><!--end row-->

									</div>
								</div>
							</li>

							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
									data-bs-toggle="dropdown"><span class="alert-count">7</span>
									<i class='bx bx-bell'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Notifications</p>
											<p class="msg-header-badge">8 New</p>
										</div>
									</a>
									<div class="header-notifications-list">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="<?php echo BASE_URL; ?>assets/images/avatars/avatar-1.png"
														class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Daisy Anderson<span
															class="msg-time float-end">5 sec
															ago</span></h6>
													<p class="msg-info">The standard chunk of lorem</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-danger text-danger">dc
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Orders <span class="msg-time float-end">2
															min
															ago</span></h6>
													<p class="msg-info">You have recived new orders</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="<?php echo BASE_URL; ?>assets/images/avatars/avatar-2.png"
														class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Althea Cabardo <span
															class="msg-time float-end">14
															sec ago</span></h6>
													<p class="msg-info">Many desktop publishing packages</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-success text-success">
													<img src="<?php echo BASE_URL; ?>assets/images/app/outlook.png"
														width="25" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Account Created<span
															class="msg-time float-end">28 min
															ago</span></h6>
													<p class="msg-info">Successfully created new email</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-info text-info">Ss
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Product Approved <span
															class="msg-time float-end">2 hrs ago</span></h6>
													<p class="msg-info">Your new product has approved</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="<?php echo BASE_URL; ?>assets/images/avatars/avatar-4.png"
														class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Katherine Pechon <span
															class="msg-time float-end">15
															min ago</span></h6>
													<p class="msg-info">Making this the first true generator</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-success text-success"><i
														class='bx bx-check-square'></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Your item is shipped <span
															class="msg-time float-end">5 hrs
															ago</span></h6>
													<p class="msg-info">Successfully shipped your item</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-primary">
													<img src="<?php echo BASE_URL; ?>assets/images/app/github.png"
														width="25" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New 24 authors<span
															class="msg-time float-end">1 day
															ago</span></h6>
													<p class="msg-info">24 new authors joined last week</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="<?php echo BASE_URL; ?>assets/images/avatars/avatar-8.png"
														class="msg-avatar" alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Peter Costanzo <span
															class="msg-time float-end">6 hrs
															ago</span></h6>
													<p class="msg-info">It was popularised in the 1960s</p>
												</div>
											</div>
										</a>
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer">
											<button class="btn btn-primary w-100">View All Notifications</button>
										</div>
									</a>
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large" style="display:none;">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
									role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span
										class="alert-count">8</span>
									<i class='bx bx-shopping-bag'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">My Cart</p>
											<p class="msg-header-badge">10 Items</p>
										</div>
									</a>
									<div class="header-message-list">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="<?php echo BASE_URL; ?>assets/images/products/11.png"
															class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="<?php echo BASE_URL; ?>assets/images/products/02.png"
															class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="<?php echo BASE_URL; ?>assets/images/products/03.png"
															class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="<?php echo BASE_URL; ?>assets/images/products/04.png"
															class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="<?php echo BASE_URL; ?>assets/images/products/05.png"
															class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="<?php echo BASE_URL; ?>assets/images/products/06.png"
															class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="<?php echo BASE_URL; ?>assets/images/products/07.png"
															class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="<?php echo BASE_URL; ?>assets/images/products/08.png"
															class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="<?php echo BASE_URL; ?>assets/images/products/09.png"
															class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer">
											<div class="d-flex align-items-center justify-content-between mb-3">
												<h5 class="mb-0">Total</h5>
												<h5 class="mb-0 ms-auto">$489.00</h5>
											</div>
											<button class="btn btn-primary w-100">Checkout</button>
										</div>
									</a>
								</div>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown px-3">
						<a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
							href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="<?php echo BASE_URL; ?>assets/images/avatars/avatar-2.png" class="user-img"
								alt="user avatar">
							<div class="user-info">
								<p class="user-name mb-0"><?php echo ucwords($_SESSION['username']); ?></p>
								<p class="designattion mb-0"><?php echo $_SESSION['uname']; ?></p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">

							<li><a class="dropdown-item d-flex align-items-center"
									href="<?php echo BASE_URL; ?>logout.php"><i
										class="bx bx-log-out-circle"></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">