<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * @author     NipIgniter <hanif@nipstudio.com>
 * @copyright  2014 NipStudio.com
 * @version    2.0
 * @link       http://nipstudio.com
 */
class ProfileController extends Nip_Controller
{

    /**
     * Page title will be shown in the layout
     *
     * @var string
     * @access public
     */
    public $pageTitle = "Profile Page";

    /**
     * Layout file in the views folder
     *
     * @var string
     * @access public
     */
    public $pageLayout = "layouts/main";

    /**
     * Message response for ajax request
     *
     * @var mix
     * @access public
     */
    public $msg = array(
        "success" => array(
            "status" => 1,
            "message" => "Success",
            "param" => "success",
        ),
        "failed" => array(
            "status" => 2,
            "message" => "Failed",
            "param" => "danger",
        ),
        "invalid" => array(
            "status" => 3,
            "message" => "Invalid",
            "param" => "warning",
        ),
    );

    /**
     * This method is used for authentication.
     * Check session login based on user_id and role_id.
     * You must have user table and role table.
     *
     * @param string     $method
     * @param mix         $params
     *
     * @return void
     *
     * @access public
     */
    public function _remap($method, $params = array())
    {

        $roleId = $this->session->userdata('role_id');
        $userId = $this->session->userdata('user_id');

        if (!empty($roleId) && !empty($userId)) {

            if (method_exists($this, $method)) {
                return call_user_func_array(array($this, $method), $params);
            }
        }

        show_404();
        return;
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Auth");
    }

    public function index()
    {
        $data['model'] = $this->Auth->user();
        $this->render($this->view, $data);
    }

    public function edit()
    {
        $model = $this->Auth->user();

        if (isset($_POST["User"])) {
            $fields = $_POST["User"];

            unset($fields['status_id']);
            unset($fields['role_id']);
            unset($fields['username']);

            $model->attr($fields);

            $password = $this->input->post("password");
            $rawpassword = $password;

            if (!empty($password)) {
                $password = sha1($password);
                $model->password = $password;
            }

            if ($model->validate()) {
                if (empty($model->password)) {
                    $this->msg['invalid']['message'] = "The Password field is required.";
                    echo json_encode($this->msg['invalid']);
                    exit();
                }

                if (!empty($_FILES['picture']['name'])) {
                    $this->load->library('upload');

                    $folder = './public/uploads/';

                    $config['upload_path'] = $folder;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '10000';

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('picture')) {
                        $this->msg['failed']['message'] = $this->upload->display_errors();
                        echo json_encode($this->msg['failed']);
                        exit();
                    } else {
                        $data = $this->upload->data();
                        $model->picture = $folder . $data['file_name'];

                        $isCreateThumb = false;
                        $isCrop = true;

                        //if with cropping
                        if ($isCrop) {
                            $scaleWidth = 400;
                            $scaleHeight = 400;

                            $callback = isset($_POST['callback'])
                            ? $_POST['callback'] : null;

                            $this->msg['success']['crop'] = $this->crop($model->picture, $callback, $isCreateThumb, $scaleWidth, $scaleHeight);
                        }
                    }
                }

                if ($model->save()) {
                    echo json_encode($this->msg['success']);
                } else {
                    echo json_encode($this->msg['failed']);
                }

                exit();
            } else {
                $this->msg['invalid']['message'] = $model->messageArray();
                echo json_encode($this->msg['invalid']);
                exit();
            }
        }

        $data['model'] = $model;
        $data["callback"] = !empty($_SERVER['HTTP_REFERER'])
        ? $_SERVER['HTTP_REFERER'] : site_url($this->controller);
        $this->render("profile/edit", $data);
    }

}
