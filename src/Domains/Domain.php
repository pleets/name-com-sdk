<?php

namespace Pleets\NameCom\Domains;

use Pleets\NameCom\Domains\Concerns\HasDomainName;
use Pleets\NameCom\Domains\Concerns\HasNameServers;

class Domain
{
    use HasDomainName;
    use HasNameServers;

    protected ?ContactSet $contactSet = null;
    protected bool $privacyEnabled = false;
    protected bool $locked = true;
    protected bool $autoRenewed = true;

    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
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

        if ($this->nameServerCollection) {
            $data['nameservers'] = $this->nameServerCollection->toArray();
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
