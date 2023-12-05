## Technologies used
[![SHOPWARE](https://img.shields.io/badge/SHOPWARE-6.5.6.1-blue.svg?style=flat-square&logo=shopware)](https://shopware.com/)
# Test Task

Test Task Plugin from MDGFK and B2BS for Sergii

## Releasing a new version
All requirements are met / Alle Anforderungen sind erfüllt


## Get started
1. Install and activate plugin
2. Add product with subscription ```bin/console test_task:add_subscription_product```
3. Rebuild admin-fe ```./bin/build-administration.sh```
4. Clean cache ```bin/console cache:clear```
5. Fix entity extension for existing products ```bin/console test_task:fix_subscription_exists_products```
