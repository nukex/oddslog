<?php
declare(strict_types=1);
use Phalcon\Http\Response;
use Phalcon\Encryption\Security;
use Phalcon\Html\Escaper;


class UserController extends ControllerBase {





    public function dashboardAction()
    {


        $this->setMetadata([    
            'title'      => 'Dashboard - OddsLog.com',
            'desc'       => 'Account Dashboard' ,
        ]) ;
    }

    public function logoutAction()
    {
        setcookie("login", '');
        setcookie("crc", '');

      
        header("Location: /"); 
        exit;
    }



    //reg user
    public function signupAction()
    {
        header('Content-Type: application/json'); 
        if ($this->request->getJsonRawBody()) {

            $post = $this->request->getJsonRawBody();


            // check valid passwd
            if (strlen($post->password) < 6 ) {
                json(['status'=>'error', 'message' =>'Minimum password length is 6 characters' ]);
            }

            if ( isset($_COOKIE['code']) && $post->captcha != cryptStr ($_COOKIE['code'], false)) {

                json(['status'=>'error', 'message' =>'Incorrect captcha code <p>Please try again! ']);
            } 

                // check uniq email
                $users = Users::findFirst(
                    [
                        'conditions' => ' email = :email:',
                        'bind' => [
                            'email' => $post->email,
                            ]
                    ]);


                if (!isset($users->email)) {

                    $cryptPasswd = hash('ripemd128', $this->Salt  . $post->password  );

                    $user = new Users();
                    $user -> assign(
                        [
                            'role'        => 1,  // 1- user , 0- admin
                            'username'    => strstr( $post->email, '@', true),
                            'email'       =>  $post->email,
                            'password'    => $cryptPasswd ,
                            'regdate'     => date('Y-m-d H:i:s', time()),
                            'lastvisit'   => date('Y-m-d H:i:s', time()),
                            'profile'     => getEmptyProfile(),
                            'auth'        => 'site',
                            'status'      => 0,
                            'premium'     => null,
                            
                    
                        ]
                    ); 
                    $result = $user->create();

                    $this->setCryptCookies( $post->email, $cryptPasswd);
                  
                    unset($_COOKIE['code']); 
                    setcookie('code', '', -1, '/'); 


                    $send =    sendEmail ($post->email, 'activate');

                    json(['status'=>'success', 'message' =>'Your registration is successful! 
                                                 <p>Please click the activation link we sent to your email',
                         'action' => 'reload' ]);

                } else {

                    json(['status'=>'error', 'message' =>'Email already taken!' ]);
                }

        }
    }


    //SignIn - Login
    public function signinAction()
    {
        header('Content-Type: application/json'); 

        $post = $this->request->getJsonRawBody();

     
        // if ($this->request->isPost()) {
        //     if ($this->security->checkToken()) {
        if ( isset($_COOKIE['code']) && $post->captcha != cryptStr ($_COOKIE['code'], false)) {

            json(['status'=>'error', 'message' =>'Incorrect captcha code <p>Please try again! ']);
        } 

        $cryptPasswd =  hash('ripemd128', $this->Salt  . $post->password );

        $user = Users::findFirst(
            [
                'conditions' => 'email = :email: AND password  = :passwd:',
                'bind' => [
                    'email' => $post->email,
                    'passwd'=> $cryptPasswd

                    ]
            ]);
            
        // ok
        if (isset($user->role)) {
    
            $this->setCryptCookies($post->email, $cryptPasswd, );
            json(['status'=>'success', 'message' =>'You have successfully logged in to the site' , 
                    'action' => 'reload']);
        
        } 
        else {
            json(['status'=>'error', 'message' =>'Wrong Email or Password' ]);
        
        }

    }


    //signin form

    public function signinFormAction()
    {
        $this->view->setRenderLevel( \Phalcon\Mvc\View::LEVEL_ACTION_VIEW );
        $this->view->pick('form/signin');

    }


      //Reset Password 

      public function resetPasswordPostAction()
      {
         
        header('Content-Type: application/json'); 
        if ($this->request->getJsonRawBody()) {

            $post = $this->request->getJsonRawBody();


            if ( isset($_COOKIE['code']) && $post->captcha != cryptStr ($_COOKIE['code'],false)) {
                json(['status'=>'error', 'message' =>'Incorrent Captcha Code! <p>Please try again! ']);
            } 
            $user = Users::findFirst(
                [
                    'conditions' => 'email = :email: ',
                    'bind' => [
                        'email' => $post->email
                        ]
                ]);


            if (isset($user->email)) {

                $send =    sendEmail ($user->email, 'reset');

                if ($send) {
                    json(['status'=>'success', 'message' =>'Your reset password email is heading your way.']);
                } else {
                    json(['status'=>'error', 'message' =>'Error sending email']);
                }
            }
            else {
                json(['status'=>'error', 'message' =>'Email not found']);
            }
        }
      }

      public function resetPasswordAction()
      {
         
        $this->setMetadata([    
            'title'      => 'Reset password',
            'desc'       => 'Reset password' ,
            // 'canonical'     => "/posts/" . $post->slug,
        ]) ;
  
      }
      public function changePasswordAction()
      {

        $key   = base64_decode ( $this->request->getQuery('key'));
        $crc   = $this->request->getQuery('crc');

        if (hash('ripemd128', $key) === $crc) {

            list($time, $email) = explode(':', $key);
            
            $email = cryptStr($email, false);

            if ( (time() - $time) < 3600 * 12 ) {
                // POST
                if (true === $this->request->isPost()) {
               
                    if ( isset($_COOKIE['code']) && $this->request->getPost('captcha') === cryptStr ($_COOKIE['code'],false)) {
                        $user = Users::findFirst(
                            [
                                'conditions' => 'email = :email: ',
                                'bind' => ['email' => $email]
                            ]);
                        $user->password = hash('ripemd128', $this->Salt . $this->request->getPost('password'));
                        $user->update();    

                        $this->view->alert = alert('success','Your password has been changed.' ); 
                    } else {
                        $this->view->alert =  alert('error','Incorrect captcha code' ); 
                    }
                }
                
                

                $this->view->time = time() - $time;
                $this->view->keyValid = true;
            }  

            else {
                $this->view->keyValid = false;
            }

        } else {
            $this->view->keyValid = false;
        }

        $this->setMetadata([    
            'title'      => 'Change password',
            'desc'       => 'Change password' ,
            // 'canonical'     => "/posts/" . $post->slug,
        ]) ;
  
      }


      public function activateAction()
      {

        $key   = base64_decode ( $this->request->getQuery('key'));
        $crc   = $this->request->getQuery('crc');

        if (hash('ripemd128', $key) === $crc) {

            list($time, $email) = explode(':', $key);
            
            $email = cryptStr($email, false);

            if ( (time() - $time) < 3600 * 24 ) {

                $user = Users::findFirst(
                    [
                        'conditions' => 'email = :email: ',
                        'bind' => ['email' => $email]
                    ]);
                $user->status = 1;
                $user->update();   

                $this->view->keyValid = true;
    
            } 
            else {
                $this->view->keyValid = false;
            }

        } 
        
        else {
            $this->view->keyValid = false;
        }

        $this->setMetadata([    
            'title'      => 'Account Activation',
            'desc'       => 'Account Activation' ,
        ]) ;

      
      }
      

}

