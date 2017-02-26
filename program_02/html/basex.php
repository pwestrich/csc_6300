
<?php

	//Function to send xquery to the basex server
	function basex_query($xqueryRequest){
		
		//get the query template from a file and paste the xquery into it	
		$requestFormat = file_get_contents("./basex_query_template.xml");
		$requestBody = sprintf($requestFormat, $xqueryRequest);

		//build the HTTP request and retuen the body of the result
		$curl = $curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_URL => "http://localhost:8984/rest/medsamp2012.xml"
			CURLOPT_POSTFIELDS => $requestBody

		));

		return curl_exec($curl);

	}
	
	//Function that returns an array of paper types from the basex server
	function basex_get_paper_types(){


	}

	//Function that will build and execute the xquery for the absex server
	function basex_build_query_from_request($request){


	}

?>

