<?php
namespace Drupal\navi_color_field\Plugin\Field\FieldWidget;
use Drupal;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
/**
* Plugin implementation of the 'ColorDefaultWidget' widget.
*
* @FieldWidget(
*   id = "ColorDefaultWidget",
*   label = @Translation("Color"),
*   field_types = {
*     "Navi_Color"
*   }
* )
*/
class ColorDefaultWidget extends WidgetBase {
    /**
    * Define the form for the field type.
    *
    * Inside this method we can define the form used to edit the field type.
    *
    * Here there is a list of allowed element types: https://goo.gl/XVd4tA
    */
public function formElement(
    FieldItemListInterface $items,
    $delta,
    Array $element,
    Array &$form,
    FormStateInterface $formState
    ) {
    $title = $this->fieldDefinition->getLabel();
    $element['color'] = [
        '#type' => 'textfield',
        '#title' => $title,
        '#attributes' => array(
            'id' => 'colorpickerField',
         ),
        '#size' => 6,
        // Set here the current value for this field, or a default value (or
        // null) if there is no a value
        '#default_value' => isset($items[$delta]->color) ?
        $items[$delta]->color : NULL,
        '#placeholder' => t('0F0F0F'),
        '#attached' => array('library'=> array('navi_color_field/color_picker')),
    ];
    return $element;
    }
} // class