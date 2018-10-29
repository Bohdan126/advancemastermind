<?php

/**
 * @file
 * Contains \Drupal\navi_color_field\Plugin\Field\FieldFormatter\ColorDefaultFormatter.
 */

namespace Drupal\navi_color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Random_default' formatter.
 *
 * @FieldFormatter(
 *   id = "color_default",
 *   label = @Translation("Color field"),
 *   field_types = {
 *     "Navi_Color"
 *   }
 * )
 */
class ColorDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $settings = $this->getSettings();

    $summary[] = t('Displays the color.');

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = array();

    foreach ($items as $delta => $item) {
      // Render each element as markup.
      $element[$delta] = array(
        '#type' => 'markup',
        '#markup' => $item->color,
      );
    }

    return $element;
  }
}