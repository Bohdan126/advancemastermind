<?php

/**
 * @file
 * Definition of Drupal\tardis\Plugin\views\style\Tardis.
 */

namespace Drupal\nvt_views_style\Plugin\views\style;

use Drupal\core\form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to render a list of years and months
 * in reverse chronological order linked to content.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "nvt_views_style",
 *   title = @Translation("NaviTeamView"),
 *   help = @Translation("Render a list of years and months in reverse chronological order linked to content."),
 *   theme = "views_view_naviviews",
 *   display_types = { "normal" }
 * )
 *
 */
class NvtViewStyle extends StylePluginBase {

	/**
   	* Does the style plugin allows to use style plugins.
   	*
   	* @var bool
   	*/
  	protected $usesRowPlugin = TRUE;


	/**
   	* Set default options
   	*/
  	protected function defineOptions() {
    	$options = parent::defineOptions();
    	$options['element'] = array('default' => 'div');
	    $options['class_attribute'] = array('default' => '');
	    $options['last_every_nth'] = array('default' => '');
	    $options['first_class'] = array('default' => 'first');
	    $options['last_class'] = array('default' => 'last');
        $options['wrapper_class'] = array('default' => '');
        $options['wrapper_id'] = array('default' => '');
	    return $options;
  	}
  	/**
   * {@inheritdoc}
   */
  	public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    	parent::buildOptionsForm($form, $form_state);
    	$form['element'] = array(
    		'#title' => $this->t('Element:'),
      		'#type' => 'textfield',
      		'#prefix' => '<div class="views-left-50">',
	      	'#suffix' => '</div>',
      		'#size' => '30',
	      	'#default_value' => $this->options['element'],
    	);
    	$form['class_attribute'] = array(
	      	'#title' => $this->t('Class attribute'),
	      	'#description' => $this->t('Insert a class you want row enumeration '),
	      	'#prefix' => '<div class="views-right-50">',
	      	'#suffix' => '</div>',
	      	'#type' => 'textfield',
	      	'#size' => '30',
	      	'#default_value' => $this->options['class_attribute'],
    	);
    	$form['help'] = array(
    		'#title' => $this->t('FIRST AND LAST CLASSES'),
      		'#type' => 'item',
      		'#description' => $this->t('If the FIRST/LAST every nth option is empty or zero, the FIRST class attribute and LAST class attribute are added once to only the first and last rows in the pager set. If this option is greater than 1, these classes are added to every nth row, which may be useful for grid layouts where the initial and final unit’s lateral margins must be 0.'
      		),
    	);
    	$form['last_every_nth'] = array(
	      	'#title' => $this->t('FIRST/LAST every n<sup>th</sup>'),
	      	'#description' => $this->t('The class to provide on the list element itself.'),
	      	'#type' => 'textfield',
	      	'#size' => '30',
	      	'#default_value' => $this->options['last_every_nth'],
    	);
    	$form['first_class'] = array(
	      	'#prefix' => '<div class="views-left-50">',
	      	'#suffix' => '</div>',
	      	'#title' => t('FIRST class attribute'),
	      	'#type' => 'textfield',
	      	'#size' => '30',
	      	'#default_value' => $this->options['first_class'],
    	);
    	$form['last_class'] = array(
	      	'#prefix' => '<div class="views-right-50">',
	      	'#suffix' => '</div>',
	      	'#title' => t('FIRST class attribute'),
	      	'#type' => 'textfield',
	      	'#size' => '30',
	      	'#default_value' => $this->options['last_class'],
    	);
        $form['wrapper_class'] = array(
            '#title' => $this->t('Wrapper class'),
            '#description' => $this->t('The class to provide on the wrapper, outside the navi style.'),
            '#prefix' => '<div class="views-left-50">',
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#size' => '30',
            '#default_value' => $this->options['wrapper_class'],
        );
        $form['wrapper_id'] = array(
            '#title' => $this->t('Wrapper ID'),
            '#description' => $this->t('The ID to provide on the wrapper, outside the navi style.'),
            '#prefix' => '<div class="views-right-50">',
            '#suffix' => '</div>',
            '#type' => 'textfield',
            '#size' => '30',
            '#default_value' => $this->options['wrapper_id'],
        );
  	}
}