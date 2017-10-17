# webhook_restapi
WebHooks - упрощенный вариант rest-событий и rest-команд, без написания приложения.

<a href="https://dev.1c-bitrix.ru/rest_help/oauth/webhooks.php">Webhooks</a> - Получение доступа к REST API <br>
<a href="https://dev.1c-bitrix.ru/community/blogs/chaos/crm-sozdanie-lidov-iz-drugikh-servisov.php">Список всех возможных передаваемых параметров</a>

```php
$queryUrl = 'https://rarusweb.bitrix24.ru/rest/7/dbd234rkjbcpnu/crm.lead.add.json'; // Строка обращения к вебхуку 
$queryData = http_build_query(array( // Передаем данные
	'fields' => array(
	'TITLE' => 'ТестовыйЛид','NAME' => 'Афанасий',
	'PHONE' => array(array("VALUE" => '123123123', "VALUE_TYPE" => "WORK" )),
	'EMAIL' => array(array("VALUE" => 'afanasiy@lidov.net' , "VALUE_TYPE" => "WORK" )),
	'COMMENTS' => 'Лид со стороннего сайта'
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
```
**$queryUrl** - Обращаемся к вебхуку по методу crm.lead.add в формате JSON
**$queryData** - Массив передаваемых данных
