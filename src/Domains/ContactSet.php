<?php

namespace Pleets\NameCom\Domains;

class ContactSet
{
    /**
     * @var Contact[]
     */
    protected array $contacts = [];

    public function setContact(Contact $contact, string $type): void
    {
        $this->contacts[$type] = $contact;
    }

    public function toArray(): array
    {
        $data = [];

        foreach ($this->contacts as $key => $contact) {
            $data[$key] = $contact->toArray();
        }

        return $data;
    }
}
