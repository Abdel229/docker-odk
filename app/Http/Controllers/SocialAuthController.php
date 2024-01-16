<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\SocialAccountService;
use Socialite;

class SocialAuthController extends Controller
{
  // Redirect function
  public function redirect($provider)
  {
    return Socialite::driver($provider)->redirect();
  }
  // Callback function
  public function callback(SocialAccountService $service, Request $request, $provider)
  {

     //echo  $provider;
    // exit;
    try {
      $user = $service->createOrGetUser(Socialite::driver($provider)->user(), $provider);

      // Return Error missing Email User
      if (!isset($user->id)) {
        return $user;
      } else {
        auth()->login($user);
      }
    } catch (\Exception $e) {
        //dd($e);
      return redirect('login')->with(['login_required' => $e->getMessage()]);
    }

    return redirect()->to('/');
  } // End callback

}//<-- End Class
