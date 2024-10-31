<?php

/**
 * Copyright © Rob Aimes - https://aimes.dev/
 * https://github.com/robaimes
 */

namespace Aimes\ImprovedAdminUi\Ui\DataProvider\Product\Form\Modifier;

use Aimes\ImprovedAdminUi\Scope\Config;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Ui\Component\Form\Element\MultiSelect;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class SelectToUiSelect implements ModifierInterface
{
    /** @var array */
    private array $multiSelectAttributes = [];

    /**
     * @param ArrayManager $arrayManager
     * @param LocatorInterface $locator
     * @param Config $uiConfig
     */
    public function __construct(
        private readonly ArrayManager $arrayManager,
        private readonly LocatorInterface $locator,
        private readonly Config $uiConfig
    ) {
    }

    /**
     * Setup UI Select component for easier filtering of options
     *
     * @param array $meta
     *
     * @return array
     * @see https://developer.adobe.com/commerce/frontend-core/ui-components/components/secondary-ui-select/
     */
    public function modifyMeta(array $meta): array
    {
        $componentConfigPaths = $this->arrayManager->findPaths(
            'config',
            $meta,
        );

        foreach ($componentConfigPaths as $componentConfigPath) {
            $attributeCode = null;
            $componentConfig = $this->arrayManager->get($componentConfigPath, $meta);

            if (!$componentConfig || !$this->shouldProcessComponent($componentConfig, $componentConfigPath)) {
                continue;
            }

            $isMultiple = $componentConfig['formElement'] === MultiSelect::NAME;

            if ($isMultiple) {
                $attributeCode = $this->recordMultiSelectAttribute($componentConfigPath);
            }

            $meta = $this->arrayManager->merge(
                $componentConfigPath,
                $meta,
                $this->getUiSelectConfig($isMultiple, $attributeCode)
            );
        }

        return $meta;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data): array
    {
        $productId = $this->locator->getProduct()->getId();

        if (!$productId) {
            return $data;
        }

        foreach ($this->multiSelectAttributes as $multiSelectAttribute) {
            if (!isset($data[$productId]['product'][$multiSelectAttribute])) {
                continue;
            }

            $initialValue = $data[$productId]['product'][$multiSelectAttribute];
            $data[$productId]['product'][$multiSelectAttribute] = explode(',', $initialValue);
        }

        return $data;
    }

    /**
     * @param array $componentConfig
     * @return bool
     */
    private function shouldProcessComponent(array $componentConfig): bool {
        $formElement = $componentConfig['formElement'] ?? null;

        if ($formElement !== Select::NAME && $formElement !== MultiSelect::NAME) {
            return false;
        }

        if (isset($componentConfig['component'])) {
            return false;
        }

        if (count($componentConfig['options'] ?? []) < $this->uiConfig->getUISelectMinOptionsAmount()) {
            return false;
        }

        return true;
    }

    /**
     * @return array[]
     */
    private function getUiSelectConfig(
        bool $isMultiple,
        ?string $attributeCode = null
    ): array {
        $uiSelectComponent = [
            'component' => 'Aimes_ImprovedAdminUi/js/form/element/ui-select',
            'componentType' => Field::NAME,
            'dataType' => 'text',
            'filterOptions' => true,
            'filterPlaceholder' => __('Search...'),
            'missingValuePlaceholder' => __('Selected value/identifier "%s" doesn\'t exist'),
            'multiple' => $isMultiple,
            'disableLabel' => true,
            'levelsVisibility' => '1',
            'elementTmpl' => 'ui/grid/filters/elements/ui-select',
        ];

        if ($attributeCode) {
            $uiSelectComponent['dataScope'] = $attributeCode;
        }

        return $uiSelectComponent;
    }

    /**
     * @param string $componentConfigPath
     * @return string
     */
    private function recordMultiSelectAttribute(string $componentConfigPath): string
    {
        $componentPath = $this->arrayManager->slicePath($componentConfigPath, 0, -3);
        $finalDelimiterPosition = strrpos($componentPath, '/');
        $attributeCode = substr($componentPath, $finalDelimiterPosition + 1);

        $this->multiSelectAttributes[] = $attributeCode;

        return $attributeCode;
    }
}
