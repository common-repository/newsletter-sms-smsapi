<?php

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class SmsapiPsrRequest extends \WP_REST_Request implements ServerRequestInterface
{
    private $stream;
    private $uri;
    private $requestTarget;

    public function __construct($method = '', $route = '', $attributes = [])
    {
        parent::__construct($method, $route, $attributes);
        $this->setUri($route);
    }

    private function setUri($route)
    {
        if ($route instanceof UriInterface) {
            $this->uri = $route;
        } else {
            $this->uri = new Uri($route);
        }
    }

    public function getRequestTarget()
    {
        if ($this->requestTarget !== null) {
            return $this->requestTarget;
        }

        $target = $this->uri->getPath();
        if ($target == '') {
            $target = '/';
        }
        if ($this->uri->getQuery() != '') {
            $target .= '?' . $this->uri->getQuery();
        }

        return $target;
    }

    public function withRequestTarget($requestTarget)
    {
        throw new Exception('Not implemented');
    }

    public function getMethod()
    {
        return $this->get_method();
    }

    public function withMethod($method)
    {
        $this->set_method($method);

        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $this->setUri($uri);

        return $this;
    }

    public function getServerParams()
    {
        throw new Exception('Not implemented');
    }

    public function getCookieParams()
    {
        throw new Exception('Not implemented');
    }

    public function withCookieParams(array $cookies)
    {
        throw new Exception('Not implemented');
    }

    public function getQueryParams()
    {
        throw new Exception('Not implemented');
    }

    public function withQueryParams(array $query)
    {
        throw new Exception('Not implemented');
    }

    public function getUploadedFiles()
    {
        throw new Exception('Not implemented');
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        throw new Exception('Not implemented');
    }

    public function getParsedBody()
    {
        throw new Exception('Not implemented');
    }

    public function withParsedBody($data)
    {
        throw new Exception('Not implemented');
    }

    public function getAttributes()
    {
        throw new Exception('Not implemented');
    }

    public function getAttribute($name, $default = null)
    {
        throw new Exception('Not implemented');
    }

    public function withAttribute($name, $value)
    {
        throw new Exception('Not implemented');
    }

    public function withoutAttribute($name)
    {
        throw new Exception('Not implemented');
    }

    public function getProtocolVersion()
    {
        throw new Exception('Not implemented');
    }

    public function withProtocolVersion($version)
    {
        throw new Exception('Not implemented');
    }

    public function getHeaders()
    {
        return $this->get_headers();
    }

    public function hasHeader($name)
    {
        throw new Exception('Not implemented');
    }

    public function getHeader($name)
    {
        throw new Exception('Not implemented');
    }

    public function getHeaderLine($name)
    {
        throw new Exception('Not implemented');
    }

    public function withHeader($name, $value)
    {
        $this->add_header($name, $value);

        return $this;
    }

    public function withAddedHeader($name, $value)
    {
        throw new Exception('Not implemented');
    }

    public function withoutHeader($name)
    {
        throw new Exception('Not implemented');
    }

    public function getBody()
    {
        if (!$this->stream) {
            $this->stream = Utils::streamFor('');
        }

        return $this->stream;
    }

    public function withBody(StreamInterface $body)
    {
        if ($body === $this->stream) {
            return $this;
        }

        $this->stream = $body;

        return $this;
    }
}
