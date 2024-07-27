
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
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
					<ul>
						<li> <a href="<?php echo $base_url . 'index.php'; ?>"><i
									class='bx bx-radio-circle'></i>Default</a>
						</li>
						<li> <a href="<?php echo $base_url . 'clientSummary.php'; ?>"><i
									class='bx bx-radio-circle'></i>Client Summary</a>
						</li>
						<li> <a href="<?php echo $base_url . 'panelDashboard.php'; ?>"><i
									class='bx bx-radio-circle'></i>Panel Dashboard</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-lock"></i>
						</div>
						<div class="menu-title">Admin</div>
					</a>
					<ul>
						<li><a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>Masters</a>
							<ul>

								<li><a href="<?php echo $base_url . 'admin/alertType.php'; ?>"><i
											class='bx bx-radio-circle'></i>Alert Type</a></li>
								<li><a href="<?php echo $base_url . 'admin/city.php'; ?>"><i
											class='bx bx-radio-circle'></i>City</a></li>
								<li><a href="<?php echo $base_url . 'admin/customer.php'; ?>"><i
											class='bx bx-radio-circle'></i>Customer</a></li>
								<li><a href="<?php echo $base_url . 'admin/dvr.php'; ?>"><i
											class='bx bx-radio-circle'></i>DVR</a></li>
											
								<li><a href="<?php echo $base_url . 'admin/menu.php'; ?>"><i
											class='bx bx-radio-circle'></i>Menu</a></li>
								<li><a href="<?php echo $base_url . 'admin/state.php'; ?>"><i
											class='bx bx-radio-circle'></i>State</a></li>


							</ul>
						</li>
						<li><a class="has-arrow" href="javascript:;"><i class='bx bx-radio-circle'></i>User</a>
							<ul>
								<li><a href="<?php echo $base_url . 'admin/adduser.php'; ?>"><i
											class='bx bx-radio-circle'></i>Add User</a></li>
								<li><a href="<?php echo $base_url . 'admin/viewUser.php'; ?>"><i
											class='bx bx-radio-circle'></i>View User</a></li>

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
						<li> <a href="<?php echo $base_url . 'sites/liveView.php'; ?>"><i
									class='bx bx-radio-circle'></i>Live View</a>
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
						<li><a href="<?php echo $base_url . 'alert/alertdashboard.php'; ?>"><i
									class='bx bx-radio-circle'></i>Alert Dashboard</a></li>
						<li> <a href="<?php echo $base_url . $folder . 'alert/viewalert.php'; ?>"><i
									class='bx bx-radio-circle'></i>View Alert</a>
						</li>
						<li> <a href="<?php echo $base_url . $folder . 'alert/view_monitoring_alert.php'; ?>"><i
									class='bx bx-radio-circle'></i>Monitoring Alert</a>
						</li>
					</ul>
				</li>


				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-donate-blood"></i>
						</div>
						<div class="menu-title">DVR</div>
					</a>
					<ul>
						<li> <a href="<?php echo $base_url . $folder . 'dvr/dvrdashboard.php'; ?>"><i
									class='bx bx-radio-circle'></i>DVR Dashboard</a>
						</li>
						<li> <a href="<?php echo $base_url . $folder . 'dvr/alldvr.php'; ?>"><i
									class='bx bx-radio-circle'></i>All DVR</a>
						</li>
					</ul>
				</li>

				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-bookmark-heart"></i>
						</div>
						<div class="menu-title">Panel</div>
					</a>
					<ul>
						<li> <a href="<?php echo $base_url . $folder . 'panel/paneldashboard.php'; ?>"><i
									class='bx bx-radio-circle'></i>Panel Dashboard</a>
						</li>
						<li> <a href="<?php echo $base_url . $folder . 'panel/allpanel.php'; ?>"><i
									class='bx bx-radio-circle'></i>All Panel</a>
						</li>
						<li> <a href="<?php echo $base_url . $folder . 'panel/zoneDetail.php'; ?>"><i
									class='bx bx-radio-circle'></i>Zone Details</a>
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
						<li> <a href="<?php echo $base_url . $folder . 'reports/cams_report.php'; ?>"><i
									class='bx bx-radio-circle'></i>Cams</a>
						</li>

						<li> <a href="<?php echo $base_url . $folder . 'reports/health_check_report.php'; ?>"><i
									class='bx bx-radio-circle'></i>Health Check</a>
						</li>

						<li> <a href="<?php echo $base_url . $folder . 'reports/panel_up_down.php'; ?>"><i
									class='bx bx-radio-circle'></i>Panel Up-Down</a>
						</li>

						<li> <a href="<?php echo $base_url . $folder . 'reports/power_ups_report.php'; ?>"><i
									class='bx bx-radio-circle'></i>Power Ups</a>
						</li>


					</ul>
				</li>










				<li class="">
					<a href="javascript:;" class="has-arrow" aria-expanded="false">
						<div class="parent-icon"><i class="bx bx-cart"></i>
						</div>
						<div class="menu-title">All Reports</div>
					</a>
					<ul class="mm-collapse" style="height: 2.22222px;">
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/alldvr.php'; ?>">
								<i class="bx bx-radio-circle"> </i> DVRHealth Report </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/panelHeartBeatReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Panel Heartbeat Report </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/viewalert.php'; ?>">
								<i class="bx bx-radio-circle"> </i> TicketView Report </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/cmeReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> CME Report </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/panelStatusReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Panel Status Report </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/SiteSummaryReportNetwork.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Site Network Status </a>
						</li>

						<!-- <li> <a href="<?php echo $base_url . $folder . 'dvr/alldvr.php'; ?>">
								<i class="bx bx-radio-circle"> </i> DVR Report </a>
						</li> -->

						<li>
							<a href="<?php echo $base_url . $folder . 'reports/ZoneStatusReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Zone Status Report </a>
						</li>
						<li>

							<a href="<?php echo $base_url . $folder . 'reports/excelReports.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Excel Reports </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/SiteDown.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Site Down Report </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/DVRStorageReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> DVR Storage </a>
						</li>

						<li>

							<a href="<?php echo $base_url . $folder . 'reports/chestdoor_report.php'; ?>">

								<i class="bx bx-radio-circle"> </i> ATM Chest Door Report </a>
						</li>


						<li>
							<a href="DvrLogsExport.aspx">
								<i class="bx bx-radio-circle"> </i> DVR Communication </a>
						</li>


						<li>
							<a href="DVRCameraReportXLS.html">
								<i class="bx bx-radio-circle"> </i> DVR Camera </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/tempretureReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Temperature Report </a>
						</li>

						<li>
							<a href="<?php echo $base_url . $folder . 'reports/HealthCheckUpReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Health Check Up </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/CAMS_UPSReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> CAMS UPS Report </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/CCILHealthCheckUpReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> CCILHealth Check Up </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/India1HealthCheckUpReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> India 1 Health Check Up </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/AxisHealthCheckUpReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Axis Health Check Up </a>
						</li>
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/KJSBHealthCheckUpReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> KJSB Health Check Up </a>
						</li>
						<li>

							<a
								href="<?php echo $base_url . $folder . 'reports/WriterSafeGuardHealthCheckUpReport.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Writer SafeGuard Health Check Up </a>
						</li>
						<!-- <li>
							<a href="FinoBank_HealthCheckUpReport.html">
								<i class="bx bx-radio-circle"> </i> Fino Bank Health CheckUp </a>
						</li> -->
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/PanelUP_Down_Report.php'; ?>">
								<i class="bx bx-radio-circle"> </i> Panel Up Down </a>
						</li>
						<li>
							<a href="HK_CRA_ATMO_Report.html">
								<i class="bx bx-radio-circle"> </i> Agency Attendance </a>
						</li>
						<li>
							<a href="ListSiteReport.html">
								<i class="bx bx-radio-circle"> </i> Site Master Report </a>
						</li>
						<!-- <li>
							<a href="SBI_HitachiHealthCheckUpReport.html">
								<i class="bx bx-radio-circle"> </i> Sbi Hitachi Health CheckUp </a>
						</li> -->
						<li>
							<a href="<?php echo $base_url . $folder . 'reports/CNSHealthCheckUpReport.php'; ?>">

								<i class="bx bx-radio-circle"> </i> CNS Health CheckUp </a>
						</li>
						<li>
							<a href="ACandSignageDetail.html">
								<i class="bx bx-radio-circle"> </i> AC and Signage Report </a>
						</li>
						<li>
							<a href="VideoCaptureDetailsReport.html">
								<i class="bx bx-radio-circle"> </i> Video Capture Details Report </a>
						</li>

						<li>
							<a href="WriterSafeGuardOnlineOfflineReport.html">
								<i class="bx bx-radio-circle"> </i> Writer SafeGuard Online Offline Report </a>
						</li>
						<li>
							<a href="HDDStatusReport.html">
								<i class="bx bx-radio-circle"> </i> HDD Status Report </a>
						</li>
					</ul>
				</li>





			</ul>
			<!--end navigation-->
		</div>
