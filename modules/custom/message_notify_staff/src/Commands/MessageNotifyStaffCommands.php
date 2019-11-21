<?php

namespace Drupal\message_notify_staff\Commands;

use Drupal\Core\Session\UserSession;
use Drush\Commands\DrushCommands;
use Drupal\Core\Session\AccountSwitcherInterface;
use Drupal\message_digest;

class MessageNotifyStaffCommands extends DrushCommands {

  /**
   * The account switcher service.
   *
   * @var \Drupal\Core\Session\AccountSwitcherInterface
   */
  protected $accountSwitcher;

  /**
   * SimplesitemapCommands constructor.
   *
   * @param \Drupal\Core\Session\AccountSwitcherInterface $account_switcher
   *   The account switching service.
   */
  public function __construct(AccountSwitcherInterface $account_switcher) {
    $this->accountSwitcher = $account_switcher;
  }

  /**
   * Fire drush digest command.
   *
   * @usage drush send-digest 
   *   Send digest command.
   *
   * @command send-digest
   */
  public function sendDigest() {
    /** @var \Drupal\message_digest\DigestManagerInterface $digest_manager */
    // Switch to root user (--user option was removed from drush 9).
    $this->accountSwitcher->switchTo(new UserSession(['uid' => 1]));
message_digest_cron();
    /** @var \Drupal\message_digest\DigestManagerInterface $digest_manager */
/*    $digest_manager = \Drupal::service('message_digest.manager');
  
   // Process message digests.
    $digest_manager->processDigests();

    // Cleanup old messages.
    $digest_manager->cleanupOldMessages();
*/
    $this->accountSwitcher->switchBack();
  }
}
