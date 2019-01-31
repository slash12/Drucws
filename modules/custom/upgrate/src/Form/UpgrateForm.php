<?php
/**
 * @file
 * Contains \Drupal\upgrate\Form\UpgrateForm
 */

namespace Drupal\upgrate\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;

/**
 *Upgrate form 
 */

class UpgrateForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'upgrate_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['csv_upload']= [
            '#type' => 'managed_file',
            '#title' => t('Upload CSV'),
            '#required' => TRUE,
            '#upload_location' => 'public://imports/',
            '#upload_validators' => [
                'file_validate_extensions' => ['csv'],
            ]
            ];

        $form['submit']=[
            '#type' => 'submit',
            '#value' => t('Submit')
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $f_id = reset($form_state->getValue('csv_upload'));

        $file = File::load($f_id);
        
        // ksm($file);

        //File is saved
        $file->setPermanent();
        $file->save();

        //Convert CSV to array
        $data = $this->csvtoarray($file->getFileUri(), ',');

        foreach($data as $row) 
        {
            $operations[] = ['\Drupal\upgrate\addImportContent::addImportContentItem', [$row]];
        }

        // ksm($operations);

        $batch = [
            'title' => t('Importing CSV Data...'),
            'operations' => $operations,
            'init_message' => t('Import is starting.'),
            'finished' => '\Drupal\upgrate\addImportContent::addImportContentItemCallback',
        ];

        batch_set($batch);
    }

    public function csvtoarray($filename='', $delimiter)
    {
        if(!file_exists($filename) || !is_readable($filename)) 
        {
            
            return FALSE;
        }

        $header = NULL;
        $data = array();
    
        if (($handle = fopen($filename, 'r')) !== FALSE ) 
        {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
            {
                $header = $row;
            }
            else
            {
                $data[] = array_combine($header, $row);
            }
        }
            fclose($handle);
        }
    
        return $data;
    }
}