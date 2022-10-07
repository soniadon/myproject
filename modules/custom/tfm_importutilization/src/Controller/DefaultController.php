<?php

namespace Drupal\tfm_importutilization\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;
use Drupal\Core\Database\Driver\mysql\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;



class DefaultController extends ControllerBase {

	protected $db, $account;
/**
 * 
 * @param Connection $database
 * @param AccountInterface $AI_Obj
 */
	public function __construct(Connection $database, AccountInterface $AI_Obj){
		$this->db = $database;
		$this->account = $AI_Obj;
	}
/**
 * 
 * @param ContainerInterface $container
 * @return \static
 */
 public static function create(ContainerInterface $container){
   	 //load the service created  to construct this class
		$database = $container->get('database');
		$currentUserIFC = $container->get('current_user');
	 
	 return new static ( $database, $currentUserIFC );

 }

 /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function index() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Im Default function in Default controller. Im done my job')
    ];
  }
	
	/**
	 *
	 */
	public function showcontent(){
	 
	  $username = $this->account->getUsername(); 
    $email_Id = $this->account->getEmail(); 
    $Roles = $this->account->getRoles(); 
		///print_r($Roles);
		$roles_str = '';
		$i=1;
		foreach ($Roles as $eachrole){
			$roles_str .= '  '.$i.')' . $eachrole;
			$i++;
			
		}
	 
   //db_select is deprecated
   $select = $this->db->select('node', 'n');
   $select->fields('n');
  // $select->condition('type', "page", "=");
   $entries = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);
   $page_count = count($entries);
   $myNumber =  '9880429900';
   $cow_service = \Drupal::service('cow.animal');
   $mycow = $cow_service->howDoYouLookLike();
    $build = [
       // Your theme hook name.
     '#theme' => 'corona_theme_hook',		 
     // variables to print. 
     '#name' => $username,
     '#email_Id' => $email_Id,
     '#cow' => $mycow,
     '#dbcontent' => $entries,
   ];
   return $build;

 }

 /**
  * 
  * @return string Returns a render-able array for a test page.
  */
  public function waffy() {
    $vob_name='primary_skill';
    $term_name='BPM Pega'; 

    $rs_arr = taxonomy_term_load_multiple_by_name ($term_name, $vob_name);  
    print_r($rs_arr);
    if (!empty($rs_arr) && count($rs_arr)>=1 ){
      echo 'NNN'.key($rs_arr);  
    }else{
      $parent = array();
      // Create the taxonomy term.
      $new_term = Term::create([
      'name'   => $term_name,
      'vid'    => $vob_name,
      'parent' => $parent,
      ]);

      // Save the taxonomy term.
      $new_term->enforceIsNew();
      $new_term->save();

      // Return the taxonomy term id.
     echo  $new_term->id();
    }
    
    
    ///$new_term = taxonomy_term_load_multiple_by_name ($term, $vocabulary);
  
    exit;
    return;
    
    $parent     = array();
      // Create the taxonomy term.
    $new_term = Term::create([
      'name' => $term,
      'vid' => $vocabulary,
      'parent' => $parent,
    ]);

    // Save the taxonomy term.
    $new_term->enforceIsNew();
    $new_term->save();
    
    echo  $new_term->id();
    exit;
    return;
  }
 /**
  * 
  * @param type $name
  * @return type
  */
  public function school($name){
    $student_det = '';
    $build = [
          // Your theme hook name.
      '#theme' => 'school_theme_hook',
      '#school_name'=> $name,
      '#student_det' => $student_det,
    ];
    return $build;

  }
  /**
  * 
  * @param type $term_name, $vob_name
  * @return array 
  */
  public static function termid_by_vob( $term_name, $vob_name, array $parent = [] ) {
    
    if ( !isset($term_name) || $term_name == "" ){
      return '';
    }
    //echo  $term_name;
    //exit;
    //load or create terms
    $rs_arr = taxonomy_term_load_multiple_by_name ($term_name, $vob_name);  
    if (!empty($rs_arr) && count($rs_arr)>=1 ){
      return  key($rs_arr);  
    }else{
      // Create the taxonomy term.
      $new_term = Term::create([
        'name'   => $term_name,
        'vid'    => $vob_name,
        'parent' => $parent,
      ]);

      // Save the taxonomy term.
      $new_term->enforceIsNew();
      $new_term->save();

    // Return the taxonomy term id.
      return $new_term->id();
    }
  }
  /**
  *
  * @param type $c_account 
  * save all user fields
  */
  public static function importutilization($row, &$context){
   
   
   if ($row['Emp_Id']!= "" &&$row['Emp_Username']!="" ){
    
    $c_account =  user_load_by_name($row['Emp_Username']);
    
    if ( !$c_account ) {
      $c_account = \Drupal\user\Entity\User::create();
      //Mandatory settings
      $c_account->setPassword('test@123');
      $c_account->enforceIsNew();
      //$c_account->setEmail($row['Email_ID']);
     // $c_account->setEmail( $row['Email_ID'] ); //prabhakar.bodipalli@capgemini.com
      //$user_email = $row['Emp_Username'].'@capgemini.com'; //pbodipal@capgemini.com
      $c_account->setUsername($row['Emp_Username']);

      //Optional settings
      $c_account->activate();
      $c_account->set("status",1);     
    }
    
    $c_account->set("field_global_employee_id", $row['Global_Employee_Id']);
    $c_account->set("field_emp_id", $row['Emp_Id']); 
    $user_email = $row['Emp_Username'].'@capgemini.com'; //pbodipal@capgemini.com

    $c_account->set("field_emp_name", $row['Emp_Name']); 
    $c_account->set("field_emp_username", $row['Emp_Username']);  
    $user_email = $row['Emp_Username'].'@capgemini.com'; //pbodipal@capgemini.com
    //$c_account->set("field_email_id", $row['Email_ID']);
    $c_account->set("field_email_id", $user_email);
    $c_account->set("field_fresher", $row['Fresher']); 
    $c_account->set("field_hire_date", $row['Hire_Date']); 
    $c_account->set("field_lwd", $row['LWD']); // LWD : Last Working Day
    $c_account->set("field_supervisor_name", $row['Supervisor_Name']); // 
    $c_account->set("field_account", $row['Account'] );
    $c_account->set("field_allocation_start_date", $row['Allocation_Start_Date']);
    $c_account->set("field_allocation_end_date", $row['Allocation_End_Date']);
    //$c_account->set("field_resource_current_status", $row['Resource_Current_Status']);
    $c_account->set("field_hc", $row['HC']);
    $c_account->set("field_age", $row['Age']);
    //$c_account->set("field_ou_code", $row['OU_Code']); 
    $c_account->set("field_employee_type", $row['Employee_Type']); 
    $c_account->set("field_captives_p_c", $row['Captives/P&C']); //
    $c_account->set("field_training_days_cal_days_", $row['Training_Days_(Cal_Days)']); 
    $c_account->set("field_shadow_day_cal_days_", $row['Shadow_Day_(Cal_Days)']);
    $c_account->set("field_billing_days_cal_days_", $row['Billing_Days_(Cal_Days)']);
    //$c_account->set("field_account_availability", $row['Availability']);
    //$c_account->set("field_non_deployable", $row['Non-Deployable']);
    $c_account->set("field_proposed_so_numbers", $row['Proposed_SO_Numbers']);
    $c_account->set("field_proposed_accounts", $row['Proposed_accounts']); 
    $c_account->set("field_proposed_dates", $row['Proposed_Dates']); 
    $c_account->set("field_last_cv_updated", $row['Last_CV_Updated']); 
    $c_account->set("field_sez_non_sez", $row['SEZ/Non-SEZ']); 
    $c_account->set("field_generic_skill", $row['Generic_Skill']); 
   
    $c_account->set("field_icx", $row['iCX']); //
    $c_account->set("field_pid", $row['PID']); // project entity 
    $c_account->set("field_project_name", $row['Project_Name']); // project entity   
    $c_account->set("field_project_manager", $row['Project_Manager']); // project entity user table    
    $c_account->set("field_project_type", $row['Project_Type']);  // project entity   
    
    $c_account->set("field_resource_type", $row['Resource_Type']); 
    //$c_account->set("field_supply_type", $row['Supply_Type']); 
    
    $service_line =  self::termid_by_vob($row['Service_Line'], 'service_line');
    $c_account->set("field_service_line", $service_line);
   
    $final_grade =  self::termid_by_vob($row['Final_Grade'], 'final_grade');
    $c_account->set("field_final_grade", $final_grade);
    
    $grade =  self::termid_by_vob($row['Grade'], 'grade');
    $c_account->set("field_grade", $grade);
    
    $location =  self::termid_by_vob($row['Location'], 'location');
    $c_account->set("field_location", $location);
    
    $sub_location =  self::termid_by_vob($row['Sub_Location'], 'sub_location');
    $c_account->set("field_sub_location", $sub_location);
    
	  $primary_skill =  self::termid_by_vob($row['Primary_Skill'], 'primary_skill');
    $c_account->set("field_primary_skill", $primary_skill);
	
    $secondary_skill =  self::termid_by_vob($row['Secondary_Skill'], 'secondary_skill');
    $c_account->set("field_secondary_skill", $secondary_skill);
    
	  $delivery_bu =  self::termid_by_vob($row['Delivery_BU'], 'delivery_bu');
    $c_account->set("field_delivery_bu", $delivery_bu);
    
	  $delivery_region =  self::termid_by_vob($row['Delivery_Region'], 'delivery_region');
    $c_account->set("field_delivery_region", $delivery_region);
    
	  $sector_country =  self::termid_by_vob($row['Sector/Country'], 'sector_country');
    $c_account->set("field_sector_country", $sector_country);
    
	  $domain =  self::termid_by_vob($row['Domain'], 'domain');
    $c_account->set("field_domain", $domain);

    $supply_type =  self::termid_by_vob($row['Supply_Type'], 'supply_type');
    $c_account->set("field_supply_type", $supply_type);

    $account_availability =  self::termid_by_vob($row['Availability'], 'account_availability');
    $c_account->set("field_account_availability", $account_availability);

    //$availability =  self::termid_by_vob($row['Availability'], 'availability');
    //$c_account->set("field_availability", $row['availability']);

    $non_deployable =  self::termid_by_vob($row['Non-Deployable'], 'non_deployable');
    $c_account->set("field_non_deployable", $non_deployable);
    
    $ou_code =  self::termid_by_vob($row['OU_Code'], 'ou_code');
    $c_account->set("field_ou_code", $ou_code);

    $resource_current_status =  self::termid_by_vob($row['Resource_Current_Status'], 'resource_current_status');
    $c_account->set("field_resource_current_status", $resource_current_status);
    

    //Save user
    $res = $c_account->save();

    
    \Drupal::logger('tfm_importutilization')->notice($row['Emp_Id']);
     
     
     
   }
      
   
   
  }
  
   public static function  importutilizationFinishedCallback($success, $results, $operations) {
    // The 'success' parameter means no fatal PHP errors were detected. All
    // other error management should be handled using 'results'.
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One post processed.', '@count posts processed.'
      );
    }
    else {
      $message = t('Finished with an error.');
    }
   // drupal_set_message($message);
   \Drupal::messenger()->addMessage($message);
  }
  
  
}//end of class
