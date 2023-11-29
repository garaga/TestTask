<?php declare(strict_types=1);

namespace TestTask\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1701168750SubscriptionProductExtension extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1701168750;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `test_task_subscription_extension` (
    `id` BINARY(16) NOT NULL,
    `product_id` BINARY(16) NOT NULL,
    `is_subscription` INT(2) NULL,
    `created_at` datetime null,
    `updated_at` datetime null,
    PRIMARY KEY (`id`),
    KEY `fk.test_task_subscription_extension.product_id` (`product_id`),
    CONSTRAINT `fk.test_task_subscription_extension.product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;
        $connection->executeStatement($sql);
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}