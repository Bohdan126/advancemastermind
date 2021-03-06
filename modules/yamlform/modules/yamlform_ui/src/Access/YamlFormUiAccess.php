<?php

/**
 * @file
 * Definition of Drupal\yamlform_ui\Access\YamlFormUiAccess.
 */

namespace Drupal\yamlform_ui\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\yamlform\YamlFormInterface;

/**
 * Defines the custom access control handler for the YAML form UI.
 */
class YamlFormUiAccess {

  /**
   * Check that YAML form can be updated by a user.
   *
   * @param \Drupal\yamlform\YamlFormInterface $yamlform
   *   A YAML form.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  static public function checkYamlFormEditAccess(YamlFormInterface $yamlform, AccountInterface $account) {
    return AccessResult::allowedIf(!$yamlform->hasTranslations() && $account->hasPermission('administer yamlform'));
  }

}
