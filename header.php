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
	// header('Location: /capitalsoft/auth/login.php');
	exit;
}


?>
<!doctype html>
<html lang="en" class="<?php echo htmlspecialchars($theme_class); ?> <?php echo !empty($header_mode) ? 'color-header ' . htmlspecialchars($header_mode) : ''; ?> <?php echo !empty($sidebar_mode) ? 'color-sidebar ' . htmlspecialchars($sidebar_mode) : ''; ?>">


<!-- Mirrored from codervent.com/rocker/demo/vertical/index3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Jun 2024 08:25:30 GMT -->

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
<!-- style="text-transform: uppercase;" -->

<body>








	<style>

.badge{
	border: none;
	border-radius: 0;
}

		button {
			text-transform: uppercase;
		}

		td {
			white-space: nowrap;
		}

		th,
		td {
			text-align: center;
		}
	</style>

	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		
		<?php include( 'nav.php');  ?>


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


					<div class="" style="text-align:right;">
						<div class="btn-group">

							<button type="button" class="btn btn-primary">Select Customer
								<?php echo $_REQUEST['customer'] ? '( ' . $_REQUEST['customer'] . ' )' : ''; ?>
							</button>
							<button type="button"
								class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
								data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
								<a class="dropdown-item" href="?">All</a>
								<?php
								$customersql = mysqli_query($con, "select distinct(name) as customer from customer where status=1");
								while ($customersql_result = mysqli_fetch_assoc($customersql)) {
									$customer = $customersql_result['customer'];
									?>
									<a class="dropdown-item"
										href="?customer=<?php echo $customer; ?>"><?php echo $customer; ?></a>
								<?php }
								?>
							</div>
						</div>
					</div>

					<hr>
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
													<img src="<?php echo BASE_URL; ?>assets/images/avatars/avatar-4.png"
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
							<img src="<?php echo BASE_URL; ?>assets/images/avatars/avatar-4.png" class="user-img"
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
		<!--start page wrapper 64424-->
		<div class="page-wrapper">