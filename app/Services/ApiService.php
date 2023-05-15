<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use App\Exceptions\Handler;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\Response;

/**
 * API Class
 *
 * @since 1.4.0
 */
class ApiService {

    /**
     * Http Response object
     *
     * @var Http/Client/Response
     */
    private $_response;

    /**
     * Http Status Code
     *
     * @var int
     */
    private $_statusCode;

    /**
     * Guzzle http client instance
     *
     * @var Client
     */
    public $httpClient;

    /**
     * Creates the api instance
     *
     * @param array $options          http client configuration
     * @param bool  $isSetBearerToken Is whether we can set bearer token while creating object or not
     */
    public function __construct(array $options = []) {
        $this->httpClient = new Client($options);
    }

    /**
     * Calling the api url
     *
     * @param  string        $url       relative api url
     * @param  string        $method    api method (get, post, put, patch, delete, trace)
     * @param  array         $headers   api http headers
     * @param  string|array  $payload   api payload
     *
     * @return void
     */
    public function call(string $url, string $method, array $headers = [], $payload = ''): void{
        try {
            if (is_array($payload)) {
                $request         = new Request($method, $url, $headers);
                $this->_response = $this->httpClient->send($request, $payload);
            }
            else {
                $request         = new Request($method, $url, $headers, $payload);
                $this->_response = $this->httpClient->send($request);
            }
        }
        catch (ClientException $exception) {
            $this->_statusCode = $exception->getCode();
            app(Handler::class)->report($exception);
            $response        = $exception->getResponse();
            $this->_response = $response->getBody();
        }
        catch (BadResponseException $exception) {
            $this->_statusCode = $exception->getCode();
            app(Handler::class)->report($exception);
            $response        = $exception->getResponse();
            $this->_response = $response->getBody();
        }
        catch (GuzzleException $exception) {
            $this->_statusCode = $exception->getCode();
            app(Handler::class)->report($exception);
        }
        catch (ConnectException $exception) {
            $this->_statusCode = $exception->getCode();
            app(Handler::class)->report($exception);
        }
        catch (Exception $exception) {
            $this->_statusCode = $exception->getCode();
            app(Handler::class)->report($exception);
        }
    }

    /**
     * Returns the api response as string
     *
     * @return string
     */
    public function getResponse() {
        if ($this->_response instanceof Stream) {
            return $this->_response->getContents();
        }

        return $this->_response->getBody()->getContents();
    }

    /**
     * Returns the response payload
     *
     * @return array
     */
    public function json(): array {
        if ($this->_response instanceof Stream) {
            return json_decode((string)$this->_response->getContents(), true);
        }

        return $this->_response->json();
    }

    /**
     * Returns the response payload
     *
     * @return array
     */
    public function getResponseArray(): array {
        try {
            if ($this->_response instanceof Stream) {
                return json_decode((string)$this->_response->getContents(), true);
            }

            $responseArray = $this->_response ? json_decode((string)$this->_response->getBody(), true) : [];
            return $responseArray ?: [];
        }
        catch(Exception $exception) {
            return [];
        }
    }

    /**
     * Returns the response status code
     *
     * @return integer
     */
    public function getStatusCode() {
        if ($this->_statusCode) {
            return $this->_statusCode;
        }

        if ($this->_response instanceof Stream) {
            return Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $this->_response->getStatusCode();
    }

    /**
     * Returns the particular response header
     *
     * @param  string $header response header name
     *
     * @return string         response value
     */
    public function getResponseHeader(string $header): string {
        if ($this->_response->hasHeader($header)) {
            return $this->_response->getHeader($header)[0];
        }

        return "";
    }

    /**
     * Returns the response headers
     *
     * @return array
     */
    public function getResponseHeaders(): array {
        $headers = $this->_response->getHeaders();
        $responseHeaders = [];
        foreach ($headers AS $header => $value) {
            $responseHeaders[$header] = $value[0];
        }

        return $responseHeaders;
    }
}
