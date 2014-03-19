<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2013, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Users Controller
 *
 * Provides front-end functions for users, like login and logout.
 *
 * @package    Bonfire
 * @subpackage Modules_Users
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://cibonfire.com
 *
 */
class Shebang extends Front_Controller
{

    protected $default_avatar = "http://www.murketing.com/journal/wp-content/uploads/2009/04/vimeo.jpg";

    protected $avatar_size = 40;
	//--------------------------------------------------------------------

	/**
	 * Setup the required libraries etc
	 *
	 * @retun void
	 */
	public function __construct()
	{

		parent::__construct();
        $this->load->model('users/user_model');
		$this->load->model('shebang/shebang_user_model');
		$this->load->model('shebang/shebang_event_model');
		$this->load->library('users/auth');
        $this->load->config('fenix');
		$this->lang->load('users');
		$this->load->helper('encoded');

	}//end __construct()


	//--------------------------------------------------------------------

	/**
	 * Allows a user to edit their own profile information.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function profile()
	{
		// Make sure we're logged in.
		$this->auth->restrict();
		$this->set_current_user();

		$this->load->helper('date');

		$this->load->config('address');
		$this->load->helper('address');

		$this->load->config('user_meta');
		$meta_fields = config_item('user_meta_fields');

		Template::set('meta_fields', $meta_fields);

		// get the current user information
		$user = $this->user_model->find_user_and_meta($this->current_user->id);

		Template::set('user', $user);
		Template::set('languages', unserialize($this->settings_lib->item('site.languages')));


       /* Template::set_view('users/users/profile_menu');
        $user_menu = Template::content();

        Template::set('user_menu',$user_menu);*/

		Template::set_view('shebang/users/profile');
		Template::render();

	}//end profile()


    /*
     *
     * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     *  TODO :: ПРОВЕРКА ВХОДЯЩЕЙ ХУЙНИ!!!!!!!!!!!!!!!!!
     * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     *
     */
    public function index($shebangId){

        $this->auth->restrict();
        $this->set_current_user();

        $this->load->helper('date');

        $this->load->config('address');
        $this->load->helper('address');


        $shebangUserData = $this->shebang_user_model->getShebangById($shebangId);


      //  Template::set_block('buttons_owner','/views/blocks/buttons_owner');

        Template::set('shebang', $shebangUserData);
        Template::set_view('shebang/users/main_page');
        Template::render();
    }

    public function edit(){
        $this->auth->restrict();
        $this->set_current_user();

        $this->load->helper('date');

        $this->load->config('address');
        $this->load->helper('address');

        $this->load->config('user_meta');
        $meta_fields = config_item('user_meta_fields');

        Template::set('meta_fields', $meta_fields);

        if (isset($_POST['save']))
        {

            $user_id = $this->current_user->id;
            if ($this->save_user($user_id, $meta_fields))
            {

                $meta_data = array();
                foreach ($meta_fields as $field)
                {
                    if ((!isset($field['admin_only']) || $field['admin_only'] === FALSE
                            || (isset($field['admin_only']) && $field['admin_only'] === TRUE
                                && isset($this->current_user) && $this->current_user->role_id == 1))
                        && (!isset($field['frontend']) || $field['frontend'] === TRUE)
                        && $this->input->post($field['name']) !== FALSE)
                    {
                        $meta_data[$field['name']] = $this->input->post($field['name']);
                    }
                }

                // now add the meta is there is meta data
                $this->user_model->save_meta_for($user_id, $meta_data);

                // Log the Activity

                $user = $this->user_model->find($user_id);
                $log_name = (isset($user->display_name) && !empty($user->display_name)) ? $user->display_name : ($this->settings_lib->item('auth.use_usernames') ? $user->username : $user->email);
                log_activity($this->current_user->id, lang('us_log_edit_profile') . ': ' . $log_name, 'users');

                Template::set_message(lang('us_profile_updated_success'), 'success');

                // redirect to make sure any language changes are picked up
                Template::redirect('/users/profile');
            }
            else
            {
                Template::set_message(lang('us_profile_updated_error'), 'error');
            }//end if
        }//end if

        // get the current user information
        $user = $this->user_model->find_user_and_meta($this->current_user->id);

        $settings = $this->settings_lib->find_all();
        if ($settings['auth.password_show_labels'] == 1) {
            Assets::add_module_js('users','password_strength.js');
            Assets::add_module_js('users','jquery.strength.js');
            Assets::add_js($this->load->view('users_js', array('settings'=>$settings), true), 'inline');
        }
        // Generate password hint messages.
        $this->user_model->password_hints();

        Template::set('user', $user);
        Template::set('languages', unserialize($this->settings_lib->item('site.languages')));
        Template::set_view('users/users/profile_menu');
        $user_menu = Template::content();
        Template::set('user_menu',$user_menu);

        Template::set_view('users/users/profile_edit');
        Template::render();
    }

	//--------------------------------------------------------------------

	/**
	 * Save the user
	 *
	 * @access private
	 *
	 * @param int   $id          The id of the user in the case of an edit operation
	 * @param array $meta_fields Array of meta fields fur the user
	 *
	 * @return bool
	 */
	private function save_user($id=0, $meta_fields=array())
	{

		if ( $id == 0 )
		{
			$id = $this->current_user->id; /* ( $this->input->post('id') > 0 ) ? $this->input->post('id') :  */
		}

		$_POST['id'] = $id;

		// Simple check to make the posted id is equal to the current user's id, minor security check
		if ( $_POST['id'] != $this->current_user->id )
		{
			$this->form_validation->set_message('email', 'lang:us_invalid_userid');
			return FALSE;
		}

		// Setting the payload for Events system.
		$payload = array ( 'user_id' => $id, 'data' => $this->input->post() );


		$this->form_validation->set_rules('email', 'lang:bf_email', 'required|trim|valid_email|max_length[120]|unique[users.email,users.id]');
		$this->form_validation->set_rules('password', 'lang:bf_password', 'max_length[120]|valid_password');

		// check if a value has been entered for the password - if so then the pass_confirm is required
		// if you don't set it as "required" the pass_confirm field could be left blank and the form validation would still pass
		$extra_rules = !empty($_POST['password']) ? 'required|' : '';
		$this->form_validation->set_rules('pass_confirm', 'lang:bf_password_confirm', ''.$extra_rules.'matches[password]');

		$username_required = '';
		if ($this->settings_lib->item('auth.login_type') == 'username' ||
		    $this->settings_lib->item('auth.use_usernames'))
		{
			$username_required = 'required|';
		}
		$this->form_validation->set_rules('username', 'lang:bf_username', $username_required . 'trim|max_length[30]|unique[users.username,users.id]');

		$this->form_validation->set_rules('language', 'lang:bf_language', 'required|trim');
		$this->form_validation->set_rules('timezones', 'lang:bf_timezone', 'required|trim|max_length[4]');
		$this->form_validation->set_rules('display_name', 'lang:bf_display_name', 'trim|max_length[255]');

		// Added Event "before_user_validation" to run before the form validation
		Events::trigger('before_user_validation', $payload );


		foreach ($meta_fields as $field)
		{
			if ((!isset($field['admin_only']) || $field['admin_only'] === FALSE
				|| (isset($field['admin_only']) && $field['admin_only'] === TRUE
					&& isset($this->current_user) && $this->current_user->role_id == 1))
				&& (!isset($field['frontend']) || $field['frontend'] === TRUE))
			{
				$this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
			}
		}


		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// Compile our core user elements to save.
		$data = array(
			'email'		=> $this->input->post('email'),
			'language'	=> $this->input->post('language'),
			'timezone'	=> $this->input->post('timezones'),
		);

		// If empty, the password will be left unchanged.
		if ($this->input->post('password') !== '')
		{
			$data['password'] = $this->input->post('password');
		}

		if ($this->input->post('display_name') !== '')
		{
			$data['display_name'] = $this->input->post('display_name');
		}

		if (isset($_POST['username']))
		{
			$data['username'] = $this->input->post('username');
		}

		// Any modules needing to save data?
		// Event to run after saving a user
		Events::trigger('save_user', $payload );

		return $this->user_model->update($id, $data);

	}//end save_user()

    public function add_event(){

        $eventParams = array();
        parse_str($_POST['params'], $eventParams);

        if(empty($eventParams)  && !is_array($eventParams)){
            echo 'fail';
            die();
        }

        $shebangEvent = new Shebang_event_model();
        $result = $shebangEvent->insert($eventParams);

        echo $result;

    }

    public function load_poster(){

    }

}//end Users

/* Front-end Users Controller */
/* End of file users.php */
