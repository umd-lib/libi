<?php

namespace Drupal\login_redirect_per_role;

/**
 * Interface defining Login Redirect Per Role helper service.
 */
interface LoginRedirectPerRoleInterface {

  /**
   * Checks is login redirect action applicable on current page.
   *
   * @return bool
   *   Result of check.
   */
  public function isApplicableOnCurrentPage();

  /**
   * Checks is "destination" URL parameter usage allowed.
   *
   * @return bool
   *   Result of check.
   */
  public function isDestinationAllowed();

  /**
   * Return URL to redirect to without applicability check.
   *
   * @return \Drupal\Core\Url|null
   *   URL to redirect to on success or NULL otherwise.
   */
  public function getUrl();

  /**
   * Return URL to redirect to with applicability check.
   *
   * @return \Drupal\Core\Url|null
   *
   *   URL to redirect to on success or NULL otherwise.
   */
  public function getRedirectUrl();

}
