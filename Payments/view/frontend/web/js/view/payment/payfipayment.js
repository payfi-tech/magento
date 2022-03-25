define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list',
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'payfipayment',
                component: 'Payfi_Payments/js/view/payment/method-renderer/payfipayment'
            }
        );
        return Component.extend({});
    }
);
