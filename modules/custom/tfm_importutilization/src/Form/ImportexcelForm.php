<?php
  namespace Drupal\tfm_importutilization\Form;
  use Drupal\Core\Form\FormBase;
  use Drupal\Core\Form\FormStateInterface;
  use Drupal\Core\Url;
  use Drupal\Core\Database\Database;
  use Drupal\file\Entity\File;
  use Drupal\Core\Entity\EntityTypeManagerInterface ;
  use Drupal\Core\Queue\QueueFactory;
  use Drupal\Core\Queue\QueueInterface;
 
/* use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\IOFactory;
  use PhpOffice\PhpSpreadsheet\Style\Fill;
  use PhpOffice\PhpSpreadsheet\Cell\DataType;
  use PhpOffice\PhpSpreadsheet\Style\Alignment;
  use PhpOffice\PhpSpreadsheet\Style\Border;*/
  
class ImportexcelForm extends FormBase{
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tfm_importutilization_import';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = array(
      '#attributes' => array('enctype' => 'multipart/form-data'),
    );
    
    //$form['file_upload_details'] = array(
      //'#markup' => t('<b>The File</b>'),
   // );
  
    $validators = array(
      'file_validate_extensions' => array(     
        //'xlsx',
        'csv',
      ),
    );
    
    $form['utilization_csv_file'] = array(
      '#type' => 'managed_file',
      '#name' => 'utilization_csv_file',
      '#title' => t('Choose the file'),
      '#required' => true,
      '#size' => 20,
      '#description' => t('Please upload the Utilization report.'),
      '#upload_validators' => $validators,
    // '#upload_location' => '/tfm_importutilization/uploads',
    );
    
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );
 
    return $form;
 
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {    
    if ($form_state->getValue('utilization_csv_file') == NULL) {
      $form_state->setErrorByName('utilization_csv_file', $this->t('upload proper File'));
    }
  }
    
    
     /**
     * {@inheritdoc}
     */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    /* 
    $file = \Drupal::entityTypeManager()->getStorage('file')->load($form_state->getValue('utilization_csv_file')[0]);    
    $full_path = $file->get('uri')->value;
    //echo $full_path; exit; return;
    $file_name = basename($full_path);
    $inputFileName = \Drupal::service('file_system')->realpath('/Demo_modules/sites/default/files/'.$file_name);

    $spreadsheet = IOFactory::load($inputFileName);

    $sheetData = $spreadsheet->getActiveSheet();

    $rows = array();
    foreach ($sheetData->getRowIterator() as $row) {
      //echo "<pre>";print_r($row);exit;
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(FALSE); 
      $cells = [];
      foreach ($cellIterator as $cell) {
      $cells[] = $cell->getValue();
      }
      $rows[] = $cells;
    }
    foreach($rows as $row){
    $values = \Drupal::entityQuery('node')->condition('title', $row[0])->execute();
    $node_not_exists = empty($values);
    if($node_not_exists){
      //if node does not exist create new node
      $node = \Drupal::entityTypeManager()->getStorage('node')->create([
        'type'       => 'news', //===here news is the content type mechine name
        'title'      => $row[0],
        'body'       => 'body content updated'
      ]);
      $node->save();
    }else{
      //if node exist update the node
      $nid = reset($values);
      
      $node = \Drupal\node\Entity\Node::load($nid);
      $node->setTitle($row[0]);
      $node->set("body", $row[1]);
      //$node->set("field_name", 'New value');
      $node->save();
    }
    }

    \Drupal::messenger()->addMessage('imported successfully');
    */
  	// Get queue.     
 // $queue_id = 'utilization_csv_filebulk_opearation_queue';
 /// $queue = \Drupal::queue($queue_id); 
  
  /** @var QueueFactory $queue_factory */
  //$queue_factory = \Drupal::service('queue');
  /** @var QueueInterface $queue */
  //$queue = $queue_factory->get('utilization_csv_filebulk_opearation_queue');
    
	if ( $form_state->getValue('utilization_csv_file') ) {
    
    $load_file = \Drupal::entityTypeManager()->getStorage('file')->load($form_state->getValue('utilization_csv_file')[0]); 
    $full_path = $load_file->get('uri')->value;
    
		if ( $handle = fopen($full_path, 'r') ) {
			
			$header = null;
      
			$header_lables = [ 'Global Employee Id', 'Emp Id', 'Emp Name', 'Emp Username', 'Email ID', 'Grade', 'Final Grade', 'Location' , 'Sub Location', 'Fresher', 'Hire Date', 'LWD', 'Domain', 'Service Line', 'Primary Skill', 'Secondary Skill', 'Supervisor Name', 'PID', 'Project Name', 'Project Manager', 'Account', 'Allocation Start Date', 'Allocation End Date', 'Resource Current Status', 'HC', 'Delivery BU', 'Delivery Region', 'Sector/Country', 'Age', 'Age Bucket', 'OU Code', 'Employee Type', 'Captives/P&C', 'Project Type', 'Resource Type', 'Training Days (Cal Days)', 'Shadow Day (Cal Days)', 'Billing Days (Cal Days)', 
      //'Account', 
      'Availability', 'Non-Deployable', 'Proposed SO Numbers', 'Proposed accounts', 'Proposed Dates', 'Last CV Updated', 'SEZ/Non-SEZ', 'Generic Skill', 'iCX', 'Supply Type' ];
			
  $batch = array(
      'title' => t('Importutilization'),
      'operations' => [],
      'init_message'     => t('Importing'),
      'progress_message' => t('Processed @current out of @total.'),
      'error_message'    => t('An error occurred during processing'),
      'finished' => '\Drupal\tfm_importutilization\Controller\DefaultController::importutilizationFinishedCallback',
    );
 
 $processed_rec =0;
 
			// Using fgetcsv convert a CSV file into an associative array. 
			while (($line = fgetcsv($handle)) !== false) {			
				// Extract header
				if ($header === null){
          $header = $line;
          continue;
				}
        
				$row = array();
				for ($i = 0; $i < count($header_lables); $i++) {
					// Converting a CSV File Into an Associative Array					
					$key = $header[$i];
					if ( in_array ( $key, $header_lables ) ){
						$key = str_replace(' ','_', $key);
						$row[$key] = $line[$i]; 
					}						
			  }
        $processed_rec++;
      //   echo '<pre>';
      //  print_r($header);
      //  print_r($row);
      // //  $terms = \Drupal::entityTypeManager()->getStorage('location')->loadByProperties([
      // //   'vid' => 'Pune',
      // // ]);
      // // print_r($terms);
      //  exit;
                
         $batch['operations'][] = array ('\Drupal\tfm_importutilization\Controller\DefaultController::importutilization', array($row) );
       // \Drupal::logger('tfm_importutilization')->notice($row['Emp_Id']);
        // Create item to Drupal Queue-insertion ...........
        //$queue->createItem($row);       
       
			}	//end while	
       batch_set($batch);
     
		}
	}
 
    if ( isset($processed_rec)&& $processed_rec >=1 ) {
        //$this->messenger()->addMessage('imported successfully');
     \Drupal::messenger()->addMessage('imported successfully');
    }else{
      \Drupal::messenger()->addMessage('imported failed');
    }
        
  }

}


