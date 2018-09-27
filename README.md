# webhook_restapi
WebHooks - упрощенный вариант rest-событий и rest-команд, без написания приложения.

<a href="https://dev.1c-bitrix.ru/rest_help/oauth/webhooks.php">Webhooks</a> - Получение доступа к REST API <br>
<a href="https://dev.1c-bitrix.ru/community/blogs/chaos/crm-sozdanie-lidov-iz-drugikh-servisov.php">Список всех возможных передаваемых параметров</a>


Пример привязки формы обратной связи к Битрикс24 через webhook_restapi при помощи события:
```php
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("CRestApi", "generateLead"));

/**
 * Класс, включающий в себя методы Rest API
 */
class CRestApi {
    function generateLead(&$arFields) {

        if($arFields[IBLOCK_ID] == IBLOCK_FEEDBACK_ID)
        {
            CModule::IncludeModule("iblock");
            $webhook = 'https://yoururl.bitrix24.ru/rest/7/asdasgks243tokenj2krw/';

        	/* Webhook*/
        	$queryUrl = $webhook.'crm.lead.add.json'; // Строка обращения к вебхуку
            if(isset($arFields["PROPERTY_VALUES"]["SOURCE"])) {
                $sourсe = '['.strtolower($arFields["PROPERTY_VALUES"]["SOURCE"]).']';
            }
            else {
                $sourсe = '';
            }

            // REST Api
        	$queryData = http_build_query(array( // Передаем данные
        		'fields' => array(
                            'TITLE' => $arFields["NAME"].' (www.rarusweb.ru) '.$sourсe,
                            'NAME' => $arFields["PROPERTY_VALUES"]["FIO"],
                            'PHONE' => array(array("VALUE" => preg_replace("/[^,.0-9]/", '', $arFields["PROPERTY_VALUES"]["PHONE"]), "VALUE_TYPE" => "WORK" )),
                            'PHONE_WORK' => preg_replace("/[^,.0-9]/", '', $arFields["PROPERTY_VALUES"]["PHONE"]),
                            'EMAIL' => array(array("VALUE" => $arFields["PROPERTY_VALUES"]["EMAIL"], "VALUE_TYPE" => "WORK" )),
                            'EMAIL_WORK' => $arFields["PROPERTY_VALUES"]["EMAIL"],
                            'COMMENTS' =>  $arFields["PROPERTY_VALUES"]["PHONE"].' '.$arFields["PROPERTY_VALUES"]["EMAIL"].'<br>Лид сгенерирован автоматически. Источник: rarusweb.ru.<br> '.$arFields["PROPERTY_VALUES"]["COMMENT"],
                            'SOURCE_ID' => 'WEB',
                            //'ASSIGNED_BY_ID ' => 7,
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
            /* Webhook*/
        }
    }
}
```
**$queryUrl** - Обращаемся к вебхуку по методу crm.lead.add в формате JSON
**$queryData** - Массив передаваемых данных
