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


## Known bugs
- On the new product creation page, the "Labeling" section and the "Is Subscription" checkbox disappear. The console displays an error: ```An error was captured in current module: TypeError: Cannot read properties of undefined (reading 'isSubscription')``` The problem lies in the frontend and vuejs, which I can't solve yet. After creating the product, you need to re-run the command ```bin/console test_task:fix_subscription_exists_products```, and then the fields will appear

