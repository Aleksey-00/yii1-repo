<?php
class SmsService {
    private $apiKey = 'AW8HWBA09C41RI2H5K50835BGSJY1SIH5J87V4O8BL51I1B1SO6SWHKH7I766VA7';
    private $apiUrl = 'https://smspilot.ru';

    public function send($to, $text) {
        $params =;
        $url = $this->apiUrl . '?' . http_build_query($params);
        $response = @file_get_contents($url);
        return json_decode($response, true);
    }
}
