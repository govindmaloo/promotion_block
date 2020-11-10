/**
 * @file
 * Promotion Block js file.
 */

(function ($, window, Drupal) {
  'use strict';

  /**
   * Attaches the Popup Onload behaviour.
   */
  Drupal.behaviors.promotionBlock = {
    attach: function (context, settings) {
      if (context != document) {
        return;
      }
      // Load dailog.
      jQuery.ajax({url: "/promotion_block/load", success: function(result) {
        if (result.data) {
          var $modalDialog = $('<div />').html(result.data.html).appendTo('body');
          Drupal.dialog($modalDialog, result.data).showModal();
        }
      }});
    }
  };

})(jQuery, window, Drupal);
