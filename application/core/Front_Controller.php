<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Front Controller
 *
 * This class provides a common place to handle any tasks that need to
 * be done for all public-facing controllers.
 *
 * @package    Bonfire\Core\Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Front_Controller extends Base_Controller
{

    //--------------------------------------------------------------------

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        Events::trigger('before_front_controller');

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->library('template');
        $this->load->library('blocks');
        $this->load->library('assets');
        $this->load->model('shebang_model');
        $this->set_current_user();
        Template::set('user_id',isset($this->current_user->id) ?$this->current_user->id : false);

        Events::trigger('after_front_controller');
    }//end __construct()

    //--------------------------------------------------------------------

}

/* End of file Front_Controller.php */
/* Location: ./application/core/Front_Controller.php */