<?php

use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

require_once SMSAPI_PLUGIN_PATH . '/classes/RequestFailedException.php';

class SmsapiPsrClient implements ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $url = $this->prepareUrl($request);
        $method = $request->getMethod();
        $headers = $this->prepareHeaders($request->getHeaders());
        $attributes = $this->prepareAttributes($request->getBody());

        return $this->execute($url, $method, $headers, $attributes);
    }

    private function prepareAttributes($requestBody)
    {
        $attributes = null;

        if (!is_null($requestBody) && strlen((string)$requestBody)) {
            parse_str((string)$requestBody, $attributes);
        }

        return $attributes;
    }

    private function prepareUrl(RequestInterface $request): string
    {
        return sprintf(
            "%s://%s%s",
            $request->getUri()->getScheme(),
            $request->getUri()->getHost(),
            $request->getRequestTarget()
        );
    }

    private function prepareHeaders($headers): array
    {
        $flatHeaders = [];

        foreach ($headers as $name => $header) {
            $flatHeaders[$name] = implode(" ", $header);
        }

        return $flatHeaders;
    }

    private function execute(string $url, string $method, array $headers, $attributes = []): ResponseInterface
    {
        switch ($method) {
            case 'GET':
                $response = wp_remote_get($url, ['headers' => $headers]);
                break;
            case 'POST':
                $response = wp_remote_post($url, [
                    'body' => $attributes,
                    'timeout'     => '5',
                    'redirection' => '5',
                    'httpversion' => '1.1',
                    'blocking'    => true,
                    'headers'     => $headers,
                    'cookies'     => [],
                ]);
                break;
            case 'DELETE':
                $response = wp_remote_request($url, [
                    'method' => 'DELETE',
                    'timeout'     => '5',
                    'redirection' => '5',
                    'httpversion' => '1.1',
                    'blocking'    => true,
                    'headers'     => $headers,
                    'cookies'     => [],
                ]);
                break;
            case 'PUT':
                $response = wp_remote_request($url, [
                    'method' => 'PUT',
                    'body' => $attributes,
                    'timeout'     => '5',
                    'redirection' => '5',
                    'httpversion' => '1.1',
                    'blocking'    => true,
                    'headers'     => $headers,
                    'cookies'     => [],
                ]);
                break;
        }

        $this->checkErrors($response);

        $responseCode = wp_remote_retrieve_response_code($response);
        $responseHeaders = wp_remote_retrieve_headers($response);
        $responseBody = wp_remote_retrieve_body($response);

        return new Response($responseCode, $responseHeaders->getAll(), $responseBody);
    }

    private function checkErrors($response)
    {
        if (is_wp_error($response)) {
            /**
             * @var WP_Error $response
             */
            throw new RequestFailedException($response->get_error_message());
        }
    }
}
