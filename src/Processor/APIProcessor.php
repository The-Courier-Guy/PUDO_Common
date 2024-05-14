<?php

namespace Pudo\Common\Processor;

class APIProcessor
{
    public const  API_URL_BASE = 'https://a3mkbgy3r7.execute-api.af-south-1.amazonaws.com/';

    public const API_METHODS = [
        'get_all_lockers' => [
            'type'     => 'GET',
            'endpoint' => 'api/v1/lockers-data',
        ],
        'get_rates'       => [
            'type'     => 'POST',
            'endpoint' => 'api/v1/rates'
        ],
        'booking_request' => [
            'type'     => 'POST',
            'endpoint' => 'api/v1/shipments'
        ],
        'get_waybill'     => [
            'type'     => 'GET',
            'endpoint' => 'generate/waybill'
        ],
        'locker_rates'    => [
            'type'     => 'GET',
            'endpoint' => 'api/v1/locker-rates'
        ],
    ];

    /**
     * @param $getLockersResponse
     *
     * @return array
     */
    public static function mapLockers($getLockersResponse): array
    {
        $getLockersResponse = json_decode($getLockersResponse, true);
        $mappedLockers      = [];
        array_map(function ($locker) use (&$mappedLockers) {
            $mappedLockers[$locker['code']] = $locker;
        }, $getLockersResponse);

        return $mappedLockers;
    }

    /**
     * @param $method
     * @param $content
     * @param $testMode
     *
     * @return array
     */
    public function getRequest($method, $content, $testMode = false): array
    {
        $url  = self::API_URL_BASE . self::API_METHODS[$method]['endpoint'];
        $type = self::API_METHODS[$method]['type'];

        if ($type === 'GET' && $content) {
            $url .= $content;
        }

        return ['url' => $url, 'type' => $type];
    }
}
