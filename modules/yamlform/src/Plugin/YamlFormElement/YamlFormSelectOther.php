<?php

/**
 * @file
 * Contains \Drupal\yamlform\Plugin\YamlFormElement\YamlFormSelectOther.
 */

namespace Drupal\yamlform\Plugin\YamlFormElement;

/**
 * Provides a 'select_other' element.
 *
 * @YamlFormElement(
 *   id = "yamlform_select_other",
 *   label = @Translation("Select other"),
 *   category = @Translation("Options")
 * )
 */
class YamlFormSelectOther extends Select {

  /**
   * {@inheritdoc}
   */
  public function getDefaultProperties() {
    return parent::getDefaultProperties() + [
      'other_option_label' => '',
      'other_placeholder' => '',
      'other_description' => '',
    ];
  }

}
