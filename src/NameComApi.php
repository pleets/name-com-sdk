<?php

namespace Pleets\NameCom;

use EasyHttp\GuzzleLayer\GuzzleClient;
use EasyHttp\LayerContracts\Contracts\EasyClientContract;
use EasyHttp\LayerContracts\Contracts\HttpClientRequest;
use Pleets\NameCom\Domains\Requests\CreateDomainRequest;
use Pleets\NameCom\Responses\AbstractResponse;
use Pleets\NameCom\Responses\GetResponse;
use Pleets\NameCom\Responses\PostResponse;

class NameComApi
{
    protected EasyClientContract $client;
    protected string $baseUri;
    protected string $username;
    protected string $password;
    protected array $token;

    public function __construct(string $baseUri)
    {
        $this->baseUri = $baseUri;
        $this->client = new GuzzleClient();
    }

    public function setCredentials(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function withHandler(callable $handler)
    {
        $this->client->withHandler($handler);
    }

    protected function setAuthentication(): HttpClientRequest
    {
        return $this->client->getRequest()
            ->setHeader('Authorization', 'Basic ' . base64_encode($this->username . ':' . $this->password));
    }

    public function getDomain(string $domain): GetResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v4/domains/' . $domain);
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function listDomains(): GetResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v4/domains');
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function createDomain(CreateDomainRequest $request): PostResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains');
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function enableWhoIsPrivacy(string $domain): PostResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':enableWhoisPrivacy');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function disableWhoIsPrivacy(string $domain): PostResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':disableWhoisPrivacy');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }
}
