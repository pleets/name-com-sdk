<?php

namespace Pleets\NameCom\Domains;

class Contact
{
    protected ?string $firstName = null;
    protected ?string $lastName = null;
    protected ?string $companyName = null;
    protected ?string $address1 = null;
    protected ?string $address2 = null;
    protected ?string $city = null;
    protected ?string $state = null;
    protected ?string $postalCode = null;
    protected ?string $country = null;
    protected ?string $phone = null;
    protected ?string $fax = null;
    protected ?string $email = null;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1): self
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->firstName) {
            $data['firstName'] = $this->firstName;
        }

        if ($this->lastName) {
            $data['lastName'] = $this->lastName;
        }

        if ($this->companyName) {
            $data['companyName'] = $this->companyName;
        }

        if ($this->address1) {
            $data['address1'] = $this->address1;
        }

        if ($this->address2) {
            $data['address2'] = $this->address2;
        }

        if ($this->city) {
            $data['city'] = $this->city;
        }

        if ($this->state) {
            $data['state'] = $this->state;
        }

        if ($this->postalCode) {
            $data['zip'] = $this->postalCode;
        }

        if ($this->country) {
            $data['country'] = $this->country;
        }

        if ($this->phone) {
            $data['phone'] = $this->phone;
        }

        if ($this->fax) {
            $data['fax'] = $this->fax;
        }

        if ($this->email) {
            $data['email'] = $this->email;
        }

        return $data;
    }
}
