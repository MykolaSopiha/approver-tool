<!doctype html>
<html>

	<head>
		<meta charset="utf-8">
		<title>Results</title>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="theme-color" content="#fff">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
		<style type="text/css">
			@font-face {
			font-family: 'Roboto';
			font-style: normal;
			font-weight: 400;
			src:
				url(fonts/Roboto-Regular.woff) format('woff'),
				url(fonts/Roboto-Regular.woff2) format('woff2'),;
			}
			html, body {
				height: 100%;
			}
			body {
				margin: 0;
				padding: 0;
				font-family: 'Roboto', sans-serif;
			}
			.wrapper {
				display: flex;
				flex-direction: column;
				height: 100%;
			}
			.content {
				flex: 1 0 auto;
				padding-bottom: 40px;
			}
			.header-title {
				margin: 20px 0;
				font-size: 34px;
				text-align: center;
				line-height: 52px;
				border-top: 1px solid #cccccc;
				border-bottom: 1px solid #cccccc;
				color: #666;
			}
			.container {
				padding-top: 40px;
				padding-bottom: 40px;
			}
			.positive_roi td {
				background-color: rgb(144, 238, 144) !important;
			}
			.negative_roi td {
				background-color: rgb(220, 20, 60) !important;
			}
			.footer {
				-webkit-box-flex:0;
				-ms-flex:0 0 auto;
				flex:0 0 auto;
				-webkit-box-sizing:border-box;
				box-sizing:border-box;
				background-color:#2F2523;
				text-align:center;
				margin-top: auto;
				padding-top: 32px;
				padding-bottom: 30px;
				font-size: 16px;
			}
			.footer p {
				color: #fff;
				margin: 0;
			}
			.footer a {
				color: #369;
			}
		</style>
	</head>
	<body>
		<!-- BEGIN wrapper -->
		<div class="wrapper">
			<!-- BEGIN content -->
			<div class="content">
				<?php include_once 'approver.php'; ?>
			</div>
		<!-- END content -->
		<footer class="footer" role="contentinfo">
			<p>Designed by <a href="https://www.facebook.com/profile.php?id=100004092528536">M.Sopiha</a></p>
		</footer>
	</div>
	<!-- END wrapper -->

	<!-- BEGIN scripts -->
	<script type="text/javascript" src="js/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>