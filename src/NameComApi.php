<?php

namespace Pleets\NameCom;

use EasyHttp\GuzzleLayer\GuzzleClient;
use EasyHttp\LayerContracts\Contracts\EasyClientContract;
use EasyHttp\LayerContracts\Contracts\HttpClientRequest;
use Pleets\NameCom\Domains\Requests\CheckAvailabilityRequest;
use Pleets\NameCom\Domains\Requests\CreateDomainRequest;
use Pleets\NameCom\Domains\Requests\PurchaseRequest;
use Pleets\NameCom\Domains\Requests\SearchRequest;
use Pleets\NameCom\Domains\Requests\SetContactsRequest;
use Pleets\NameCom\Domains\Requests\SetNameServersRequest;
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

    public function enableAutoRenewal(string $domain): PostResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':enableAutorenew');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function disableAutoRenewal(string $domain): PostResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':disableAutorenew');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function renewDomain(PurchaseRequest $request): PostResponse
    {
        $this->client->prepareRequest(
            'POST',
            $this->baseUri . '/v4/domains/' . $request->getDomainName() . ':renew'
        );
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function getPricingForDomain(string $domain, ?int $years = null): GetResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v4/domains/' . $domain . ':getPricing');
        $this->setAuthentication();

        if ($years) {
            $this->client->getRequest()->setQuery(['years' => $years]);
        }

        $this->client->getRequest()->setQuery(['years' => $years]);

        return new GetResponse($this->client->execute());
    }

    public function getDomainAuthCode(string $domain): GetResponse
    {
        $this->client->prepareRequest('GET', $this->baseUri . '/v4/domains/' . $domain . ':getAuthCode');
        $this->setAuthentication();

        return new GetResponse($this->client->execute());
    }

    public function purchasePrivacy(PurchaseRequest $request): PostResponse
    {
        $this->client->prepareRequest(
            'POST',
            $this->baseUri . '/v4/domains/' . $request->getDomainName() . ':purchasePrivacy'
        );
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function setNameServers(SetNameServersRequest $request): PostResponse
    {
        $this->client->prepareRequest(
            'POST',
            $this->baseUri . '/v4/domains/' . $request->getDomainName() . ':setNameservers'
        );
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function setContacts(SetContactsRequest $request): PostResponse
    {
        $this->client->prepareRequest(
            'POST',
            $this->baseUri . '/v4/domains/' . $request->getDomainName() . ':setContacts'
        );
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function lockDomain(string $domain): PostResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':lock');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function unlockDomain(string $domain): PostResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains/' . $domain . ':unlock');
        $this->setAuthentication();

        return new PostResponse($this->client->execute());
    }

    public function checkAvailability(CheckAvailabilityRequest $request): PostResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains:checkAvailability');
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }

    public function search(SearchRequest $request): PostResponse
    {
        $this->client->prepareRequest('POST', $this->baseUri . '/v4/domains:search');
        $this->setAuthentication()->setJson($request->toArray());

        return new PostResponse($this->client->execute());
    }
}
