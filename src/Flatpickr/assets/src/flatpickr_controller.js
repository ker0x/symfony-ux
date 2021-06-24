/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

import { Controller } from 'stimulus';
import flatpickr from 'flatpickr';

export default class Flatpickr extends Controller {
    static targets = [
        'input'
    ];

    static values = {
        altFormat: String,
        altInput: Boolean,
        altInputClass: String,
        allowInput: Boolean,
        allowInvalidPreload: Boolean,
        appendTo: String,
        ariaDateFormat: String,
        clickOpens: Boolean,
        conjunction: String,
        dateFormat: String,
        defaultDate: String,
        defaultHour: Number,
        defaultMinute: Number,
        disable: Array,
        disableMobile: Boolean,
        enable: Array,
        enableTime: Boolean,
        enableSeconds: Boolean,
        hourIncrement: Number,
        inline: Boolean,
        locale: String,
        maxDate: String,
        minDate: String,
        minuteIncrement: Number,
        mode: String,
        monthSelectorType: String,
        nextArrow: String,
        noCalendar: Boolean,
        position: String,
        prevArrow: String,
        shorthandCurrentMonth: Boolean,
        static: Boolean,
        showMonths: Number,
        time24hr: Boolean,
        weekNumbers: Boolean,
        wrap: Boolean
    };

    connect() {
        this.flatpickr = flatpickr(this.inputTarget, {
            ...this.defaultOptions,
            ...this.options
        });

        this._dispatchEvent('flatpickr:connect', {
            flatpickr: this.flatpickr,
            defaultOptions: this.defaultOptions,
            options: this.options
        });
    }

    disconnect() {
        this.flatpickr.destroy();
        this.flatpickr = undefined

        this._dispatchEvent('flatpickr:disconnect');
    }

    get defaultOptions() {
        let defaultOptions = {
            altFormat: this.altFormatValue,
            altInput: this.altInputValue,
            allowInput: this.allowInputValue,
            allowInvalidPreload: this.allowInvalidPreloadValue,
            ariaDateFormat: this.ariaDateFormatValue,
            clickOpens: this.clickOpensValue,
            dateFormat: this.dateFormatValue,
            disableMobile: this.disableMobileValue,
            enableTime: this.enableTimeValue,
            enableSeconds: this.enableSecondsValue,
            hourIncrement: this.hourIncrementValue,
            inline: this.inlineValue,
            minuteIncrement: this.minuteIncrementValue,
            mode: this.modeValue,
            monthSelectorType: this.monthSelectorTypeValue,
            nextArrow: this.nextArrowValue,
            noCalendar: this.noCalendarValue,
            position: this.positionValue,
            prevArrow: this.prevArrowValue,
            shorthandCurrentMonth: this.shorthandCurrentMonthValue,
            static: this.staticValue,
            showMonths: this.showMonthsValue,
            time_24hr: this.time24hrValue,
            weekNumbers: this.weekNumbersValue,
            wrap: this.wrapValue,
        };

        if (this.hasAltInputClassValue) {
            defaultOptions.altInputClass = this.altInputClassValue;
        }

        if (this.hasAppendToValue) {
            defaultOptions.appendTo = this.appendToValue;
        }

        if (this.hasDefaultDateValue) {
            defaultOptions.defaultDate = this.defaultDateValue;
        }

        if (this.hasDisableValue) {
            defaultOptions.disable = this.disableValue;
        }

        if (this.hasEnableValue) {
            defaultOptions.enable = this.enableValue;
        }

        if (this.hasLocaleValue) {
            defaultOptions.locale = this.localeValue;
        }

        if (this.hasMaxDateValue) {
            defaultOptions.maxDate = this.maxDateValue;
        }

        if (this.hasMinDateValue) {
            defaultOptions.minDate = this.minDateValue;
        }

        return defaultOptions;
    }

    get options() {
        return {};
    }

    _dispatchEvent(name, payload = null, canBubble = false, cancelable = false) {
        const userEvent = document.createEvent('CustomEvent');
        userEvent.initCustomEvent(name, canBubble, cancelable, payload);

        this.element.dispatchEvent(userEvent);
    }
}
