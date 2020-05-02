define([
    'Magento_Ui/js/form/element/single-checkbox'
], function (Element) {
    'use strict';

    return Element.extend({
        defaults: {
            listens: {
                disabled: 'changeVisibility'
            },
            modules: {
                licensesFieldset: '${ $.licensesFieldset}'
            }
        },

        /**
         * Change visibility for samplesFieldset & linksFieldset based on current statuses of checkbox.
         */
        changeVisibility: function () {
            if (this.licensesFieldset()) {
                if (this.checked() && !this.disabled()) {
                    this.licensesFieldset().visible(true);
                } else {
                    this.licensesFieldset().visible(false);
                }
            }
        },

        /**
         * Handle checked state changes for checkbox / radio button.
         *
         * @param {Boolean} newChecked
         */
        onCheckedChanged: function (newChecked) {
            this.changeVisibility();
            this._super(newChecked);
        }
    });
});
