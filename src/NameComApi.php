<?php

namespace Pleets\NameCom;

use EasyHttp\GuzzleLayer\GuzzleClient;
use EasyHttp\LayerContracts\Contracts\EasyClientContract;
use EasyHttp\LayerContracts\Contracts\HttpClientRequest;
use Pleets\NameCom\Contracts\NameComResponse;
use Pleets\NameCom\Contracts\NameComResultsResponse;
use Pleets\NameCom\Domains\Requests\CheckAvailabilityRequest;
use Pleets\NameCom\Domains\Requests\CreateDomainRequest;
use Pleets\NameCom\Domains\Requests\PurchaseRequest;
use Pleets\NameCom\Domains\Requests\SearchRequest;
use Pleets\NameCom\Domains\Requests\SetContactsRequest;
use Pleets\NameCom\Domains\Requests\SetNameServersRequest;
use Pleets\NameCom\Domains\Responses\SearchResultResponse;
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

    public function getDomain(string $domain): NameComResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v4/domains/' . $domain);
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function listDomains(): NameComResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v4/domains');
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function createDomain(CreateDomainRequest $request): NameComResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains');
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function enableWhoIsPrivacy(string $domain): NameComResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':enableWhoisPrivacy');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function disableWhoIsPrivacy(string $domain): NameComResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':disableWhoisPrivacy');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function enableAutoRenewal(string $domain): NameComResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':enableAutorenew');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function disableAutoRenewal(string $domain): NameComResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':disableAutorenew');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function renewDomain(PurchaseRequest $request): NameComResponse
    {
        $this->client->prepareRequest(
            'POST',
            $this->baseUri . '/v4/domains/' . $request->getDomainName() . ':renew'
        );
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function getDomainAuthCode(string $domain): NameComResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v4/domains/' . $domain . ':getAuthCode');
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function purchasePrivacy(PurchaseRequest $request): NameComResponse
    {
        $this->client->prepareRequest(
            'POST',
            $this->baseUri . '/v4/domains/' . $request->getDomainName() . ':purchasePrivacy'
        );
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function setNameServers(SetNameServersRequest $request): NameComResponse
    {
        $this->client->prepareRequest(
            'POST',
            $this->baseUri . '/v4/domains/' . $request->getDomainName() . ':setNameservers'
        );
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function setContacts(SetContactsRequest $request): NameComResponse
    {
        $this->client->prepareRequest(
            'POST',
            $this->baseUri . '/v4/domains/' . $request->getDomainName() . ':setContacts'
        );
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function lockDomain(string $domain): NameComResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':lock');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function unlockDomain(string $domain): NameComResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':unlock');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function checkAvailability(CheckAvailabilityRequest $request): NameComResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains:checkAvailability');
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function search(SearchRequest $request): NameComResultsResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains:search');
        $this->setAuthentication()->setJson($request->toArray());

        return new SearchResultResponse($this->client->execute());
    }
}
