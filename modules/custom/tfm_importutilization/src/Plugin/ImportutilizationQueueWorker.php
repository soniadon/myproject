<?php  
/**
 * @file
 * Contains custom\tfm_importutilization\src\Plugin\ImportutilizationQueueWorker.php.
 */
namespace Drupal\tfm_importutilization\Plugin\QueueWorker;


use Drupal\Core\Queue\QueueWorkerBase;


/**
 * Processes tasks for example module.
 *
 * @QueueWorker(
 *   id = "importutilization_queue",
 *   title = @Translation("Importutilization: Queue worker"),
 *   cron = {"time" = 10}
 * )
 */
class ImportutilizationQueueWorker extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($item) {
    
   // $c_user = user_load_by_name($item->Global_Employee_Id);
   \Drupal::logger('tfm_importutilization')->notice($item['Global_Employee_Id']);
 
 /*  
    $uid = $item->uid;
    $subscrition_id = $item->subscription_id;
    $user = \Drupal\user\Entity\User::load($uid);

    // Get some email service.
    $email_service = \Drupal::service('example.email');

    // Generate PDF
    $subscriber_service = \Drupal::service('example.subscriber_pdf');
   $pdf_attachment = $subscriber_service->buildPdf($subscriber_id, $user);

    // Do some stuff and send a mail.
    $emailService->prepareEmail($pdf_attachment);
    $emailService->send();

    $emailService->notifyAdmins($subscriber_id, $user);*/
  }

}