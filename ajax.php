if(isset($idElement))
{
	$queryUrl = 'https://rarusweb.bitrix24.ru/rest/7/dbd21dsaas32137bcpnu/crm.lead.add.json'; // Строка обращения к вебхуку 
	$queryData = http_build_query(array( // Передаем данные
		'fields' => array(
		'TITLE' => $_GET['name'].' — ['.$_GET['type'].'] (rarusweb.ru)',
		'NAME' => $_GET['name'],
		'PHONE' => array(array("VALUE" => $_GET['phone'], "VALUE_TYPE" => "WORK" )),
		'EMAIL' => array(array("VALUE" => $_GET['email'], "VALUE_TYPE" => "WORK" )),
		'COMMENTS' => 'Лид сгенерирован автоматически. Источник: rarusweb.ru. <br> '.$_GET['desc'],
		'SOURCE_ID' => 5,
		'ASSIGNED_BY_ID ' => 1,
		) 
	));
	$curl = curl_init(); // метод cURL
		curl_setopt_array($curl, array(
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $queryUrl,
		CURLOPT_POSTFIELDS => $queryData,
	));
	$result = curl_exec($curl);  curl_close($curl);
}
