/*****************************************************************************************

//cURL info to HubSpot
function curl_to_hubspot($entry, $str_post, $formID){

	$hubspotutk = $_COOKIE['hubspotutk'];
	
	$hs_context = array(
				'hutk'=> $hubspotutk,
				'ipAddress' =>['ip'],
				'pageUrl' => $entry['source_url'],
				'pageName' => get_the_title($entry['post_id'])
				);
				
	$hs_context_json = json_encode($hs_context);
	
	$str_post .= "&hs_context= . urlencode($hs_context_json);
	
	$endpoint = 'https://forms.hubspot.com/uploads/form/v2/' . HSPORTAL . '/' . $formID;
	
	$ch = @curl_init();
	@curl_setopt($ch, CURLOPT_POST, true);
	@curl_setopt($ch, CURLOPT_POSTFIELDS, $str_post);
	@curl_setopt($ch, CURLOPT_URL, $endpoint);
	@curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: applications/x-www-form-urlencoded'));
	@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = @curl_exec($ch); //Log the response from HubSpot as needed
	@curl_close($ch);
	//print_r($response);
}

//Apply online function to send to HubSpot
function apply_online_to_hubspot(){
	//HubSPot Form ID
	$hsformID = '250f4ed9-491c-446c-bfbd-d88f1213e108';

//Field mapping. HS on left, gravity forms on right
	$str_post = "firstname=" . urlencode($entry["1"])
				. "&lastname=" . urlencode($entry["2"])
				. "&email=" . urlencode($entry["3"]);

// Send the data to HubSpot
curl_to_hubspot($entry, $str_post, $hsformID);
				
} add_action("gform_after_submission_1", "apply_online_to_hubspot");
