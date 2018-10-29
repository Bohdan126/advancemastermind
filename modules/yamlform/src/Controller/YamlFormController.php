<?php

/**
 * @file
 * Contains \Drupal\yamlform\Controller\YamlFormController.
 */

namespace Drupal\yamlform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\yamlform\YamlFormInterface;
use Drupal\yamlform\YamlFormMessageManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides route responses for YAML form.
 */
class YamlFormController extends ControllerBase {

  /**
   * Returns a form to add a new submission to a YAML form.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request.
   * @param \Drupal\yamlform\YamlFormInterface $yamlform
   *   The YAML form this submission will be added to.
   *
   * @return array
   *   The YAML form submission form.
   */
  public function addForm(Request $request, YamlFormInterface $yamlform) {
    return $yamlform->getSubmissionForm();
  }

  /**
   * Returns a YAML form confirmation page.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request.
   * @param \Drupal\yamlform\YamlFormInterface $yamlform
   *   The YAML form.
   *
   * @return array
   *   A render array represent a YAML form confirmation page
   */
  public function confirmation(Request $request, YamlFormInterface $yamlform) {
    /** @var \Drupal\yamlform\YamlFormSubmissionInterface $yamlform_submission */
    if ($token = $request->get('token')) {
      /** @var \Drupal\yamlform\YamlFormSubmissionStorageInterface $yamlform_submission_storage */
      $yamlform_submission_storage = $this->entityManager()->getStorage('yamlform_submission');
      $entities = $yamlform_submission_storage->loadByProperties(['token' => $token]);
      $yamlform_submission = reset($entities);
    }
    else {
      $yamlform_submission = NULL;
    }

    $settings = $yamlform->getSettings();

    $build = [];

    $build['#yamlform'] = $yamlform;
    $build['#yamlform_submission'] = $yamlform_submission;

    $build['#title'] = $yamlform->label();

    /** @var \Drupal\yamlform\YamlFormMessageManagerInterface $message_manager */
    $message_manager = \Drupal::service('yamlform.message_manager');
    $message_manager->setYamlForm($yamlform);
    $message_manager->setYamlFormSubmission($yamlform_submission);

    // Add wizard progress tracker to the form.
    if ($settings['wizard_complete'] && ($settings['wizard_progress_bar'] || $settings['wizard_progress_pages'] || $settings['wizard_progress_percentage'])) {
      $build['progress'] = [
        '#theme' => 'yamlform_progress',
        '#yamlform' => $yamlform,
        '#current_page' => 'complete',
      ];
    }

    $build['confirmation'] = $message_manager->build(YamlFormMessageManagerInterface::SUBMISSION_CONFIRMATION);

    // Link back to the source URL or the main YAML form.
    if ($yamlform_submission) {
      $url = $yamlform_submission->getSourceUrl();
    }
    else {
      // Apply all passed query string parameters to the 'Back to form' link.
      $query = $request->query->all();
      unset($query['yamlform_id']);
      $options = ($query) ? ['query' => $query] : [];
      $url = $yamlform->toUrl('canonical', $options);
    }
    if ($url) {
      $build['back_to'] = [
        '#prefix' => '<p>',
        '#suffix' => '</p>',
        '#type' => 'link',
        '#title' => $this->t('Back to form'),
        '#url' => $url,
      ];
    }

    return $build;
  }

  /**
   * Route title callback.
   *
   * @param \Drupal\yamlform\YamlFormInterface $yamlform
   *   The YAML form.
   *
   * @return string
   *   The YAML form label as a render array.
   */
  public function title(YamlFormInterface $yamlform) {
    return $yamlform->label();
  }

}
