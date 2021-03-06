<?php

/**
 * @file
 * Definition of Drupal\yamlform\Tests\YamlFormTestBase.
 */

namespace Drupal\yamlform\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Defines an abstract test base for YAML form tests.
 */
abstract class YamlFormTestBase extends WebTestBase {

  use YamlFormTestTrait;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['system', 'block', 'node', 'user', 'yamlform', 'yamlform_test'];

  /**
   * YAML form submission storage.
   *
   * @var \Drupal\yamlform\YamlFormSubmissionStorageInterface
   */
  protected $submissionStorage;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Storage.
    $this->submissionStorage = \Drupal::entityManager()->getStorage('yamlform_submission');

    // Set page.front (aka <front>) to /node instead of /user/login.
    \Drupal::configFactory()->getEditable('system.site')->set('page.front', '/node')->save();

    // Place blocks.
    $this->placeBlocks();

    // Create users.
    $this->createUsers();

    // Login the normal user.
    $this->drupalLogin($this->normalUser);
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    $this->purgeSubmissions();
    parent::tearDown();
  }

}
