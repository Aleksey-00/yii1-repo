<?php

class SmsService
{
    public $apiKey;
    public $apiUrl = 'https://smspilot.ru/api.php';

    public function init()
    {
        if (empty($this->apiKey)) {
            Yii::log('SmsService apiKey is not configured', CLogger::LEVEL_ERROR);
        }
    }

    /**
     * Отправка SMS-сообщения.
     *
     * @param string $to
     * @param string $text
     * @return array|null
     */
    public function send($to, $text)
    {
        if (empty($this->apiKey)) {
            return null;
        }

        $params = array(
            'send' => $text,
            'to' => $to,
            'apikey' => $this->apiKey,
            'format' => 'json',
        );

        $url = $this->apiUrl . '?' . http_build_query($params);
        $response = @file_get_contents($url);

        if ($response === false) {
            Yii::log('SmsService request failed for ' . $to, CLogger::LEVEL_ERROR);
            return null;
        }

        $decoded = json_decode($response, true);
        if ($decoded === null) {
            Yii::log('SmsService invalid JSON response: ' . $response, CLogger::LEVEL_ERROR);
        }

        return $decoded;
    }
}
