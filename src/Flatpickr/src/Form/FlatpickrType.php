<?php

declare(strict_types=1);

namespace Symfony\UX\Flatpickr\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Romain Monteil <monteil.romain@gmail.com>
 *
 * @final
 * @experimental
 */
class FlatpickrType extends AbstractType
{
    public const NAME = 'flatpickr';

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);

        $controllerName = $options['controller_name'];

        $view->vars['attr']["data-{$controllerName}-target"] = 'input';

        // stimulus controller name and values
        $view->vars['controller_name'] = $controllerName;
        $view->vars['controller_values']['alt-format'] = $options['alt_format'];
        $view->vars['controller_values']['alt-input'] = $options['alt_input'];
        $view->vars['controller_values']['allow-input'] = $options['allow_input'];
        $view->vars['controller_values']['allow-invalid_preload'] = $options['allow_invalid_preload'];
        $view->vars['controller_values']['aria-date-format'] = $options['aria_date_format'];
        $view->vars['controller_values']['click-opens'] = $options['click_opens'];
        $view->vars['controller_values']['date-format'] = $options['input_format'];
        $view->vars['controller_values']['disable-mobile'] = $options['disable_mobile'];
        $view->vars['controller_values']['enable-time'] = $options['enable_time'];
        $view->vars['controller_values']['enable-seconds'] = $options['with_seconds'];
        $view->vars['controller_values']['hour-increment'] = $options['hour_increment'];
        $view->vars['controller_values']['inline'] = $options['inline'];
        $view->vars['controller_values']['minute-increment'] = $options['minute_increment'];
        $view->vars['controller_values']['mode'] = $options['mode'];
        $view->vars['controller_values']['month-selector-type'] = $options['month_selector_type'];
        $view->vars['controller_values']['next-arrow'] = $options['next_arrow'];
        $view->vars['controller_values']['no-calendar'] = $options['no_calendar'];
        $view->vars['controller_values']['position'] = $options['vertical_position'];
        $view->vars['controller_values']['prev-arrow'] = $options['prev_arrow'];
        $view->vars['controller_values']['shorthand-current-month'] = $options['shorthand_current_month'];
        $view->vars['controller_values']['static'] = $options['static'];
        $view->vars['controller_values']['show-months'] = $options['show_months'];
        $view->vars['controller_values']['time-24hr'] = $options['time_24hr'];
        $view->vars['controller_values']['week-numbers'] = $options['week_numbers'];
        $view->vars['controller_values']['wrap'] = $options['wrap'];

        if (null !== $altInputClass = $options['alt_input_class']) {
            $view->vars['controller_values']['alt-input-class'] = $altInputClass;
        }

        if (null !== $appendTo = $options['append_to']) {
            $view->vars['controller_values']['append-to'] = $appendTo;
        }

        if (null !== $conjunction = $options['conjunction']) {
            $view->vars['controller_values']['conjunction'] = $conjunction;
        }

        if ([] !== $disabledDates = $options['disabled_dates']) {
            $view->vars['controller_values']['disable'] = $disabledDates;
        }

        if ([] !== $enabledDates = $options['enabled_dates']) {
            $view->vars['controller_values']['enable'] = $enabledDates;
        }

        if (null !== $horizontalPosition = $options['horizontal_position']) {
            $view->vars['controller_values']['position'] = sprintf('%s %s', $view->vars['controller_values']['position'], $horizontalPosition);
        }

        if (null !== $locale = $options['locale']) {
            $view->vars['controller_values']['locale'] = $locale;
        }

        if (null !== $minDate = $options['min_date']) {
            $view->vars['controller_values']['min-date'] = $minDate;
        }

        if (null !== $maxDate = $options['max_date']) {
            $view->vars['controller_values']['max-date'] = $maxDate;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined([
            'alt_format',
            'alt_input',
            'alt_input_class',
            'allow_input',
            'allow_invalid_preload',
            'append_to',
            'aria_date_format',
            'click_opens',
            'conjunction',
            'controller_name',
            'disabled_dates',
            'disable_mobile',
            'enabled_dates',
            'enable_time',
            'horizontal_position',
            'hour_increment',
            'inline',
            'locale',
            'max_date',
            'min_date',
            'minute_increment',
            'mode',
            'month_selector_type',
            'next_arrow',
            'no_calendar',
            'prev_arrow',
            'shorthand_current_month',
            'static',
            'show_months',
            'time_24hr',
            'vertical_position',
            'week_numbers',
            'wrap',
        ]);

        $resolver->setAllowedTypes('alt_format', ['string']);
        $resolver->setAllowedTypes('alt_input', ['bool']);
        $resolver->setAllowedTypes('alt_input_class', ['null', 'string']);
        $resolver->setAllowedTypes('allow_input', ['bool']);
        $resolver->setAllowedTypes('allow_invalid_preload', ['bool']);
        $resolver->setAllowedTypes('append_to', ['null', 'string']);
        $resolver->setAllowedTypes('aria_date_format', ['string']);
        $resolver->setAllowedTypes('click_opens', ['bool']);
        $resolver->setAllowedTypes('conjunction', ['null', 'string']);
        $resolver->setAllowedTypes('controller_name', ['string']);
        $resolver->setAllowedTypes('disabled_dates', ['null', 'array']);
        $resolver->setAllowedTypes('disable_mobile', ['bool']);
        $resolver->setAllowedTypes('enabled_dates', ['null', 'array']);
        $resolver->setAllowedTypes('enable_time', ['bool']);
        $resolver->setAllowedTypes('horizontal_position', ['null', 'string']);
        $resolver->setAllowedTypes('hour_increment', ['int']);
        $resolver->setAllowedTypes('inline', ['bool']);
        $resolver->setAllowedTypes('locale', ['null', 'string']);
        $resolver->setAllowedTypes('max_date', ['null', 'string', 'object']);
        $resolver->setAllowedTypes('min_date', ['null', 'string', 'object']);
        $resolver->setAllowedTypes('minute_increment', ['int']);
        $resolver->setAllowedTypes('mode', ['string']);
        $resolver->setAllowedTypes('month_selector_type', ['string']);
        $resolver->setAllowedTypes('next_arrow', ['string']);
        $resolver->setAllowedTypes('no_calendar', ['bool']);
        $resolver->setAllowedTypes('prev_arrow', ['string']);
        $resolver->setAllowedTypes('shorthand_current_month', ['bool']);
        $resolver->setAllowedTypes('static', ['bool']);
        $resolver->setAllowedTypes('show_months', ['int']);
        $resolver->setAllowedTypes('time_24hr', ['bool']);
        $resolver->setAllowedTypes('vertical_position', ['string']);
        $resolver->setAllowedTypes('week_numbers', ['bool']);
        $resolver->setAllowedTypes('wrap', ['bool']);

        $resolver->setAllowedValues('mode', [
            'single',
            'multiple',
            'range',
        ]);

        $resolver->setAllowedValues('month_selector_type', [
            'dropdown',
            'static',
        ]);

        $resolver->setAllowedValues('horizontal_position', [
            null,
            'center',
            'left',
            'right',
        ]);

        $resolver->setAllowedValues('vertical_position', [
            'auto',
            'above',
            'below',
        ]);

        $resolver->setDefaults([
            'alt_format' => 'F j, Y',
            'alt_input' => false,
            'alt_input_class' => null,
            'allow_input' => false,
            'allow_invalid_preload' => false,
            'append_to' => null,
            'aria_date_format' => 'F j, Y',
            'click_opens' => true,
            'conjunction' => null,
            'controller_name' => self::NAME,
            'disabled_dates' => [],
            'disable_mobile' => false,
            'enabled_dates' => [],
            'enable_time' => false,
            'horizontal_position' => null,
            'hour_increment' => 1,
            'html5' => false,
            'inline' => false,
            'locale' => null,
            'max_date' => null,
            'min_date' => null,
            'minute_increment' => 5,
            'mode' => 'single',
            'month_selector_type' => 'dropdown',
            'next_arrow' => '>',
            'no_calendar' => false,
            'position_element' => null,
            'prev_arrow' => '<',
            'shorthand_current_month' => false,
            'static' => false,
            'show_months' => 1,
            'time_24hr' => false,
            'vertical_position' => 'auto',
            'week_numbers' => false,
            'widget' => 'single_text',
            'wrap' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return self::NAME;
    }

    public function getParent(): string
    {
        return DateTimeType::class;
    }
}
