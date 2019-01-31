<?php  
/**  
 * @file  
 * Contains Drupal\hello_world\Form\MessagesForm.  
 */  
namespace Drupal\hello_world\Form;  
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class MessagesForm extends ConfigFormBase 
{  
    /**  
   * {@inheritdoc}  
   */  
    protected function getEditableConfigNames()
    {  
        return [  
        'hello_world.adminsettings',  
        ];  
    }  

    /**  
     * {@inheritdoc}  
     */  
    public function getFormId() 
    {  
        return 'hello_world_form';  
    }  

    /**  
     * {@inheritdoc}  
     */  
    public function buildForm(array $form, FormStateInterface $form_state) 
    {  
        $config = $this->config('hello_world.adminsettings');  

        $form['hello_world_message'] = [  
        '#type' => 'textarea',  
        '#title' => $this->t('Welcome message'),  
        '#description' => $this->t('Welcome message display to users when they login'),  
        '#default_value' => $config->get('hello_world_message'),  
        ];  

        return parent::buildForm($form, $form_state);  
    } 

    /**  
     * {@inheritdoc}  
     */  
    public function submitForm(array &$form, FormStateInterface $form_state) 
    {  
        parent::submitForm($form, $form_state);  

        $this->config('hello_world.adminsettings')  
        ->set('hello_world_message', $form_state->getValue('hello_world_message'))  
        ->save();  
    }
} 