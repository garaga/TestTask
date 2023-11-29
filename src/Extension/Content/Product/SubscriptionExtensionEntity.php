<?php declare(strict_types=1);

namespace TestTask\Extension\Content\Product;


use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class SubscriptionExtensionEntity extends Entity
{
    use EntityIdTrait;

    protected bool $isSubscription = false;

    public function isSubscription(): bool
    {
        return $this->isSubscription;
    }

    public function setIsSubscription(bool $isSubscription): void
    {
        $this->isSubscription = $isSubscription;
    }
}