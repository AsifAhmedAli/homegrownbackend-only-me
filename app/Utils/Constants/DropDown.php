<?php


  namespace App\Utils\Constants;


class DropDown
{
  const FIXED_PRODUCT = 'fixed_product';
  const PERCENT_PRODUCT = 'percent_product';
  const FIXED_CATEGORY = 'fixed_category';
  const PERCENT_CATEGORY = 'percent_category';
  const FIXED_SITE_WIDE = 'fixed_site_wide';
  const PERCENT_SITE_WIDE = 'percent_site_wide';
  const PERCENT_KIT = 'percent_kit';
  const FIXED_KIT = 'fixed_kit';

  const COUPON_TYPES = [
    self::FIXED_PRODUCT => 'Fixed Product',
    self::PERCENT_PRODUCT => 'Percent Product',
    self::FIXED_CATEGORY => 'Fixed Category',
    self::PERCENT_CATEGORY => 'Percent Category',
    self::FIXED_SITE_WIDE => 'Fixed Site Wide',
    self::PERCENT_SITE_WIDE => 'Percent Site Wide',
    self::PERCENT_KIT => 'Percent Kit',
    self::FIXED_KIT => 'Fixed Kit',
  ];
}
