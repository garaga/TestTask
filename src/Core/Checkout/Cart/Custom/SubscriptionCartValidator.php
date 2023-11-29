<?php declare(strict_types=1);

namespace TestTask\Core\Checkout\Cart\Custom;

use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\CartValidatorInterface;
use Shopware\Core\Checkout\Cart\Error\ErrorCollection;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use TestTask\Core\Checkout\Cart\Custom\Error\SubscriptionCartBlockedError;
use TestTask\Extension\Content\Product\SubscriptionExtensionEntity;

class SubscriptionCartValidator implements CartValidatorInterface
{
    /**
     * @param EntityRepository $productRepository
     */
    public function __construct(
        public EntityRepository $productRepository
    )
    {}


    /**
     * @param Cart $cart
     * @param ErrorCollection $errors
     * @param SalesChannelContext $context
     * @return void
     */
    public function validate(Cart $cart, ErrorCollection $errors, SalesChannelContext $context): void
    {
        if (count($cart->getLineItems()->getFlat()) == 1) {
            return;
        }

        $subscriptionState = false;
        $lineItems = $cart->getLineItems()->getFlat();
        foreach ($lineItems as $key => $lineItem) {
            $productNumber = $lineItem->getPayloadValue('productNumber');

            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('productNumber', $productNumber));

            /** @var ProductEntity $product */
            $product = $this->productRepository->search($criteria, $context->getContext())->first();

            if (!$product) {
                continue;
            }

            /** @var SubscriptionExtensionEntity $extension */
            $extension = $product->getExtension('subscriptionExtension');

            if (!$extension) {
                continue;
            }

            if ($key === array_key_first($lineItems)) {
                $subscriptionState = $extension->isSubscription();
            }

            if ($extension->isSubscription() !== $subscriptionState) {
                $errors->add(new SubscriptionCartBlockedError($lineItem->getId()));
            }
        }
    }
}