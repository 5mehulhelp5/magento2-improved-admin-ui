<?php

/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

declare(strict_types=1);

namespace Aimes\ImprovedAdminUi\Scope;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    public const XML_PATH_UI_SELECT_MIN_OPTIONS_AMOUNT = 'catalog/aimes_admin_ui/ui_select_min_options';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Get minimum amount of options where the 'ui-select' component should be displayed instead of 'select'
     *
     * @return int
     */
    public function getUISelectMinOptionsAmount(): int
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_UI_SELECT_MIN_OPTIONS_AMOUNT);
    }
}
