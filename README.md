<p align="center"><img src="https://blog.pleets.org/img/articles/name-com-logo.png" height="50"></p>

<p align="center">
<a href="https://travis-ci.com/pleets/name-com-sdk"><img src="https://travis-ci.com/pleets/name-com-sdk.svg?branch=main" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/pleets/name-com-sdk"><img src="https://img.shields.io/scrutinizer/g/pleets/name-com-sdk.svg" alt="Code Quality"></a>
<a href="https://scrutinizer-ci.com/g/pleets/name-com-sdk/?branch=main"><img src="https://scrutinizer-ci.com/g/pleets/name-com-sdk/badges/coverage.png?b=main" alt="Code Coverage"></a>
</p>

# Name.com SDK

This is an SDK for [Name.com REST API](https://www.name.com/api-docs/).
The following APIs are currently supported :rocket:.

- [v4](https://www.name.com/api-docs/)

<a href="https://sonarcloud.io/dashboard?id=pleets_name-com-sdk"><img src="https://sonarcloud.io/api/project_badges/measure?project=pleets_name-com-sdk&metric=security_rating" alt="Bugs"></a>
<a href="https://sonarcloud.io/dashboard?id=pleets_name-com-sdk"><img src="https://sonarcloud.io/api/project_badges/measure?project=pleets_name-com-sdk&metric=bugs" alt="Bugs"></a>
<a href="https://sonarcloud.io/dashboard?id=pleets_name-com-sdk"><img src="https://sonarcloud.io/api/project_badges/measure?project=pleets_name-com-sdk&metric=code_smells" alt="Bugs"></a>

# Installation

Use following command to install this library:

```bash
composer require pleets/name-com-api
```

# Usage

Go to [Name.com site](https://www.name.com/account/login.php) and get a username and token in
[API Settings](https://www.name.com/account/settings/api). Use this credentials to authenticate against Name.com as follows:

```php
use Pleets\NameCom\NameComApi;

$service = new NameComApi('https://api.name.com');
$service->setCredentials('user-prod', 'fb229991b131304b390f1a633148a3832044d2b4');
```

For instance, if you want to get all details about a specific domain you can use the `getDomain` method.

```php
$response = $service->getDomain('example.com');
```

All responses have a method to know if the request was successful.

```php
if ($response->isSuccessful()) {
    // all it's ok
}
```

No matter the success of the response, you can always check the JSON response with `toArray()`.

```php
$response->toArray();
```

As well, you can access to the returned HTTP status code as follows:

```php
$response->getResponse()->getStatusCode();
```

See all available methods for this API in the [Wiki](https://github.com/pleets/name-com-sdk/wiki/0.-Getting-Started).