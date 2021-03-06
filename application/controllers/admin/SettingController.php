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
class SettingController extends Nip_Controller
{

    /**
     * It will be show in the layout as title
     *
     * For example
     * <title>
     *         <?php echo $pageTitle;?>
     * </title>
     *
     * @var string
     * @access public
     */
    public $pageTitle = "Setting";

    /**
     * Controller folder name
     *
     * @var string
     * @access public
     */
    public $folder = 'admin';
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
     * This variable is an object for the main model in this controller
     *
     * $Model = new Setting();
     *
     * Usage :
     * $this->Model->first();
     * $this->Model->all();
     *
     * @var object
     * @access public
     */
    public $Model;

    /**
     * The default limit value for pagination
     *
     * @var integer
     * @access public
     */
    public $limit = 10;

    /**
     * Define the default where field.
     *
     * @var string
     * @access public
     */
    public $defaultWhere = "";
    public $defaultWhereArray = array();

    /**
     * In this function, we load some model for this controller
     * and create new object for the $Model variable
     *
     * @return void
     *
     * @access public
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model(
            array(
                'Setting',

            )
        );
        $this->Model = new Setting();
    }

    protected function getDefaultWhere()
    {
        $where = null;
        if (!empty($this->defaultWhere)) {
            parse_str($this->defaultWhere, $fields);

            if (!empty($fields)) {
                $array = array();
                foreach ($fields as $key => $val) {
                    $this->defaultWhereArray[] = $key;

                    $value = isset($_GET[$key]) ? $_GET[$key] : "";
                    $array[] = "{$key} = '{$value}'";
                }
                $where = implode(" AND ", $array);
            }
        }

        return $where;
    }

    protected function getSearchWhere()
    {
        $where = $this->getDefaultWhere();

        if (isset($_GET['search'])) {
            if (isset($_GET['keywords']) && isset($_GET['keyword'])) {
                if (!empty($where)) {
                    $where .= " AND ";
                }
                $keywords = $_GET['keywords'];
                $where .= $this->getSpecificWhere($keywords);
                $keyword = $_GET['keyword'];
                $where .= " AND " . $this->getWhere($keyword);
            } else if (isset($_GET['keywords'])) {
                if (!empty($where)) {
                    $where .= " AND ";
                }
                $keywords = $_GET['keywords'];
                $where .= $this->getSpecificWhere($keywords);
            } else if (isset($_GET['keyword'])) {
                if (!empty($where)) {
                    $where .= " AND ";
                }
                $keyword = $_GET['keyword'];
                $where .= $this->getWhere($keyword);
            }
        }

        return $where;
    }

    protected function getDefaultSorting()
    {
        $sorting = "title asc";
        if (isset($_GET['sorting'])) {
            if (!isset($_GET['direction'])) {
                $direction = "asc";
            } else {
                $direction = $_GET['direction'];
            }

            $sorting = $_GET['sorting'] . " " . $direction;
        }

        return $sorting;
    }

    /**
     * This action is used to show index, pagination and search page
     *
     * @param integer     $limit pagination limit
     * @param integer     $offset
     *
     * @return void
     *
     * @access public
     */
    public function index($limit = null, $offset = 0)
    {
        $where = $this->getSearchWhere();
        $sorting = $this->getDefaultSorting();

        $this->limit = !empty($limit) ? $limit : $this->limit;
        $baseUrl = site_url("{$this->pathController}/index/{$this->limit}");

        $rows = $this->Model->all(
            array(
                'where' => $where,
                'limit' => $this->limit,
                'offset' => $offset,
                'order_by' => $sorting,
            )
        );

        $total = $this->Model->count($where);

        $pagination = $this->paginate($baseUrl, $total, $this->limit, $offset);

        $data['rows'] = $rows;
        $data['offset'] = $offset;
        $data['limit'] = $this->limit;
        $data['pagination'] = $pagination;

        if ($this->input->is_ajax_request()) {
            $view = $this->renderPartial("{$this->pathController}/page", $data, true);

            echo json_encode(array(
                'pagination' => $pagination,
                'view' => $view,
            )
            );
        } else {
            if (isset($_GET['download'])) {
                $this->load->library(array("dompdflib", "spreadsheet"));

                if ($_GET['download'] == "excel") {

                    $field = array('id', 'title');

                    $this->spreadsheet->send("Setting spreadsheet.xls");

                    //head
                    foreach ($field as $value) {
                        $this->spreadsheet->write(getLabel($value));
                    }

                    echo "\n";

                    //body
                    foreach ($rows as $object) {
                        foreach ($object as $key => $value) {
                            if (in_array($key, $field)) {
                                $this->spreadsheet->write($value);
                            }
                        }
                        echo "\n";
                    }

                } else {

                    $this->pageLayout = "layouts/print";

                    $view = $this->render("{$this->pathController}/index", $data, true);

                    $this->dompdflib->generate($view, "Setting report.pdf");
                }
            } else {
                $this->render($this->view, $data);
            }
        }
    }

    /**
     * This action is used to create new record or edit it based on primary key
     *
     * @param integer     $id primary key for the current model
     *
     * @return void
     *
     * @access public
     */
    public function edit($id = null)
    {
        if (empty($id)) {
            $model = new $this->Model();
        } else {
            $model = $this->Model->first(array("id" => $id));
        }

        if (isset($_POST["Setting"])) {
            $this->load->library('upload');

            $fields = $_POST["Setting"];
            $model->attr($fields);

            if (!empty($_FILES['file']['name'])) {

                $folder = "./public/uploads/" . strtolower("{$this->Model}/");

                if (!is_dir($folder)) {
                    mkdir($folder);
                }

                $config['upload_path'] = $folder;
                $config['allowed_types'] = '*';
                $config['max_size'] = '100000';

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('file')) {
                    $this->msg['failed']['message'] = $this->upload->display_errors();
                    echo json_encode($this->msg['failed']);
                    exit();
                } else {
                    $data = $this->upload->data();
                    $model->value = $folder . $data['file_name'];
                }
            }

            if ($model->validate()) {

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

        $data["id"] = $id;
        $data["model"] = $model;
        $data["callback"] = !empty($_SERVER['HTTP_REFERER'])
        ? $_SERVER['HTTP_REFERER'] : site_url($this->pathController) . $this->queryString;

        $this->render("{$this->pathController}/edit", $data);
    }

    /**
     * This action is used to show a data details.
     *
     * @param integer     $id primary key for the current model
     *
     * @return void
     *
     * @access public
     */
    public function view($id)
    {
        $model = $this->Model->first(array("id" => $id));

        $data['model'] = $model;
        if ($this->input->is_ajax_request()) {
            $this->renderPartial("{$this->pathController}/view", $data);
        } else {
            $this->render("{$this->pathController}/view", $data);
        }
    }

    /**
     * This action is used to delete a data based on primary key
     *
     * @return void
     *
     * @access public
     */
    public function delete()
    {
        if (!isset($_POST["id"])) { // id as primary key
            return;
        }

        $id = $_POST["id"];
        $result = $this->Model->delete($id);

        if ($result) {
            $this->msg['success']['operation'] = 'delete';
            if ($this->Model->getSoftDeletes()) {
                $this->msg['success']['message'] = 'Data has been successfully removed. <button class="btn-action btn btn-warning btn-xs" data-id="' . $id . '" data-url="' . site_url("{$this->pathController}/restore") . $this->queryString . '">Undo</button> if this action is a mistake.';
            } else {
                $this->msg['success']['message'] = 'Data has been successfully removed.';
            }
            echo json_encode($this->msg['success']);
            exit();
        }

        echo json_encode($this->msg['failed']);
    }

    /**
     * This action is used to remove all checked data in the grid
     *
     * @return void
     *
     * @access public
     */
    public function moveToTrash()
    {
        if (!isset($_POST['primary'])) {
            return;
        }

        $primaries = $_POST['primary'];

        if (count($primaries) > 0) {
            foreach ($primaries as $value) {
                $this->Model->delete($value);
            }

            $this->msg['success']['message'] = "Data has been successfully removed.";
            echo json_encode($this->msg['success']);
        } else {
            $this->msg['failed']['message'] = "Please check the data first.";
            echo json_encode($this->msg['failed']);
        }

    }

    /**
     * This action is used to restore a data based on primary key
     *
     * @return void
     *
     * @access public
     */
    public function restore($from = "list")
    {
        if (!isset($_POST["id"])) { // id as primary key
            return;
        }

        $id = $_POST["id"];
        $result = $this->Model->restore($id);

        if ($result) {
            $this->msg['success']['operation'] = 'restore';
            if ($from == "trash") {
                $this->msg['success']['operation'] = 'delete';
            }
            $this->msg['success']['message'] = 'Data has been successfully restored';
            echo json_encode($this->msg['success']);
            exit();
        }

        echo json_encode($this->msg['failed']);
    }

    /**
     * This action is used to show a trash data
     *
     * @param integer     $limit pagination limit
     * @param integer     $offset
     *
     * @return void
     *
     * @access public
     */
    public function trash($limit = null, $offset = 0)
    {
        $where = $this->getSearchWhere();
        $sorting = $this->getDefaultSorting();

        $this->limit = !empty($limit) ? $limit : $this->limit;
        $baseUrl = site_url("{$this->pathController}/index/{$this->limit}");

        $rows = $this->Model->justTrash()->all(
            array(
                'where' => $where,
                'limit' => $this->limit,
                'offset' => $offset,
                'order_by' => $sorting,
            )
        );

        $total = $this->Model->count($where);

        $pagination = $this->paginate($baseUrl, $total, $this->limit, $offset);

        $data['rows'] = $rows;
        $data['offset'] = $offset;
        $data['limit'] = $this->limit;
        $data['pagination'] = $pagination;
        $data["callback"] = !empty($_SERVER['HTTP_REFERER'])
        ? $_SERVER['HTTP_REFERER'] : site_url($this->controller);

        if ($this->input->is_ajax_request()) {
            $view = $this->renderPartial("{$this->pathController}/page", $data, true);

            echo json_encode(array(
                'pagination' => $pagination,
                'view' => $view,
            )
            );
        } else {
            $this->render("{$this->pathController}/trash/index", $data);
        }
    }

    /**
     * This action is used to delete a data based on primary key
     *
     * @return void
     *
     * @access public
     */
    public function forceDelete()
    {
        if (!isset($_POST["id"])) { // id as primary key
            return;
        }

        $id = $_POST["id"];
        $result = $this->Model->forceDelete($id);

        if ($result) {
            $this->msg['success']['operation'] = "delete";
            $this->msg['success']['message'] = 'Data has been successfully removed.';
            echo json_encode($this->msg['success']);
            exit();
        }

        echo json_encode($this->msg['failed']);
    }

    /**
     * This action is used to restore all checked data in the grid
     *
     * @return void
     *
     * @access public
     */
    public function restoreTrash()
    {
        if (!isset($_POST['primary'])) {
            return;
        }

        $primaries = $_POST['primary'];

        if (count($primaries) > 0) {
            foreach ($primaries as $value) {
                $this->Model->restore($value);
            }

            $this->msg['success']['message'] = "Data has been successfully restored";
            echo json_encode($this->msg['success']);
        } else {
            $this->msg['failed']['message'] = "Please check the data first.";
            echo json_encode($this->msg['failed']);
        }

    }

    /**
     * This action is used to remove permanently all checked data in the grid
     *
     * @return void
     *
     * @access public
     */
    public function deletePermanently()
    {
        if (!isset($_POST['primary'])) {
            return;
        }

        $primaries = $_POST['primary'];

        if (count($primaries) > 0) {
            foreach ($primaries as $value) {
                $this->Model->forceDelete($value);
            }

            $this->msg['success']['message'] = "Data has been permanently removed.";
            echo json_encode($this->msg['success']);
        } else {
            $this->msg['failed']['message'] = "Please check the data first.";
            echo json_encode($this->msg['failed']);
        }

    }

    /**
     * This action is used to show image that will be cropped
     *
     * @return string
     *
     * @access public
     */
    public function crop($path = null, $redirectUrl = null, $isThumb = false,
        $scaleWidth = 1, $scaleHeight = 1) {

        return parent::crop($path, $redirectUrl, $isThumb,
            $scaleWidth, $scaleHeight);
    }

    /**
     * Cropping process here
     *
     * @return void
     *
     * @access public
     */
    public function submitCrop()
    {
        parent::submitCrop();
    }

}
