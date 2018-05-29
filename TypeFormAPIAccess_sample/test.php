<?php

require __DIR__ . '/vendor/autoload.php';

use \GuzzleHttp\Client as GuzzleClient;

class TypeFormClient
{
    protected $guzzleClient='';
    protected $typeFormBaseUri='https://api.typeform.com/';
    protected $token='token_goes_here';
    protected $response;
    protected $response_status;
    protected $response_body;

    public function __construct()
    {
        $this->guzzleClient = new GuzzleClient();
    }

    /**
     * getAllForms
     * Connects to the TypeFormService API and retrieves the questions for a form
     *
     * @access public
     * @return string access_token
     */
    public function getAllForms()
    {
        $headers = $options = $query_params = [];
        $forms = $this->getFromTypeFormService($this->typeFormBaseUri . "/forms", $headers, $options, $query_params);
        return $this->response_status == '200' ? $this->response_body : false;
    }

    /**
     * guzzleTypeFormService
     *
     * Uses the Guzzle client to connect to the TypeFormService API.
     * Stores response from TypeFormService in class properties for later use.
     *
     * @param string $http_method
     * @param string $api_endpoint
     * @param array $headers
     * @param array $payload
     * @param array $query_params
     * @access public
     * @return void
     */
    public function guzzleTypeFormService($http_method, $api_endpoint, $headers, $payload = [], $query_params = [], $body = null)
    {
        if ($this->token !== NULL) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }
        //
        //........
        //
    }

    /**
     * getFromTypeFormService
     *
     * Manages retrieval of information from TypeFormService API.
     * Handles retrieval of single results as well as paged result-sets.
     * Results are cached when the app is in a production environment.
     *
     * @param string $endpoint
     * @param array $headers
     * @param array $options
     * @param array $query_params
     * @access public
     * @return \Illuminate\Support\Collection
     */
    public function getFromTypeFormService($endpoint, $headers, $options, $query_params, $useCache = false)
    {

        if (isset($query_params['page'])) {
            $query_params['pageSize'] = config('typeform.page_size');
        }

        $this->guzzleTypeFormService('GET', $endpoint, $headers, $options, $query_params);
        $results = $this->response_body;

        return $results;
    }

    /**
     * postToTypeFormService
     *
     * Manages posting of information to TypeFormService API.
     *
     * @param string $endpoint
     * @param array $headers
     * @param array $options
     * @param array $query_params
     * @access public
     * @return \Illuminate\Support\Collection
     */
    public function postToTypeFormService($endpoint, $headers, $options, $query_params, $body)
    {
        $this->guzzleTypeFormService('POST', $endpoint, $headers, $options, $query_params, $body);
        $results = $this->response_body;
        return $results;
    }
}

$typeForm = new TypeFormClient();

var_dump($typeForm->getAllForms());
