<?php

$name=$argv[1];
$language="fr";
$search = file_get_contents(sprintf("http://www.myapifilms.com/tmdb/searchMovie?movieName=%s&format=JSON&language=%s&includeAdult=1", urlencode($name), $language));

if(!$search) {
    return;
}

$searchJson=json_decode($search);

if(!isset($searchJson->results) || !count($searchJson->results)) {
	return;
}

echo json_encode(($searchJson->results[0]));
