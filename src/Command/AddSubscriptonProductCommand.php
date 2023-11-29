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

#[AsCommand(
    name: 'test_task:add_subscription_product',
    description: 'Add product with subscription',
)]
class AddSubscriptonProductCommand extends Command
{
    /**
     * @param EntityRepository $productRepository
     * @param EntityRepository $taxRepository
     */
    public function __construct(public EntityRepository $productRepository, public EntityRepository $taxRepository)
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
        $rand = rand(0, 10).rand(0, 100000);
        $productNumber = sprintf('TSTTSK %s', $rand);
        $this->productRepository->create([
            [
                'name' => sprintf('Example subscription product %s', $rand),
                'productNumber' => $productNumber,
                'stock' => 100,
                'taxId' => $this->getTaxId($context),
                'price' => [['currencyId' => Defaults::CURRENCY, 'gross' => 50, 'net' => 25, 'linked' => false]],
                'subscriptionExtension' => [
                    'isSubscription' => true
                ]
            ]
        ], $context);
        $output->writeln(sprintf('<bg=green;fg=white>Subscription product "%s" successfully added!</>', $productNumber));

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