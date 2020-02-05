function umd_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state, $form_id = NULL) {
 
  $form['environment'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Environment'),
    '#default_value' => theme_get_setting('environment'),
    '#description'   => t("Enter the environment"),
  );

  $form['environment_banner'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Environment Banner Text'),
    '#default_value' => theme_get_setting('environment_banner'),
    '#description'   => t("Enter the environment banner"),
  );
}