<?php

namespace Drupal\promotion_block;

/**
 * Promotion Block Interface to provide constants.
 *
 * @package Drupal\promotion_block
 */
interface PromotionBlockInterface {

  /**
   * Cookie name.
   */
  const PROMOTION_BLOCK_COOKIE_NAME = 'promotion_block_onload_time';

  /**
   * Cookie expire default time.
   */
  const PROMOTION_BLOCK_COOKIE_LIFETIME = 86400;

}
