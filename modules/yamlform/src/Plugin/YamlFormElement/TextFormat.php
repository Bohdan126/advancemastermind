<?php

/**
 * @file
 * Contains \Drupal\yamlform\Plugin\YamlFormElement\TextFormat.
 */

namespace Drupal\yamlform\Plugin\YamlFormElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Mail\MailFormatHelper;
use Drupal\filter\Entity\FilterFormat;
use Drupal\yamlform\YamlFormElementBase;

/**
 * Provides a 'text_format' element.
 *
 * @YamlFormElement(
 *   id = "text_format",
 *   api = "https://api.drupal.org/api/drupal/core!modules!filter!src!Element!TextFormat.php/class/TextFormat",
 *   label = @Translation("Text format"),
 *   category = @Translation("Advanced"),
 *   multiline = TRUE
 * )
 */
class TextFormat extends YamlFormElementBase {

  /**
   * {@inheritdoc}
   */
  public function setDefaultValue(array &$element) {
    if (isset($element['#default_value']) && is_array($element['#default_value'])) {
      $element['#format'] = $element['#default_value']['format'];
      $element['#default_value'] = $element['#default_value']['value'];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function formatHtml(array &$element, $value, array $options = []) {
    if (isset($value['value']) && isset($value['format'])) {
      return check_markup($value['value'], $value['format']);
    }
    else {
      return $value;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function formatText(array &$element, $value, array $options = []) {
    if (isset($value['value']) && isset($value['format'])) {
      $html = check_markup($value['value'], $value['format']);
      // Convert any HTML to plain-text.
      $html = MailFormatHelper::htmlToText($html);
      // Wrap the mail body for sending.
      $html = MailFormatHelper::wrapMail($html);
      return $html;
    }
    else {
      return $value;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultFormat() {
    return filter_default_format();
  }

  /**
   * {@inheritdoc}
   */
  public function getFormats() {
    $filters = FilterFormat::loadMultiple();
    $formats = parent::getFormats();
    foreach ($filters as $filter) {
      $formats[$filter->id()] = $filter->label();
    }
    return $formats;
  }


  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    return $form;
  }

}
