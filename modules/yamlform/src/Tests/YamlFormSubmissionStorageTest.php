<?php

/**
 * @file
 * Definition of Drupal\yamlform\Tests\YamlFormSubmissionStorageTest.
 */

namespace Drupal\yamlform\Tests;

use Drupal\simpletest\WebTestBase;
use Drupal\yamlform\Entity\YamlFormSubmission;

/**
 * Tests for YAML form storage tests.
 *
 * @group YamlForm
 */
class YamlFormSubmissionStorageTest extends WebTestBase {

  use YamlFormTestTrait;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['system', 'user', 'yamlform'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * {@inheritdoc}
   */
  public function tearDown() {
    $this->purgeSubmissions();
    parent::tearDown();
  }

  /**
   * Test YAML form submission storage.
   */
  public function testSubmissionStorage() {
    /** @var \Drupal\yamlform\YamlFormSubmissionStorageInterface $storage */
    $storage = \Drupal::entityManager()->getStorage('yamlform_submission');

    $yamlform = $this->createYamlForm();

    // Create 3 submissions for user1.
    $user1 = $this->drupalCreateUser();
    $this->drupalLogin($user1);
    $user1_submissions = [
      YamlFormSubmission::load($this->postSubmission($yamlform)),
      YamlFormSubmission::load($this->postSubmission($yamlform)),
      YamlFormSubmission::load($this->postSubmission($yamlform)),
    ];

    // Create 3 submissions for user2.
    $user2 = $this->drupalCreateUser();
    $this->drupalLogin($user2);
    $user2_submissions = [
      YamlFormSubmission::load($this->postSubmission($yamlform)),
      YamlFormSubmission::load($this->postSubmission($yamlform)),
      YamlFormSubmission::load($this->postSubmission($yamlform)),
    ];

    // Create admin user who can see all submissions.
    $admin_user = $this->drupalCreateUser(['administer yamlform']);

    // Check total.
    $this->assertEqual($storage->getTotal($yamlform), 6);
    $this->assertEqual($storage->getTotal($yamlform, $user1), 3);
    $this->assertEqual($storage->getTotal($yamlform, $user2), 3);

    // Check next submission.
    $this->assertEqual($storage->getNextSubmission($user1_submissions[0], $user1)->id(), $user1_submissions[1]->id(), "User 1 can navigate forward to user 1's next submission");
    $this->assertNull($storage->getNextSubmission($user1_submissions[2], $user1), "User 1 can't navigate forward to user 2's next submission");
    $this->assertEqual($storage->getNextSubmission($user1_submissions[2], $admin_user)->id(), $user2_submissions[0]->id(), "Admin user can navigate between user submissions");

    // Check previous submission.
    $this->assertEqual($storage->getPreviousSubmission($user1_submissions[1], $user1)->id(), $user1_submissions[0]->id(), "User 1 can navigate backward to user 1's previous submission");
    $this->assertNull($storage->getPreviousSubmission($user2_submissions[0], $user2), "User 2 can't navigate backward to user 1's previous submission");
    $this->assertEqual($storage->getPreviousSubmission($user2_submissions[0], $admin_user)->id(), $user1_submissions[2]->id(), "Admin user can navigate between user submissions");
  }

}
