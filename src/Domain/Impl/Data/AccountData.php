<?php

namespace Llvdl\Domain\Impl\Data;

trait AccountData
{
    public function getId() : string
    {
        return $this->{self::ATTR_ID};
    }

    public function setId(?string $id) : void
    {
        $this->{self::ATTR_ID} = $id;
    }

    public function getName() : string
    {
        return $this->{self::ATTR_NAME};
    }

    public function setName(string $name)
    {
        $this->{self::ATTR_NAME} = $name;
    }

    public function getEmail() : string
    {
        return $this->{self::ATTR_EMAIL};
    }

    public function setEmail(string $email)
    {
        $this->{self::ATTR_EMAIL} = $email;
    }

    public function setActive(bool $active)
    {
        $this->{self::ATTR_ACTIVE} = $active;
    }

    public function isActive() : bool
    {
        return $this->{self::ATTR_ACTIVE};
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->{self::ATTR_CREATED_AT};
    }
}
