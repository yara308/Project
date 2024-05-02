<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

if (isset($request->post['custom'])) {
	$order_id = $request->post['custom'];
} else {
	$order_id = 0;
}

$test_mode = 1;
$payment_pp_standard_email = 'techbuzz69@gmail.com';

$order_model = registry()->get('loader')->model('quotation');
// $order_info = $order_model->getOrder($order_id);
$order_info = $order_model->getQuotationInfo($order_id);

if ($order_info) {
	$request = 'cmd=_notify-validate';

	foreach ($request->post as $key => $value) {
		$request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
	}

	if (!$test_mode) {
		$curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
	} else {
		$curl = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
	}

	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($curl);

	// if (!$response) {
	// 	$this->log->write('PP_STANDARD :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
	// }

	// if ($this->config->get('payment_pp_standard_debug')) {
	// 	$this->log->write('PP_STANDARD :: IPN REQUEST: ' . $request);
	// 	$this->log->write('PP_STANDARD :: IPN RESPONSE: ' . $response);
	// }

	if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($request->post['payment_status'])) 
	{	
		$order_status = 'pending';
		$payment_status = $request->post['payment_status'];

		// $order_status_id = $this->config->get('config_order_status_id');
		switch($request->post['payment_status']) {
			case 'Completed':
				$receiver_match = (strtolower($request->post['receiver_email']) == strtolower($payment_pp_standard_email));

				// $total_paid_match = ((float)$request->post['mc_gross'] == $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false));

				// if ($receiver_match && $total_paid_match) {
				// 	$order_status_id = $this->config->get('payment_pp_standard_completed_status_id');
				// }
				
				// if (!$receiver_match) {
				// 	$this->log->write('PP_STANDARD :: RECEIVER EMAIL MISMATCH! ' . strtolower($request->post['receiver_email']));
				// }
				
				// if (!$total_paid_match) {
				// 	$this->log->write('PP_STANDARD :: TOTAL PAID MISMATCH! ' . $request->post['mc_gross']);
				// }

				$order_status = 'complete';
				break;
			case 'Canceled_Reversal':
			case 'Denied':
			case 'Expired':
			case 'Failed':
			case 'Pending':
			case 'Processed':
			case 'Refunded':
			case 'Reversed':
			case 'Voided':
					$order_status = 'canceled';
				break;
		}

		$statement = db()->prepare("UPDATE `quotation_info' SET `status` = ?, `payment_status` = ? WHERE `reference_no` = ?");
		$statement->execute(array($order_id, $order_status, $payment_status, $order_id));
	}
	curl_close($curl);
}