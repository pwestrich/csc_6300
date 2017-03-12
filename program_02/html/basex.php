
<?php

	//Function to send xquery to the basex server
	function basex_query($xqueryRequest){
		
		//get the query template from a file and paste the xquery into it	
		$requestFormat = file_get_contents("./basex_query_template.xml");
		$requestBody = sprintf($requestFormat, $xqueryRequest);

		//build the HTTP request and retuen the body of the result
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => 1,
			CURLOPT_URL => "http://localhost:8984/rest/medsamp2012",
			CURLOPT_POSTFIELDS => $requestBody,
			CURLOPT_HTTPHEADER => array("Authorization: Basic YWRtaW46YWRtaW4=") //admin:admin
		));
		
		$result = curl_exec($curl);

		if ($result == false){

			echo "Error making request: " . curl_error($curl) . "\n";
			return "";

		} else return $result;

	}
	
	//Function that returns an array of paper types from the basex server
	function basex_get_paper_types(){

		$xquery = 'for $x in distinct-values(//PublicationType) order by $x return element option { attribute value {$x}, $x }';
		return basex_query($xquery);

	}

	//Function that will build and execute the xquery for the absex server
	function basex_build_query_from_request($author, $title, $type, $abstract){

		$query = 'element articles { for $article in //Article ';

		if (!empty($author)){

			$query = $query . "where \$article/AuthorList/Author/LastName = '$author' ";

		}

		if (!empty($title)){

			$query = $query . "where contains(\$article//Title, '$title') ";

		}

		if (!empty($type) and ($type != "Any")){

			$query = $query . "where \$article//PublicationType = '$type' ";

		}

		if (!empty($abstract)){

			$query = $query . "where contains(\$article//Abstract, '$abstract') ";

		}

		$query = $query . "return element article { \$article//*[self::Author or self::Title or self::AbstractText or self::PublicationType]}}";

		return basex_query($query);


	}

	//prints the results to the screen
	function basex_print_results($basex_results){

		$basex_articles = simplexml_load_string($basex_results);

	        foreach ($basex_articles->article as $article){

        	        echo "Reference type(s): ";

        	        foreach ($article->PublicationType as $type){

        	                echo "$type, ";

                	}

             		echo "\nAuthors: ";

	                foreach ($article->Author as $author){

        	        	echo "$author->ForeName $author->LastName, ";

        	        }

        	        echo "\nTitle: $article->Title \n";
        	        echo "Abstract: ";

        	        if ($article->AbstractText == false){
	
	                        echo "NONE";

	                } else {

        	                echo $article->AbstractText;

                	}

               	 	echo "\n********************\n";

        	}

	}


?>

