<?php

declare(strict_types=1);

namespace Toyrone\smsApi;


use GuzzleHttp\Client;
use Toyrone\SmsApi\Exceptions\IsNull;
use Toyrone\SmsApi\Exceptions\IsEmpty;

// require 'vendor/autoload.php';

class SmsApi {
    /**
     * Base Api Url
     */

    const baseUrl = 'https://localhost:3000';
    /**
     * Create a new Skeleton Instance
     */

    /**
     * Public key
     * @var string
     */
    protected $publicKey;

    /**
     * secret
     * @var string
     */
    protected $secret;

    /**
     *  Response from requests made to Jusibe
     * @var mixed
     */
    protected $response;

    public function __construct($publicKey = null, $secret = null) {
        // constructor body
        if (isNull($publicKey)) {
            throw IsNull::create("The Public Key can not be null. Please pass it to the constructor");
        }

        if (isNull($secret)) {
            throw IsNull::create("The secret key can not be null. Please pass it to the constructor");
        }

        $this->publicKey = $publicKey;
        $this->secret = $secret;
        $this->prepareRequest();
    }

    /**
     * Instantiate Guzzle Client and prepare request for http operations
     * @return none
     */
    private function prepareRequest(string $phrase): string
    {
        $this->client = new Client(['base_uri' => self::baseURL]);
    }

    /**
     * Perform a POST request
     * @param  string $relativeUrl
     * @param  array $data
     * @return none
     */
    private function performPostRequest($url, $data)
    {
        $this->response = $this->client->request('POST', $url, [
            'form' => $data,
            'auth' => [$this->publicKey, $this->secret]
        ]);
    }

    /**
     * Send SMS
     * @param  array $payload
     * @return $this
     */
    public function sendSMS($payload = [])
    {
        if (empty($payload)) {
            throw IsEmpty::create("Message Payload can not be empty. Please fill the appropriate details");
        }

        $this->performPostRequest('/sms/send_sms', $payload);

        return $this;
    }

    /**
     * Return the response object of any operation
     * @return object
     */
    public function getResponse()
    {
        return json_decode($this->response->getBody());
    }
}
