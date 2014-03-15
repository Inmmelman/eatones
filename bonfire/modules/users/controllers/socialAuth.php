<?php


class SocialAuth extends Front_Controller{

    protected $user;

    protected $ip_address;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('users/user_model');
        $this->load->model('users/social_user_model');
        $this->load->library('users/auth');
        $this->load->config('fenix');
        $this->ip_address = $_SERVER['REMOTE_ADDR'];

    }
    public function auth(){
        include_once('application/libraries/SocialAuther/autoload.php');
        spl_autoload_register('autoloading');
        $adapterConfigs =  array('vk' => config_item('social.vk'),'facebook' => config_item('social.facebook'));

        foreach ($adapterConfigs as $adapter => $settings) {
            $class = 'SocialAuther\Adapter\\' . ucfirst($adapter);
            $adapters[$adapter] = new $class($settings);
        }

        $auther = new SocialAuther\SocialAuther($adapters[$_GET['provider']]);

        spl_autoload_unregister('autoloading');

        if($auther->authenticate()){
            $dataForSocialUser = array(
                'provider'=> $auther->getProvider(),
                'social_id' => $auther->getSocialId(),
                'name' => $auther->getName(),
                'email' => $auther->getEmail(),
                'social_page' => $auther->getSocialPage(),
                'sex' => $auther->getSex(),
                'birthday'=> date('Y-m-d', strtotime($auther->getBirthday())),
                'avatar' => $auther->getAvatar()
            );


            $issetUser = $this->auth->checkUser($auther->getSocialId());

            if(!$issetUser){
                $_userEmail = $auther->getEmail()? $auther->getEmail() :$auther->getSocialPage() ;
                $dataForCommonUser = array(
                    'email'			=> $_userEmail,
                    'display_name'	=> $auther->getName(),
                    'username'	=> $auther->getName(),
                    'type_id'       => 1,
                    'password_iterations' => 8,
                    'social_auth'   => 1

                );
                $newUserId = $this->user_model->insert($dataForCommonUser);
                if($newUserId){
                    $dataForSocialUser['id'] = $newUserId;
                    $this->social_user_model->insert($dataForSocialUser);
                }
            }else{
                $dataForSocialUser['id'] = $issetUser->id;
            }

            $this->user = new stdClass();
            $this->user->id = $dataForSocialUser['id'];
            $this->user->username = $dataForSocialUser['name'];
            $this->user->social_id = $dataForSocialUser['social_id'];
            $this->socialLogin();

        }else{
            die('auth fail');
        }
        header("location:/index.php");
    }


    public function socialLogin(){
                            //$user_id, $username, $password_hash, $email, $role_id, $remember=FALSE, $old_token=NULL,$user_name=''
        $this->auth->setup_session($this->user->id, $this->user->username,  '',$this->user->social_id,4,'','', $this->user->username);

        // Save the login info
        $data = array(
            'last_login'			=> date('Y-m-d H:i:s', time()),
            'last_ip'				=> $this->ip_address,
        );
        $this->user_model->update($this->user->id, $data);

        // Clear the cached result of user() (and hence is_logged_in(), user_id() etc).
        // Doesn't fix `$this->current_user` in controller (for this page load)...


        //log_activity($this->auth->user_id(), lang('us_log_logged') . ': ' . $this->input->ip_address(), 'users');
    }
}