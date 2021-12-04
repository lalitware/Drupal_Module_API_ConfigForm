<?php

namespace Drupal\node_json_data\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class ModuleConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'node_json_data.admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'node_json_data.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('node_json_data.settings');
    $form['api'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the API'),
      '#default_value' => $config->get('node_json_data.api'),
    ];
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    // To throw an error if the api is more than 16 characters.
    if (strlen($form_state->getValue('api')) > 16) {
      $form_state->setErrorByName('api', $this->t('API Key will be a maximum 16 digit text value.'));
    }
    parent::validateForm($form, $form_state);

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  
      $this->config('node_json_data.settings')
        ->set('node_json_data.api', $form_state->getValue('api'))
        ->save();
      parent::submitForm($form, $form_state);
  
  }
}
