<?php  
namespace Drupal\message_digest_admin\Form;  
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class MessageDigestAdminHistory extends ConfigFormBase {  

    protected function getEditableConfigNames() {  
        return [  
          'message_digest_admin.adminsettings',  
        ];  
      } 
    public function getFormId() {  
        return 'tab_form';  
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('message_digest_admin.adminsettings');

    $form['welcome_message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Welcome message'),
      '#description' => $this->t('Welcome message display to users when they login'),
      '#default_value' => $config->get('welcome_message'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('message_digest_admin.adminsettings')
      ->set('welcome_message', $form_state->getValue('welcome_message'))
      ->save();
  }  

}  
