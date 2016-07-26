<?php
/**
 * Created by PhpStorm.
 * User: fajardm
 * Date: 26/07/16
 * Time: 13:10
 */

class BingSearchAPI
{
    /**
     * BING API URL
     */
    const API_URL = "https://api.datamarket.azure.com/Bing/Search/v1/";
    /**
     * @var string Build query
     */
    private $buildQuery;
    /**
     * @var resource
     */
    private $context;

    /**
     * SearchBingAPI constructor.
     * @param string $buildQuery
     */
    public function __construct($accountKey)
    {
        $cred = sprintf('Authorization: Basic %s',
            base64_encode($accountKey . ":" . $accountKey));

        $this->context = stream_context_create(array(
            'http' => array(
                'header' => $cred
            )
        ));
    }

    /**
     * Invoke this method before another
     * @param string $type
     * @param string $q
     */
    public function search($type = "Web", $q = '')
    {
        $this->buildQuery = $type . "?Query=" . urlencode("'$q'");
    }

    /**
     * @param string $market
     */
    public function market($market = 'en-US')
    {
        $this->buildQuery .= "&Market=" . urlencode("'$market'");
    }

    /**
     * @param string $adult
     */
    public function adult($adult = 'Off')
    {
        $this->buildQuery .= "&Adult=" . urlencode("'$adult'");
    }

    /**
     * @param string $latitude
     */
    public function latitude($latitude = '47.603450')
    {
        $this->buildQuery .= "&Latitude=" . $latitude;
    }

    /**
     * @param string $longitude
     */
    public function longitude($longitude = '-122.329696')
    {
        $this->buildQuery .= "&Longitude=" . $longitude;
    }

    /**
     * @param string $type
     */
    public function webFileType($type = 'DOC')
    {
        $this->buildQuery .= "&WebFileType=" . urlencode("'$type'");
    }

    /**
     * @return JSON Object
     */
    public function get()
    {
        $url = self::API_URL . $this->buildQuery . '&$format=json';
        $response = file_get_contents($url, 0, $this->context);
        $jsonOjb = json_decode($response);
        $this->buildQuery = "";
        return $jsonOjb->d->results;
    }

}
