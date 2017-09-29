<?php
	
	if (($_FILES['fb_data']['size'] != 0) && ($_FILES['tl_data']['size'] != 0) && isset($_POST['rub_curr'])) {
		
	} else
		header("Location: index.html");

	$uploaddir = 'uploads/';
	$uploadfile_fb = $uploaddir . basename($_FILES['fb_data']['name']);
	$uploadfile_tl = $uploaddir . basename($_FILES['tl_data']['name']);

	if (move_uploaded_file($_FILES['fb_data']['tmp_name'], $uploadfile_fb) && move_uploaded_file($_FILES['tl_data']['tmp_name'], $uploadfile_tl)) {
	    echo "<h1 class=\"header-title\">Файлы корректены и были успешно загружены.</h1>";
	} else {
	    echo "Возможная атака с помощью файловой загрузки!\n";
	}

	$fb_file = fopen ($uploadfile_fb,"r");
	$tl_file = fopen ($uploadfile_tl,"r");

	$rub_curr = floatval($_POST['rub_curr']);

	fgetcsv ($fb_file, 1000, ",");
	fgetcsv ($tl_file, 1000, ",");

	$fb_campaigns = array();
	$tl_campaigns = array();
	$results = array();
	$campaign_name = array();

	// Facebook data
	while ($data = fgetcsv ($fb_file, 1000, ",")) {
		if ($data[2] != '') {
			$campaign = $data[2];
			$stream = substr($campaign, strrpos($campaign, '-s') + 2);
			$cost = $data[8];
			$report_date = $data[1];
			if ($stream != '') {
				$fb_campaigns[$stream][$report_date] = floatval($cost);
				$results[$stream][$report_date]['cost'] = round(floatval($cost)/$rub_curr, 2);
				$results[$stream][$report_date]['price'] = 0;
				if (!isset($campaign_name[$stream])) {
					$campaign_name[$stream] = $campaign;
				}
			}
		}
	}

	// TerraLeads data
	while ($data = fgetcsv ($tl_file, 1000, ",")) {
		$status = $data[3];
		$product = $data[6];
		$stream = $data[12];
		$price = $data[13];
		$lead_time = substr($data[1], 0, 10);
		if ($stream != '' && array_key_exists($stream, $fb_campaigns)) {
			$tl_campaigns[$stream][$lead_time] += floatval($price);
			$results[$stream][$lead_time]['price'] += floatval($price);
			$results[$stream][$lead_time]['leads'] += 1;
			if ($status == "confirm") {
				$results[$stream][$lead_time]['confirm'] += 1;
			} else {
				$results[$stream][$lead_time]['confirm'] += 0;
			}
		}
	}

	fclose($fb_file);
	fclose($tl_file);

	unlink($uploadfile_fb);
	unlink($uploadfile_tl);

	echo "<div class=\"container\"><table id=\"general_table\" class=\"display compact\" cellspacing=\"0\" width=\"100%\">
			<thead>
				<tr>
					<th class=\"dropdown-filter\">Campaign</th>
					<th>Day</th>
					<th>Cost FB</th>
					<th>Revenue</th>
					<th>Profit</th>
					<th>ROI, %</th>
					<th>Leads</th>
					<th>Approve, %</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Campaign</th>
					<th>Day</th>
					<th>Cost FB</th>
					<th>Revenue</th>
					<th>Profit</th>
					<th>ROI, %</th>
					<th>Leads</th>
					<th>Approve, %</th>
				</tr>
			</tfoot>
		<tbody>";

	$keys = array_keys($results);
	foreach ($keys as &$key) {
		$data = array_keys($results[$key]);
		foreach ($data as &$day) {
			$results[$key][$day]['profit'] = $results[$key][$day]['price'] - $results[$key][$day]['cost'];

			if ($results[$key][$day]['cost'] == 0) {
				$results[$key][$day]['roi'] = "--";
			} else {
				$results[$key][$day]['roi'] = round(($results[$key][$day]['price'] - $results[$key][$day]['cost'])/$results[$key][$day]['cost']*100, 2);
				if ($results[$key][$day]['roi'] > 0) {
					echo "<tr class=\"positive_roi\">";
				} else {
					echo "<tr class=\"negative_roi\">";
				}
				// $results[$key][$day]['roi'] .= "%";
			}

			if ($results[$key][$day]['leads'] != 0) {
				$approve = round( $results[$key][$day]['confirm'] / $results[$key][$day]['leads'] * 100 , 2);
				// $approve .= "%";
			} else {
				$approve = "--";
			}
			

			echo "<td>".$campaign_name[$key]."</td>";
			echo "<td>".$day."</td>";
			echo "<td>".$results[$key][$day]['cost']."</td>";
			echo "<td>".$results[$key][$day]['price']."</td>";
			echo "<td>".$results[$key][$day]['profit']."</td>";
			echo "<td>".$results[$key][$day]['roi']."</td>";
			echo "<td>".$results[$key][$day]['leads']."</td>";
			echo "<td>".$approve."</td>";
			echo "</tr>";
		}
	}

	echo "</tbody></table></div>";

	// it needs testing
	echo "<div class=\"container\"><table id=\"small_table\" class=\"display compact\" cellspacing=\"0\" width=\"100%\">
			<thead>
				<tr>
					<th>Campaign</th>
					<th colspan=\"3\">Lifetime</th>
					<th colspan=\"3\">Last 7 day</th>
					<th colspan=\"3\">Previous day</th>
				</tr>
				<tr>
					<th> </th>
					<th>CostFB</th>
					<th>Revenue</th>
					<th>Profit</th>
					<th>CostFB</th>
					<th>Revenue</th>
					<th>Profit</th>
					<th>CostFB</th>
					<th>Revenue</th>
					<th>Profit</th>
				</tr>
			</thead>
		<tbody>";

	foreach ($keys as $stream) {
		// echo "$stream<br>";
		// echo "".strpos($campaign_name[$stream], $stream)."<br>";
		$total_cost = 0;
		$total_revenue = 0;
		$total_profit = 0;
		$total_roi = 0;

		echo "<p>Stream - $stream</p>";

		foreach ($results[$key] as $day_results) {
			$total_cost   += $day_results["cost"];
			$total_price  += $day_results["price"];
			$total_profit += $day_results["profit"];

			echo "<p>".$day_results["cost"]."  ".$day_results["price"]."  ".$day_results["profit"]."</p>";
		}
		break;

		echo "<tr>";
		echo "<td>".$campaign_name[$stream]."</td>";
		echo "<td>".$total_cost."</td>";
		echo "<td>".$total_price."</td>";
		echo "<td>".$total_profit."</td>";
		echo "<td>".$total_cost."</td>";
		echo "<td>".$total_price."</td>";
		echo "<td>".$total_profit."</td>";
		echo "<td>".$total_cost."</td>";
		echo "<td>".$total_price."</td>";
		echo "<td>".$total_profit."</td>";
		echo "</tr>";
	}

	echo "</tbody></table></div>";

	var_dump($keys);
	var_dump($campaign_name);
?>