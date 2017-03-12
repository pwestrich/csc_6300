
<?php

        //paper types for the exist database
        $EXIST_PAPER_TYPES = array(
                "0"  => "Journal Article",
                "1"  => "Book",
                "3"  => "Conference Proceedings",
                "5"  => "Collection",
                "10" => "Tech Report",
                "15" => "Unpublished",
                "16" => "Miscellaneous",
                "47" => "Conference Proceedings");

	function exist_query($xqueryRequest){

		//So I tried using a POST request here like in BaseX, but it kept returning
		//the whole database and ignoring my query. So don't throw too many characters
		//at this, or it might fail.
		$encoded_request = urlencode($xqueryRequest);
		$url = "http://localhost:8080/exist/rest/acm-turing-awards.xml?_query=" . $encoded_request;

                //build the HTTP request and retuen the body of the result
                $curl = curl_init();

                curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => $url,
                ));
		
                $result = curl_exec($curl);

                if ($result == false){

                        echo "Error making request: " . curl_error($curl) . "\n";
                        return "";

                } else return $result;

	}

        function exist_build_query_from_request($author, $title, $type, $abstract){

		$_type = exist_type2id($type);
                $query = 'element articles { for $article in //RECORD ';

                if (!empty($author)){

                        $query = $query . "where \$article//AUTHOR = '$author' ";

                }

                if (!empty($title)){

                        $query = $query . "where contains(\$article/TITLE, '$title') ";

                }

                if (!empty($type) and ($type != "Any")){

                        $query = $query . "where \$article/REFERENCE_TYPE = '$_type' ";

                }

                if (!empty($abstract)){

                        $query = $query . "where contains(\$article/ABSTRACT, '$abstract') ";

                }

                $query = $query . "return element ARTICLE { \$article/TITLE, \$article/REFERENCE_TYPE, \$article/AUTHORS, \$article/ABSTRACT }}";

                return exist_query($query);

        }
	
	//converts a text paper type to an exist number type
	function exist_type2id($type){

		global $EXIST_PAPER_TYPES;

		foreach ($EXIST_PAPER_TYPES as $id => $value){

			if ($type == $value) return $id;

		}

		return "";

	}

	function exist_id2type($id){
	
		global $EXIST_PAPER_TYPES;

		return $EXIST_PAPER_TYPES["$id"];

	}

	function exist_print_results($exist_results){

		$exist_articles = simplexml_load_string($exist_results);

		foreach ($exist_articles->articles->ARTICLE as $article){

			 echo "Reference type(s): ";

                        foreach ($article->REFERENCE_TYPE as $id){

                                echo exist_id2type($id) . ", ";

                        }

                        echo "\nAuthors: ";

                        foreach ($article->AUTHOR as $author){

                                echo "$author, ";

                        }

                        echo "\nTitle: $article->TITLE \n";
                        echo "Abstract: ";

                        if ($article->ABSTRACT == false){

                                echo "NONE";

                        } else {

                                echo $article->ABSTRACT;

                        }

                        echo "\n********************\n";

		}

	}

?>


