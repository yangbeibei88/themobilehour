<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorize
{

  /**
   * Check if a admin user is authenticated
   * 
   * @return bool
   */
  public function isAdminAuthenticated()
  {
    return Session::has('adminUser');
  }
  /**
   * Check if a customer user is authenticated
   * 
   * @return bool
   */
  public function isCustomerAuthenticated()
  {
    return Session::has('customerUser');
  }

  public function getAdminRole()
  {
    return Session::get('adminUser')['role'];
  }



  /**
   * Handle the user's request
   *
   * @param string $role
   * @return bool
   */
  public function handle($role)
  {

    if ($role === 'guest' && $this->isCustomerAuthenticated()) {
      // if the route is meant to be for guest, but customer user is logged in, prevent logged in customer access to guest pages
      return redirect(assetPath('customer/dashboard'));
    } elseif ($role === 'guest' && $this->isAdminAuthenticated()) {
      return redirect(assetPath('admin/dashboard'));
    } elseif ($role === 'authSuperAdmin' && ($this->isAdminAuthenticated() && $this->getAdminRole() === 'Admin')) {
      return redirect(assetPath('admin/dashboard'));
    } elseif ($role === 'authCustomer' && !$this->isCustomerAuthenticated()) {
      // if the route is meant to be for logged-in customer, prevent guest to access
      return redirect(assetPath('customer/auth/login'));
    } elseif ($role === 'authAdmin' && !$this->isAdminAuthenticated()) {
      // if the route is meant to be for logged-in admin, prevent guest to access
      return redirect(assetPath('admin/auth/login'));
    }
  }
}
