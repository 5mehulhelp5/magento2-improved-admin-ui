# Aimes_ImprovedAdminUi
!["Supported Magento Version"][magento-badge] !["Latest Release"][release-badge]

* Compatible with _Magento Open Source_ and _Adobe Commerce_ `2.4.x`

## Features
* Use the [UI-select][ui-select-docs] component to replace standard `select` and `multiselect` components
  * Provides a search field for option models that have a lot of options (E.g. CMS Blocks) 
  * Configured to perform this action only when a certain number of options are shown

## Requirements
* Magento Open Source or Adobe Commerce version `2.4.x`

## Installation
Please install this module via Composer. This module is hosted on [Packagist][packagist].

* `composer require aimes/magento2-improved-admin-ui`
* `bin/magento module:enable Aimes_ImprovedAdminUi`
* `bin/magento setup:upgrade`

## Usage
System configuration is provided to set the minimum amount of options required before the component is rendered as a ui-select. By default, this value is set to `20`.

`Stores -> Configuration -> Catalog -> Catalog -> Admin UI`

## Preview

### Product Form - Select

![image](https://github.com/user-attachments/assets/96a6070c-0267-4d9d-93ea-09912f529b2c)

### Product Form - Multiselect

![image](https://github.com/user-attachments/assets/46128ea7-e966-45bf-9948-1f61b698e41a)


## Licence
[GPLv3][gpl] © [Rob Aimes][author]

[magento-badge]:https://img.shields.io/badge/Magento%20%7C%20Adobe%20Commerce-2.4.x-orange.svg?logo=Magento&style=for-the-badge
[release-badge]:https://img.shields.io/github/v/release/robaimes/magento2-improved-admin-ui
[packagist]:https://packagist.org/packages/aimes/magento2-improved-admin-ui
[gpl]:https://www.gnu.org/licenses/gpl-3.0.en.html
[author]:https://aimes.dev/
[ui-select-docs]:https://developer.adobe.com/commerce/frontend-core/ui-components/components/secondary-ui-select/
