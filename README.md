# Aimes_ImprovedAdminUi
!["Supported Magento Version"][magento-badge] !["Supported Adobe Commerce Version"][commerce-badge] !["Latest Release"][release-badge]

* Compatible with _Magento Open Source_ and _Adobe Commerce_ `2.4.x`

## Features
* Use a slightly modified [UI-select][ui-select-docs] component to replace standard `select` and `multiselect` components
  * Provides a search field for option models that have a lot of options (E.g. CMS Blocks)
* Dynamically use ui-select components, replacing `select` and `multiselect` components, in the product edit form
  * Configured to perform this action only when a certain number of options are shown
* Support for the default category attribute `landing_page` on the category form
* Any custom form can be modified, see [Usage](#statically-declared-ui-components)  

## Requirements
* Magento Open Source or Adobe Commerce version `2.4.x`

## Installation
Please install this module via Composer. This module is hosted on [Packagist][packagist].

* `composer require aimes/magento2-improved-admin-ui`
* `bin/magento module:enable Aimes_ImprovedAdminUi`
* `bin/magento setup:upgrade`

## Usage

### Dynamic Replacement
System configuration is provided to set the minimum amount of options required before the component is rendered as a ui-select. By default, this value is set to `20`.

`Stores -> Configuration -> Catalog -> Catalog -> Admin UI`

### Statically Declared UI Components

Not every form has a pool of modifiers, most are statically declared. Since modifying attributes within these forms generally requires a new ui_component file, customisation to additional attributes can be done there. For example:

`view/adminhtml/category_form.xml`
```xml
<!-- some fields -->
<field name="my_custom_attribute"
       component="Aimes_ImprovedAdminUi/js/form/element/ui-select"
       formElement="select">
    <argument name="data" xsi:type="array">
        <item name="config" xsi:type="array">
            <item name="multiple" xsi:type="boolean">false</item>
        </item>
    </argument>
    <settings>
        <elementTmpl>ui/grid/filters/elements/ui-select</elementTmpl>
    </settings>
</field>
<!-- some more fields -->
```

This should be merged with any other desired/required settings. Settings can be found on the default [ui-select component documentation][ui-select-docs].

## Preview

### Product Form - Select

![image](https://github.com/user-attachments/assets/96a6070c-0267-4d9d-93ea-09912f529b2c)

### Product Form - Multiselect

![image](https://github.com/user-attachments/assets/46128ea7-e966-45bf-9948-1f61b698e41a)


## Licence
[GPLv3][gpl] © [Rob Aimes][author]

[magento-badge]:https://img.shields.io/badge/Magento-2.4.x-orange.svg?logo=Magento&style=for-the-badge
[commerce-badge]:https://img.shields.io/badge/Adobe%20Commerce-2.4.x-red.svg?logo=Adobe&style=for-the-badge
[release-badge]:https://img.shields.io/github/v/release/robaimes/magento2-improved-admin-ui?style=for-the-badge
[packagist]:https://packagist.org/packages/aimes/magento2-improved-admin-ui
[gpl]:https://www.gnu.org/licenses/gpl-3.0.en.html
[author]:https://aimes.dev/
[ui-select-docs]:https://developer.adobe.com/commerce/frontend-core/ui-components/components/secondary-ui-select/
