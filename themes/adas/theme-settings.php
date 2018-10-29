<?php
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\Core\Ajax\CommandInterface;

function probes_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface &$form_state, $form_id = NULL) {
    // Work-around for a core bug affecting admin themes. See issue #943212.
    $theme_file = drupal_get_path('theme', 'probes') . '/theme-settings.php';
    $build_info = $form_state->getBuildInfo();
    if (!in_array($theme_file, $build_info['files'])) {
        $build_info['files'][] = $theme_file;
    }
    $form_state->setBuildInfo($build_info);

    $form['#submit'][] = 'probes_theme_settings_form_submit';
    $form['#attached']['library'][] = 'probes/theme-settings';
    $form['advanced'] = array(
        '#type' => 'vertical_tabs',
        '#default_tab' => 'general_setting',
    );
    $form['general_setting'] = array(
        '#type' => 'details',
        '#title' => t('General Settings'),
        '#group' => 'advanced',
    );
    if (!\Drupal::moduleHandler()->moduleExists('yaml_editor')) {
        $message = t('<strong>It is recommended to install the</strong> <a href="@yaml-editor">YAML Editor</a> module for easier editing.', [
            '@yaml-editor' => 'https://www.drupal.org/project/yaml_editor',
        ]);

        //drupal_set_message($message, 'warning');
        $form['general_setting']['status_messages'] = [
           '#markup' => $message
        ];
    }
    $form['general_setting']['tracking_code'] = array(
        '#type'          => 'textarea',
        '#title'         => t('Tracking Code'),
        '#default_value' => theme_get_setting('tracking_code', 'probes'),
        '#description'   => t("Add custom script on your site."),
    );
    $form['general_setting']['custom_css'] = array(
        '#type'          => 'textarea',
        '#title'         => t('Custom CSS'),
        '#default_value' => theme_get_setting('custom_css', 'probes'),
        '#description'   => t('<strong>Example:</strong><br/>h1 { font-family: \'Metrophobic\', Arial, serif; font-weight: 400; }'),
    );
    $form['header_settings'] = array(
        '#type' => 'details',
        '#title' => t('Header Settings'),
        '#group' => 'advanced',
    );

    //Header settings
    $form['header_settings']['header_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Header layout'),
        '#options' => array(
            'layout1' => t('Layout 1'),
            'layout2' => t('Layout 2'),
            'layout3' => t('Layout 3'),
            'layout4' => t('Layout 4'),
            'layout5' => t('Layout 5'),
        ),
        '#default_value' => theme_get_setting('header_layout', 'probes'),
    );
    $form['header_settings']['header_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Header class'),
        '#default_value' => theme_get_setting('header_class', 'probes'),
    );
    $form['header_settings']['topbar_display'] = array(
        '#type'          => 'select',
        '#title'         => t('Topbar display'),
        '#options' => array(
            'on' => t('ON'),
            'off' => t('OFF'),
        ),
        '#default_value' => theme_get_setting('topbar_display', 'probes'),
    );
    $form['header_settings']['topbar_background_color'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Topbar background color'),
        '#placeholder'   => '0F00FF',
        '#size'          => 6,
        '#attributes'    => array (
            'class' => array('colorpickerField'),
        ),
        '#default_value' => theme_get_setting('topbar_background_color', 'probes'),
    );
    $form['header_settings']['topbar_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Topbar class'),
        '#default_value' => theme_get_setting('topbar_class', 'probes'),
    );

    //Footer settings
    $form['footer_settings'] = array(
        '#type' => 'details',
        '#title' => t('Footer Settings'),
        '#group' => 'advanced',
    );
    $form['footer_settings']['footer_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Footer layout'),
        '#options' => array(
            'layout1' => t('Layout 1'),
            'layout2' => t('Layout 2'),
            'layout3' => t('Layout 3'),
            'layout4' => t('Layout 4'),
            'layout5' => t('Layout 5'),
        ),
        '#default_value' => theme_get_setting('footer_layout', 'probes'),
    );
    $form['footer_settings']['footer_background_image'] = array(
            '#type'     => 'managed_file',
            '#title'    => t('Footer background image upload'),
            '#required' => FALSE,
            '#upload_location' => 'public://background/',
            '#default_value' => theme_get_setting('footer_background_image','probes'),
            '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
            '#progress_message' => 'Uploading ...',
            '#required' => FALSE,
        ),
    );
    $form['footer_settings']['footer_background_color'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Footer background color'),
        '#placeholder'   => '0F00FF',
        '#size'          => 6,
        '#attributes'    => array (
            'class' => array('colorpickerField'),
        ),
        '#default_value' => theme_get_setting('footer_background_color', 'probes'),
        '#description'   => t('Use Hex color set background color for footer')
    );
    $form['footer_settings']['footer_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Footer class'),
        '#default_value' => theme_get_setting('footer_class', 'probes'),
    );
    $form['footer_settings']['footer_copyright_message'] = array(
        '#type'          => 'textarea',
        '#title'         => t('Footer copyright message'),
        '#default_value' => theme_get_setting('footer_copyright_message', 'probes'),
    );

    //Portfolio settings
    $form['portfolio_settings'] = array(
        '#type' => 'details',
        '#title' => t('Portfolio Settings'),
        '#group' => 'advanced',
    );
    $form['portfolio_settings']['portfolio_style'] = array(
        '#type'          => 'select',
        '#title'         => t('Portfolio style'),
        '#options' => array(
            '2cols' => t('2 Columns'),
            '3cols' => t('3 Columns'),
            '4cols' => t('4 Columns'),
            'sidebar' => t('Sidebar Right'),
            'fullwidth' => t('Full Width'),
            'masonry1' => t('Masonry 1'),
            'masonry2' => t('Masonry 2'),
        ),
        '#default_value' => theme_get_setting('portfolio_style', 'probes'),
    );
    $form['portfolio_settings']['portfolio_header_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Header layout'),
        '#options' => array(
            'layout1' => t('Layout 1'),
            'layout2' => t('Layout 2'),
            'layout3' => t('Layout 3'),
            'layout4' => t('Layout 4'),
            'layout5' => t('Layout 5'),
        ),
        '#default_value' => theme_get_setting('portfolio_header_layout', 'probes'),
    );
    $form['portfolio_settings']['portfolio_header_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Header class'),
        '#default_value' => theme_get_setting('portfolio_header_class', 'probes'),
    );
    $form['portfolio_settings']['portfolio_topbar_display'] = array(
        '#type'          => 'select',
        '#title'         => t('Topbar display'),
        '#options' => array(
            'on' => t('ON'),
            'off' => t('OFF'),
        ),
        '#default_value' => theme_get_setting('portfolio_topbar_display', 'probes'),
    );
    $form['portfolio_settings']['portfolio_topbar_background_color'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Topbar background color'),
        '#placeholder'   => '0F00FF',
        '#size'          => 6,
        '#attributes'    => array (
            'class' => array('colorpickerField'),
        ),
        '#default_value' => theme_get_setting('portfolio_topbar_background_color', 'probes'),
    );
    $form['portfolio_settings']['portfolio_topbar_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Topbar class'),
        '#default_value' => theme_get_setting('portfolio_topbar_class', 'probes'),
    );
    $form['portfolio_settings']['portfolio_page_title_bgimage'] = array(
            '#type'     => 'managed_file',
            '#title'    => t('Page title background image upload'),
            '#required' => FALSE,
            '#upload_location' => 'public://background/',
            '#default_value' => theme_get_setting('portfolio_page_title_bgimage','probes'),
            '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
            '#progress_message' => 'Uploading ...',
            '#required' => FALSE,
        ),
    );
    $form['portfolio_settings']['portfolio_breadcrumb_class_title'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Breadcrumb class title'),
        '#default_value' => theme_get_setting('portfolio_breadcrumb_class_title', 'probes'),
    );
    $form['portfolio_settings']['portfolio_slogan'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Portfolio slogan'),
        '#default_value' => theme_get_setting('portfolio_slogan', 'probes'),
    );
    $form['portfolio_settings']['portfolio_footer_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Footer layout'),
        '#options' => array(
            'layout1' => t('Layout 1'),
            'layout2' => t('Layout 2'),
            'layout3' => t('Layout 3'),
            'layout4' => t('Layout 4'),
            'layout5' => t('Layout 5'),
        ),
        '#default_value' => theme_get_setting('portfolio_footer_layout', 'probes'),
    );
    $form['portfolio_settings']['portfolio_footer_background_image'] = array(
            '#type'     => 'managed_file',
            '#title'    => t('Footer background image upload'),
            '#required' => FALSE,
            '#upload_location' => 'public://background/',
            '#default_value' => theme_get_setting('portfolio_footer_background_image','probes'),
            '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
            '#progress_message' => 'Uploading ...',
            '#required' => FALSE,
        ),
    );
    $form['portfolio_settings']['portfolio_footer_background_color'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Footer background color'),
        '#placeholder'   => '0F00FF',
        '#size'          => 6,
        '#attributes'    => array (
            'class' => array('colorpickerField'),
        ),
        '#default_value' => theme_get_setting('portfolio_footer_background_color', 'probes'),
        '#description'   => t('Use Hex color set background color for footer')
    );
    $form['portfolio_settings']['portfolio_footer_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Footer class'),
        '#default_value' => theme_get_setting('portfolio_footer_class', 'probes'),
    );

    //Blog settting
    $form['blog_settings'] = array(
        '#type' => 'details',
        '#title' => t('Blog Settings'),
        '#group' => 'advanced',
    );
    $form['blog_settings']['blog_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Blog layout'),
        '#options' => array(
            'fullwidth' => t('Full Width'),
            '3cols' => t('3 Columns'),
            'standard' => t('Standard'),
        ),
        '#default_value' => theme_get_setting('blog_layout', 'probes'),
    );
    $form['blog_settings']['blog_header_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Header layout'),
        '#options' => array(
            'layout1' => t('Layout 1'),
            'layout2' => t('Layout 2'),
            'layout3' => t('Layout 3'),
            'layout4' => t('Layout 4'),
            'layout5' => t('Layout 5'),
        ),
        '#default_value' => theme_get_setting('blog_header_layout', 'probes'),
    );
    $form['blog_settings']['blog_header_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Header class'),
        '#default_value' => theme_get_setting('blog_header_class', 'probes'),
    );
    $form['blog_settings']['blog_topbar_display'] = array(
        '#type'          => 'select',
        '#title'         => t('Topbar display'),
        '#options' => array(
            'on' => t('ON'),
            'off' => t('OFF'),
        ),
        '#default_value' => theme_get_setting('blog_topbar_display', 'probes'),
    );
    $form['blog_settings']['blog_topbar_background_color'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Topbar background color'),
        '#placeholder'   => '0F00FF',
        '#size'          => 6,
        '#attributes'    => array (
            'class' => array('colorpickerField'),
        ),
        '#default_value' => theme_get_setting('blog_topbar_background_color', 'probes'),
    );
    $form['blog_settings']['blog_topbar_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Topbar class'),
        '#default_value' => theme_get_setting('blog_topbar_class', 'probes'),
    );
    $form['blog_settings']['blog_page_title_bgimage'] = array(
            '#type'     => 'managed_file',
            '#title'    => t('Page title background image upload'),
            '#required' => FALSE,
            '#upload_location' => 'public://background/',
            '#default_value' => theme_get_setting('blog_page_title_bgimage','probes'),
            '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
            '#progress_message' => 'Uploading ...',
            '#required' => FALSE,
        ),
    );
    $form['blog_settings']['blog_breadcrumb_class_title'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Breadcrumb class title'),
        '#default_value' => theme_get_setting('blog_breadcrumb_class_title', 'probes'),
    );
    $form['blog_settings']['blog_slogan'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Blog slogan'),
        '#default_value' => theme_get_setting('blog_slogan', 'probes'),
    );
    $form['blog_settings']['blog_footer_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Footer layout'),
        '#options' => array(
            'layout1' => t('Layout 1'),
            'layout2' => t('Layout 2'),
            'layout3' => t('Layout 3'),
            'layout4' => t('Layout 4'),
            'layout5' => t('Layout 5'),
        ),
        '#default_value' => theme_get_setting('blog_footer_layout', 'probes'),
    );
    $form['blog_settings']['blog_footer_background_image'] = array(
            '#type'     => 'managed_file',
            '#title'    => t('Footer background image upload'),
            '#required' => FALSE,
            '#upload_location' => 'public://background/',
            '#default_value' => theme_get_setting('blog_footer_background_image','probes'),
            '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
            '#progress_message' => 'Uploading ...',
            '#required' => FALSE,
        ),
    );
    $form['blog_settings']['blog_footer_background_color'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Footer background color'),
        '#placeholder'   => '0F00FF',
        '#size'          => 6,
        '#attributes'    => array (
            'class' => array('colorpickerField'),
        ),
        '#default_value' => theme_get_setting('blog_footer_background_color', 'probes'),
        '#description'   => t('Use Hex color set background color for footer')
    );
    $form['blog_settings']['blog_footer_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Footer class'),
        '#default_value' => theme_get_setting('blog_footer_class', 'probes'),
    );

    //Product detail settings
    $form['product_settings'] = array(
        '#type' => 'details',
        '#title' => t('Product Detail Settings'),
        '#group' => 'advanced',
    );
    $form['product_settings']['product_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('product layout'),
        '#options' => array(
            'nosidebar' => t('Full Width'),
            'left' => t('Left sidebar'),
            'right' => t('Right sidebar'),
        ),
        '#default_value' => theme_get_setting('product_layout', 'probes'),
    );
    $form['product_settings']['product_header_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Header layout'),
        '#options' => array(
            'layout1' => t('Layout 1'),
            'layout2' => t('Layout 2'),
            'layout3' => t('Layout 3'),
            'layout4' => t('Layout 4'),
            'layout5' => t('Layout 5'),
        ),
        '#default_value' => theme_get_setting('product_header_layout', 'probes'),
    );
    $form['product_settings']['product_header_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Header class'),
        '#default_value' => theme_get_setting('product_header_class', 'probes'),
    );
    $form['product_settings']['product_topbar_display'] = array(
        '#type'          => 'select',
        '#title'         => t('Topbar display'),
        '#options' => array(
            'on' => t('ON'),
            'off' => t('OFF'),
        ),
        '#default_value' => theme_get_setting('product_topbar_display', 'probes'),
    );
    $form['product_settings']['product_topbar_background_color'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Topbar background color'),
        '#placeholder'   => '0F00FF',
        '#size'          => 6,
        '#attributes'    => array (
            'class' => array('colorpickerField'),
        ),
        '#default_value' => theme_get_setting('product_topbar_background_color', 'probes'),
    );
    $form['product_settings']['product_topbar_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Topbar class'),
        '#default_value' => theme_get_setting('product_topbar_class', 'probes'),
    );
    $form['product_settings']['product_page_title_bgimage'] = array(
            '#type'     => 'managed_file',
            '#title'    => t('Page title background image upload'),
            '#required' => FALSE,
            '#upload_location' => 'public://background/',
            '#default_value' => theme_get_setting('product_page_title_bgimage','probes'),
            '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
            '#progress_message' => 'Uploading ...',
            '#required' => FALSE,
        ),
    );
    $form['product_settings']['product_breadcrumb_class_title'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Breadcrumb class title'),
        '#default_value' => theme_get_setting('product_breadcrumb_class_title', 'probes'),
    );
    $form['product_settings']['product_slogan'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Shop slogan'),
        '#default_value' => theme_get_setting('product_slogan', 'probes'),
    );
    $form['product_settings']['product_footer_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Footer layout'),
        '#options' => array(
            'layout1' => t('Layout 1'),
            'layout2' => t('Layout 2'),
            'layout3' => t('Layout 3'),
            'layout4' => t('Layout 4'),
        ),
        '#default_value' => theme_get_setting('product_footer_layout', 'probes'),
    );
    $form['product_settings']['product_footer_background_image'] = array(
            '#type'     => 'managed_file',
            '#title'    => t('Footer background image upload'),
            '#required' => FALSE,
            '#upload_location' => 'public://background/',
            '#default_value' => theme_get_setting('product_footer_background_image','probes'),
            '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
            '#progress_message' => 'Uploading ...',
            '#required' => FALSE,
        ),
    );
    $form['product_settings']['product_footer_background_color'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Footer background color'),
        '#placeholder'   => '0F00FF',
        '#size'          => 6,
        '#attributes'    => array (
            'class' => array('colorpickerField'),
        ),
        '#default_value' => theme_get_setting('product_footer_background_color', 'probes'),
        '#description'   => t('Use Hex color set background color for footer')
    );
    $form['product_settings']['product_footer_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Footer class'),
        '#default_value' => theme_get_setting('product_footer_class', 'probes'),
    );

    //Page settings
    $form['page_settings'] = array(
        '#type' => 'details',
        '#title' => t('Pages Settings'),
        '#group' => 'advanced',
    );
    $form['page_settings']['page_header_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Header layout'),
        '#options' => array(
            'layout1' => t('Layout 1'),
            'layout2' => t('Layout 2'),
            'layout3' => t('Layout 3'),
            'layout4' => t('Layout 4'),
            'layout5' => t('Layout 5'),
        ),
        '#default_value' => theme_get_setting('page_header_layout', 'probes'),
    );
    $form['page_settings']['page_header_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Header class'),
        '#default_value' => theme_get_setting('page_header_class', 'probes'),
    );
    $form['page_settings']['page_topbar_display'] = array(
        '#type'          => 'select',
        '#title'         => t('Topbar display'),
        '#options' => array(
            'on' => t('ON'),
            'off' => t('OFF'),
        ),
        '#default_value' => theme_get_setting('page_topbar_display', 'probes'),
    );
    $form['page_settings']['page_topbar_background_color'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Topbar background color'),
        '#placeholder'   => '0F00FF',
        '#size'          => 6,
        '#attributes'    => array (
            'class' => array('colorpickerField'),
        ),
        '#default_value' => theme_get_setting('page_topbar_background_color', 'probes'),
    );
    $form['page_settings']['page_topbar_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Topbar class'),
        '#default_value' => theme_get_setting('page_topbar_class', 'probes'),
    );
     $form['page_settings']['system_page_title_bgimage'] = array(
        '#type'     => 'managed_file',
        '#title'    => t('Page title background image upload'),
        '#required' => FALSE,
        '#upload_location' => 'public://background/',
        '#default_value' => theme_get_setting('system_page_title_bgimage','probes'),
        '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
            '#progress_message' => 'Uploading ...',
            '#required' => FALSE,
        ),
    );
    $form['page_settings']['page_breadcrumb_class_title'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Breadcrumb class title'),
        '#default_value' => theme_get_setting('page_breadcrumb_class_title', 'probes'),
    );
    $form['page_settings']['page_footer_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Footer layout'),
        '#options' => array(
            'layout1' => t('Layout 1'),
            'layout2' => t('Layout 2'),
            'layout3' => t('Layout 3'),
            'layout4' => t('Layout 4'),
        ),
        '#default_value' => theme_get_setting('page_footer_layout', 'probes'),
    );
    $form['page_settings']['page_footer_background_image'] = array(
            '#type'     => 'managed_file',
            '#title'    => t('Footer background image upload'),
            '#required' => FALSE,
            '#upload_location' => 'public://background/',
            '#default_value' => theme_get_setting('page_footer_background_image','probes'),
            '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
            '#progress_message' => 'Uploading ...',
            '#required' => FALSE,
        ),
    );
    $form['page_settings']['page_footer_background_color'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Footer background color'),
        '#placeholder'   => '0F00FF',
        '#size'          => 6,
        '#attributes'    => array (
            'class' => array('colorpickerField'),
        ),
        '#default_value' => theme_get_setting('page_footer_background_color', 'probes'),
        '#description'   => t('Use Hex color set background color for footer')
    );
    $form['page_settings']['page_footer_class'] = array(
        '#type'          => 'textfield',
        '#title'         => t('Footer class'),
        '#default_value' => theme_get_setting('page_footer_class', 'probes'),
    );

    //Skin settings
    //Page settings
    $form['skin_settings'] = array(
        '#type' => 'details',
        '#title' => t('Skin Settings'),
        '#group' => 'advanced',
    );
    $form['skin_settings']['probes_disable_switch'] = array(
        '#type'          => 'select',
        '#title'         => t('Switcher style'),
        '#options' => array(
            'on' => t('ON'),
            'off' => t('OFF'),
        ),
        '#default_value' => theme_get_setting('probes_disable_switch', 'probes'),
    );
    $form['skin_settings']['probes_site_layout'] = array(
        '#type'          => 'select',
        '#title'         => t('Choose Layout'),
        '#options' => array(
            'wide' => t('Wide'),
            'boxed' => t('Boxed'),
        ),
        '#default_value' => theme_get_setting('probes_site_layout', 'probes'),
    );
    $form['skin_settings']['bg_patterns_boxed'] = array(
            '#type'     => 'managed_file',
            '#title'    => t('Background patterns for boxed'),
            '#required' => FALSE,
            '#upload_location' => 'public://background/',
            '#default_value' => theme_get_setting('bg_patterns_boxed','probes'),
            '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
            '#progress_message' => 'Uploading ...',
            '#required' => FALSE,
        ),
    );
    $form['skin_settings']['built_in_skins'] = array(
        '#type'          => 'radios',
        '#title'         => t('Built-in Skins'),
        '#options' => array(
            'none' => t('None'),
            'blue' => t('Blue'),
            'green' => t('Green'),
            'lightblue' => t('Light blue'),
            'lightgreen' => t('Light green'),
            'lightred' => t('Light red'),
            'olive' => t('Olive'),
            'orange' => t('Orange'),
            'red' => t('Red'),
            'sea' => t('Sea'),
            'violet' => t('Violet'),
        ),
        '#default_value' => theme_get_setting('built_in_skins', 'probes'),
    );
}

function probes_theme_settings_form_submit(&$form, FormStateInterface $form_state) {
    $image_fid[0] = $form_state->getValue('footer_background_image');
    $image_fid[1] = $form_state->getValue('blog_page_title_bgimage');
    $image_fid[2] = $form_state->getValue('blog_footer_background_image');
    $image_fid[3] = $form_state->getValue('portfolio_footer_background_image');
    $image_fid[4] = $form_state->getValue('portfolio_page_title_bgimage');
    $image_fid[5] = $form_state->getValue('system_page_title_bgimage');
    $image_fid[6] = $form_state->getValue('product_page_title_bgimage');
    $image_fid[7] = $form_state->getValue('product_footer_background_image');
    $image_fid[8] = $form_state->getValue('bg_patterns_boxed');
    $count = count($image_fid);
    for ($i=0; $i < $count; $i++) {
        if( $image_fid[$i]) {
            $file = File::load($image_fid[$i][0]);
            $file_usage = \Drupal::service('file.usage');
            $file_usage->add($file, 'probes', 'theme', 1);
        }
    }
        
}
?>