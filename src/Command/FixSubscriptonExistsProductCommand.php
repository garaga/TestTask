<?php declare(strict_types=1);

namespace TestTask\Command;

use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TestTask\Extension\Content\Product\SubscriptionExtensionEntity;

#[AsCommand(
    name: 'test_task:fix_subscription_exists_products',
    description: 'Set subscription "false" for exists products',
)]
class FixSubscriptonExistsProductCommand extends Command
{
    /**
     * @param EntityRepository $productRepository
     */
    public function __construct(public EntityRepository $productRepository)
    {
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $context = Context::createDefaultContext();
        $productIds = $this->productRepository->searchIds(new Criteria(), $context)->getIds();

        foreach ($productIds as $productId) {
            $product = $this->productRepository->search(new Criteria([$productId]), $context)->first();
            /** @var SubscriptionExtensionEntity $extension */
            $extension = $product->getExtension('subscriptionExtension');

            if ($extension) {
                continue;
            }

            $this->productRepository->update([
                [
                    'id' => $productId,
                    'subscriptionExtension' => [
                        'isSubscription' => false
                    ]
                ]
            ], $context);
        }
        $output->writeln('<bg=green;fg=white>Products successfully patched!</>');

        return 0;
    }

    /**
     * @param Context $context
     * @return string
     */
    private function getTaxId(Context $context): string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('taxRate', 19.00));

        return $this->taxRepository->searchIds($criteria, $context)->firstId();
    }
}