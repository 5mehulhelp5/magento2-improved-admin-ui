/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */
define([
    'Magento_Ui/js/form/element/ui-select',
    'underscore',
], function (UiSelect, _) {
    'use strict';

    /**
     * A slightly modified version of the default ui-select component
     *
     * Ensures an empty string is set as the value, where necessary, so that it posts in the form data.
     *
     * The default component uses an array for storing data, which is fine. However, when a field is not required, when
     * no options are selected this does not get put in the save form's POST request data. In cases where values were
     * set and were attempted to be cleared, the absence of the data in the form would cause them to not be updated.
     *
     * This is relatively hacky by causing the value observable to swap between a string and array type.
     *
     * Saying that, we probably wouldn't need all this if there weren't numerous methods within this component that
     * arbitrarily mutate the value observable.
     */
    return UiSelect.extend({
        defaults: {
            presets: {
                single: {
                    chipsEnabled: true,
                    closeBtn: true,
                },
            },
            disableLabel: true,
            filterOptions: true,
        },

        /**
         * Toggle activity list element
         *
         * @note Modification allows for de-selecting a value if in single mode.
         * @note Ensure empty string is set as the value, where necessary, so that it posts in the form data.
         *
         * @param {Object} data - selected option data
         * @returns {Object} Chainable
         */
        toggleOptionSelected: function (data) {
            var isSelected = this.isSelected(data.value);

            if (this.lastSelectable && data.hasOwnProperty(this.separator)) {
                return this;
            }

            if (!this.multiple) {
                if (!isSelected) {
                    this.value(data.value);
                } else {
                    this.clear();
                }
                this.listVisible(false);
            } else {
                if (!isSelected) { /*eslint no-lonely-if: 0*/
                    if (this.value() === '') {
                        this.value([]);
                    }

                    this.value.push(data.value);
                } else {
                    this.value(_.without(this.value(), data.value));
                }
            }

            return this;
        },

        setCaption: function () {
            var length, caption = '';

            if (!_.isArray(this.value()) && this.value()) {
                length = 1;
            } else if (this.value()) {
                length = this.value().length;
            } else {
                this.multiple ? this.value([]) : this.clear();
                length = 0;
            }
            this.warn(caption);

            //check if option was removed
            if (this.isDisplayMissingValuePlaceholder && length && !this.getSelected().length) {
                caption = this.missingValuePlaceholder.replace('%s', this.value());
                this.placeholder(caption);
                this.warn(caption);

                return this.placeholder();
            }

            if (length > 1) {
                this.placeholder(length + ' ' + this.selectedPlaceholders.lotPlaceholders);
            } else if (length && this.getSelected().length) {
                this.placeholder(this.getSelected()[0].label);
            } else {
                this.placeholder(this.selectedPlaceholders.defaultPlaceholder);
            }

            return this.placeholder();
        },

        removeSelected: function (value, data, event) {
            event ? event.stopPropagation() : false;

            if (this.multiple) {
                this.value().length > 1 ? this.value.remove(value) : this.clear();
            } else {
                this.clear();
            }
        },

        hasData: function () {
            if (!this.value()) {
                this.clear();
            }

            return this.value() ? !!this.value().length : false;
        },

        getSelected: function () {
            if (!this.value()) {
                return [];
            }

            return this._super();
        },
    });
});
