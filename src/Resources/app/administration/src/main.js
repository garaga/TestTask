import template from './extension/sw-product-settings-form/sw-product-settings-form.html.twig';

Shopware.Component.override('sw-product-settings-form', {
    template,
    created() {
        console.log(this.product.extensions);
        //console.log(this.product._isNew);
    },
});