<?php
namespace Drupal\navi_color_field\Plugin\Field\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\field\Plugin\Type\FieldType\ConfigFieldItemBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
/**
* Plugin implementation of the 'address' field type.
*
* @FieldType(
*   id = "Navi_Color",
*   label = @Translation("Color"),
*   description = @Translation("<field_type_description>"),
*   category = @Translation("Custom"),
*   default_widget = "ColorDefaultWidget",
*   default_formatter = "color_default"
* )
*/
class ColorItem extends FieldItemBase {

    /**
    * Field type schema definition.
    *
    * Inside this method we defines the database schema used to store data for
    * our field type.
    *
    * Here there is a list of allowed column types: https://goo.gl/YY3G7s
    */
    public static function schema(FieldStorageDefinitionInterface $field_definition) {

        return array(
            'columns' => array(
                'color' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'not null' => FALSE,
                ),
            ),
        );

    }

    /**
   * {@inheritdoc}
   */
    public function isEmpty() {
        $value = $this->get('color')->getValue();
        return $value === NULL || $value === '';
    }
    /**
   * {@inheritdoc}
   */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
        $properties['color'] = DataDefinition::create('string');

        return $properties;
    }
}