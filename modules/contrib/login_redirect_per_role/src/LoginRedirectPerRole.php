<?php

namespace Drupal\login_redirect_per_role;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Drupal\Core\Utility\Token;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Login Redirect Per Role helper service.
 */
class LoginRedirectPerRole implements LoginRedirectPerRoleInterface {

  /**
   * The currently active route match object.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $currentRouteMatch;

  /**
   * The currently active request object.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $currentRequest;

  /**
   * The login_redirect_per_role.redirecturlsettings config object.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * The current active user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The token service.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * Constructs a new Login Redirect Per Role service object.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $current_route_match
   *   The currently active route match object.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current active user.
   * @param \Drupal\Core\Utility\Token $token
   *   The token service.
   */
  public function __construct(RouteMatchInterface $current_route_match, RequestStack $request_stack, ConfigFactoryInterface $config_factory, AccountProxyInterface $current_user, Token $token) {
    $this->currentRouteMatch = $current_route_match;
    $this->currentRequest = $request_stack->getCurrentRequest();
    $this->config = $config_factory->get('login_redirect_per_role.redirecturlsettings');
    $this->currentUser = $current_user;
    $this->token = $token;
  }

  /**
   * {@inheritdoc}
   */
  public function isApplicableOnCurrentPage() {
    switch ($this->currentRouteMatch->getRouteName()) {

      case 'user.reset':
      case 'user.reset.login':
      case 'user.reset.form':
        return FALSE;

      default:
        return TRUE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function isDestinationAllowed() {
    return $this->config->get('allow_destination');
  }

  /**
   * {@inheritdoc}
   */
  public function getUrl() {

    $url = NULL;
    $user_roles = $this->currentUser->getRoles();

    if (count($user_roles) > 1 && $user_roles[0] == AccountProxyInterface::AUTHENTICATED_ROLE) {
      unset($user_roles[0]);
    }

    foreach ($user_roles as $role) {
      if (($string_url = $this->config->get('login_redirect_per_role_' . $role))) {
        $string_url = $this->token->replace($string_url);
        $url = Url::fromUserInput($string_url);
        break;
      }
    }

    if (!$url && ($string_url = $this->config->get('default_site_url'))) {
      $string_url = $this->token->replace($string_url);
      $url = Url::fromUserInput($string_url);
    }

    return $url;
  }

  /**
   * {@inheritdoc}
   */
  public function getRedirectUrl() {
    $url = NULL;

    if (!$this->isApplicableOnCurrentPage()) {
      return $url;
    }
    if ($this->isDestinationAllowed() && $this->currentRequest->query->get('destination')) {
      return $url;
    }

    return $this->getUrl();
  }

}
