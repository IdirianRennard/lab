<?php

// NOTE: The below contains extracted functions of a script designed to contact
// the Payflow Pro Gateway and pull details on each profile id. We do this by walking
// the live profile ids stored in our database and making a recurring profile request
// per profile and then updating our database to be in sync with the profile data.
//
// This process takes a very long time and we've had continuing problems for some time.
// What is happening is that we are receive intermittent timeouts at line 131 where
// $this->set_errors('Problem connecting (' . $headers['http_code'] . ')') will print
// "Problem connecting (0)".
//
// Payflow Pro *really* needs to have a callback function so that we don't have to poll
// everyday (and encounter these problems). The current process seems archaic.

$PARTNER = "verisign";
$VENDOR = "shift05";
$USER = "testuser";

// TODO: supply your own testing pass
$PWD = "Sp1d3rm4n";

// TODO: enter a profileid here
$profileid = 'XXXXXXXXXXXX';


$payflow = new payflow($VENDOR, $USER, $PARTNER, $PWD, 1);
/*if ($payflow->get_errors()) {
	print("ERROR<br /><br />");
} else {
	$payflow->inquire_recurring_profile($profileid);
}*/
print_r($payflow);



//---------------------------------------------------------------------------------------

// get recurring detailed history
function inquire_recurring_history($orig_profile_id) {

	if (strlen($orig_profile_id) < 3) {
		$this->set_errors('OrigID not valid');
		return;
	}

	// body
	$plist = 'USER=' . $this->user . '&';
	$plist .= 'VENDOR=' . $this->vendor . '&';
	$plist .= 'PARTNER=' . $this->partner . '&';
	$plist .= 'PWD=' . $this->password . '&';
	$plist .= 'TRXTYPE=' . 'R' . '&'; // R = Recurring, S = Sale transaction, A = Authorisation, C = Credit, D = Delayed Capture, V = Void
	$plist .= 'ACTION=' . 'I' . '&'; // A = Add, M = Modify, R = Reactivate, C = Cancel, I = Inquiry, P = Payment
	$plist .= "ORIGPROFILEID=" . $orig_profile_id . "&"; // ORIGPROFILEID is pulled from the local DB
	$plist .= "PAYMENTHISTORY=" . 'Y' . "&"; // Y=Payments, O=Optional payments
	$plist .= 'VERBOSITY=MEDIUM';

	return $this->send_plist_with_curl($plist);
}

// cancel a recurring profile
function inquire_recurring_profile($orig_profile_id) {

	if (strlen($orig_profile_id) < 3) {
		$this->set_errors('OrigID not valid');
		return;
	}

	$plist = 'USER=' . $this->user . '&';
	$plist .= 'VENDOR=' . $this->vendor . '&';
	$plist .= 'PARTNER=' . $this->partner . '&';
	$plist .= 'PWD=' . $this->password . '&';
	$plist .= 'TRXTYPE=' . 'R' . '&'; // R = Recurring, S = Sale transaction, A = Authorisation, C = Credit, D = Delayed Capture, V = Void
	$plist .= 'ACTION=' . 'I' . '&'; // A = Add, M = Modify, R = Reactivate, C = Cancel, I = Inquiry, P = Payment
	$plist .= "ORIGPROFILEID=" . $orig_profile_id . "&"; // ORIGPROFILEID is pulled from the local DB
	$plist .= 'VERBOSITY=MEDIUM';

	return $this->send_plist_with_curl($plist);
}

//---------------------------------------------------------------------------------------

function send_plist_with_curl($plist, $oneshot = true) {

	// $oneshot = do connection as oneshot attempt (to avoid duplicate transactions)
	// unless otherwise told to do so (by settings this to false)

	$headers = $this->get_curl_headers();
	$headers[] = "X-VPS-Request-ID: " . $request_id;

	$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"; // play as Mozilla
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $this->submiturl);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
	curl_setopt($ch, CURLOPT_HEADER, 1); // tells curl to include headers in response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
	//curl_setopt($ch, CURLOPT_TIMEOUT, 90); // times out after 90 secs
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // this line makes it work under https
	curl_setopt($ch, CURLOPT_POSTFIELDS, $plist); //adding POST data
	//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2); //verifies ssl certificate
	//curl_setopt($ch, CURLOPT_FORBID_REUSE, TRUE); //forces closure of connection when done
	curl_setopt($ch, CURLOPT_POST, 1); //data sent as POST

	// fix for network problems try 3x (with 5 second pauses)...

	for ($i = 0; $i++ <= 3; $i++) {

		// $rawHeader = curl_exec($ch); // run the whole process
		// $info = curl_getinfo($ch); //grabbing details of curl connection
		$result = curl_exec($ch);
		$headers = curl_getinfo($ch);

		// default is to break now (try just once)
		if ($oneshot == true) {
			break;
		}

		if ($headers['http_code'] != 200) {
			sleep(5);  // Let's wait 5 seconds to see if its a temporary network issue.
		}
		else if ($headers['http_code'] == 200) {
			// we got a good response, drop out of loop.
			break;
		}
	}

	// if tried 3x and no connection then show error and return

    if ($headers['http_code'] != 200) {
    	$this->set_errors('Problem connecting (' . $headers['http_code'] . ')');
    	curl_close($ch);
    	return;
    }

	// close the connection
	curl_close($ch);

	$pfpro = $this->get_curl_result($result); //result arrray

	if (isset($pfpro['RESULT']) && $pfpro['RESULT'] == 0) {
		return $pfpro;
	} else {
		$this->set_errors($pfpro['RESPMSG'] . ' Error: '. $pfpro['RESULT']);
		return $pfpro;
	}
}

?>
