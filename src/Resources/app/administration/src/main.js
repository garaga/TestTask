import template from './extension/sw-product-settings-form/sw-product-settings-form.html.twig';

Shopware.Component.override('sw-product-settings-form', {
    template,
    inject: ['repositoryFactory'],

    computed: {
        isSubscription: {
            get() {
                return this.product.extensions.subscriptionExtension?.isSubscription ?? null;
            },
            set(value) {
                if (!this.product.extensions.subscriptionExtension) {
                    this.$set(this.product.extensions, 'subscriptionExtension', this.repositoryFactory.create('test_task_subscription_extension').create());
                }
                this.$set(this.product.extensions.subscriptionExtension, 'isSubscription', value);
            },
        },
    }
});