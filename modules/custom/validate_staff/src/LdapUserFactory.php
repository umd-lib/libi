<?php

namespace Drupal\validate_staff;

use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\ldap_servers\ServerFactory;

/**
 * Helper class for retrieving and parsing out user data from Ldap attributes
 *
 * Intended to eventually expand into Grouper data.
 */
class LdapUserFactory {

  public $user;
  public $libraryEmployee;
  protected $serverID;
  protected $uid;
  protected $factory;
  protected $logger;

  /**
   * Constructor.
   */
  public function __construct(ServerFactory $factory, LoggerChannelInterface $logger) {
    $this->factory = $factory;
    $this->logger = $logger;
  }

  /**
   * Load user via LDAP.
   */
  public function setUser($uid, $serverID) {
    $this->serverID = $serverID;
    $this->uid = $uid;
    if ($user = $this->factory->getUserDataFromServerByIdentifier($uid, $serverID)) {
      $this->user = $user;
      $this->libraryEmployee = $this->isLibraryEmployee();
    } else {
      $this->logger->error('Failed to load user object from %uid in LdapUserFactory', ['%uid' => $this->uid]);
      return FALSE;
    }
  }

  /**
   * Simple method to determine if a user is a library employee.
   */
  public function isLibraryEmployee() {
    $dn = $this->getValue('umdepartment');
    if (is_array($dn)) {
      return $this->valueExistsFuzzy($dn, 'libr-') ? TRUE : FALSE;
    }
    return stripos($dn, 'libr-') === FALSE ? FALSE : TRUE;
  }

  /**
   * Verify user is library faculty.
   * This presumes the user is not a GA.
   */
  public function isLibraryFaculty() {
    if ($this->libraryEmployee) {
      $value = $this->getValue('umfaculty');
      return $this->parseBool($value);
    }
    return FALSE;
  }

  /**
   * Verify user is library staff
   */
  public function isLibraryStaff() {
    if ($this->libraryEmployee) {
      $value = $this->getValue('umstaff');
      return $this->parseBool($value);
    }
    return FALSE;
  }

  /**
   * Verify user is library GA 
   */
  public function isLibraryGA() {
    if ($this->libraryEmployee) {
      $value = $this->getValue('umgraduateassistant');
      return $this->parseBool($value);
    }
    return FALSE;
  }

  /**
   * Verify user is library hourly student worker
   */
  public function isLibraryStudent() {
    if ($this->libraryEmployee) {
       $value = $this->getValue('umhourlystudentemployee');
       return $this->parseBool($value);
    }
    return FALSE;
  }

  /**
   * Verify user is a valid Libi user
   */
  public function isValidLibiUser() {
    if ($this->isLibraryStudent() ||
        $this->isLibraryFaculty() ||
        $this->isLibraryStaff() ||
        $this->isLibraryGA()) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Verify user is a valid Staff Blog user
   */
  public function isValidStaffBlogUser() {
    if (!$this->isLibraryStudent &&
         ($this->isLibraryGA() ||
          $this->isLibraryFaculty() ||
          $this->isLibraryStaff())
       ) {
      return TRUE;
    }
    return FALSE;
  }

  public function getAttr() {
    return empty($this->user['attr']) ? FALSE : $this->user['attr'];
  }

  public function getValue($key) {

    if (($attr = $this->getAttr()) && (array_key_exists($key, $attr))) { 
dsm($attr);
      $valueArray = $attr[$key];
      if (($count = $valueArray['count']) && ($count == 1)) {
        // If only one value, just return the string
        return isset($valueArray[0]) ? $valueArray[0] : $valueArray;
      } elseif ($count > 1) {
        // Count is unnecessary and can interfere with looping
        unset($valueArray['count']);
        return $valueArray;
      }
      // As a failsafe, just return the array as there should be data if we got this far.
      return $valueArray;
    }
    return FALSE;
  }

  public function valueExistsFuzzy($value, $pattern) {
    foreach ($value as $a => $b) {
      if (stripos($b, $pattern) !== FALSE) {
        return TRUE;
      }
    }
    return FALSE;
  }

  public function parseBool($value) {
    return strtolower($value) == 'true' ? TRUE : FALSE;
  }

}

