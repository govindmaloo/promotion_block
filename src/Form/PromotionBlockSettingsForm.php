<?php

namespace Drupal\promotion_block\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\promotion_block\PromotionBlockInterface;

/**
 * Promotion Block configuration form.
 *
 * @package Drupal\promotion_block\Form
 *
 * @ingroup promotion_block
 */
class PromotionBlockSettingsForm extends ConfigFormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'promotion_block_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['promotion_block.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('promotion_block.settings');

    $form['enable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable promotion block.'),
      '#default_value' => $config->get('enable'),
    ];

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('title'),
      '#required' => TRUE,
    ];

    $form['description'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Description'),
      '#description' => $this->t('Promo block body text.'),
      '#default_value' => $config->get('description.value'),
      '#format' => $config->get('description.format'),
      '#required' => TRUE,
    ];

    $form['cookie_expire'] = [
      '#type' => 'number',
      '#title' => $this->t('Cookie expire seconds.'),
      '#description' => $this->t('Cookie expire time in seconds.'),
      '#default_value' => $config->get('cookie_expire') ?? PromotionBlockInterface::PROMOTION_BLOCK_COOKIE_LIFETIME,
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('promotion_block.settings')
      ->set('title', $values['title'])
      ->set('description.value', $values['description']['value'])
      ->set('description.format', $values['description']['format'])
      ->set('enable', $values['enable'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}
