<?php

namespace Pleets\NameCom\Domains;

class Domain
{
    protected string $domainName;
    protected array $nameservers = [];
    protected ?ContactSet $contactSet = null;
    protected bool $privacyEnabled = false;
    protected bool $locked = true;
    protected bool $autoRenewed = true;

    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function setDomainName(string $domainName): self
    {
        $this->domainName = $domainName;

        return $this;
    }

    public function getNameservers(): array
    {
        return $this->nameservers;
    }

    public function setNameservers(array $nameservers): self
    {
        $this->nameservers = $nameservers;

        return $this;
    }

    public function getContactSet(): ?ContactSet
    {
        return $this->contactSet;
    }

    public function setContactSet(?ContactSet $contactSet): self
    {
        $this->contactSet = $contactSet;

        return $this;
    }

    public function isPrivacyEnabled(): bool
    {
        return $this->privacyEnabled;
    }

    public function setPrivacyEnabled(bool $privacyEnabled): self
    {
        $this->privacyEnabled = $privacyEnabled;

        return $this;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function isAutoRenewed(): bool
    {
        return $this->autoRenewed;
    }

    public function setAutoRenewed(bool $autoRenewed): self
    {
        $this->autoRenewed = $autoRenewed;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'domainName' => $this->domainName
        ];

        if ($this->nameservers) {
            $data['nameservers'] = $this->nameservers;
        }

        if ($this->contactSet) {
            $data['contacts'] = $this->contactSet->toArray();
        }

        $data['privacyEnabled'] = $this->privacyEnabled;
        $data['locked'] = $this->locked;
        $data['autorenewEnabled'] = $this->autoRenewed;

        return $data;
    }
}
