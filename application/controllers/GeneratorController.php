<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author     NipIgniter <hanif@nipstudio.com>
 * @copyright  2014 NipStudio.com
 * @version    2.0
 * @link       http://nipstudio.com
 */
class GeneratorController extends Nip_Controller {

	public $pageTitle  = "Nip Igniter - CRUD Generator for CodeIgniter";
	public $pageLayout = "layouts/generator";

	public $msg = array(
			"success" => array(
				"status" => 1,
				"message" => "Success"
			),
			"failed" => array(
				"status" => 2,
				"message" => "Failed"
			)
		);

	protected $templateName = "lte-theme";

	/** Variable ini belum dipake*/
	public $commonTemplate = array(
			'text' => array(
				'title' => 'text',
				'path'  => 'form/text.php',
				'config'=> '#length'
			),
			'number' => array(
				'title' => 'number',
				'path'  => 'form/number.php',
				'config'=> '#length',
			),
			'password' => array(
				'title' => 'password',
				'path'  => 'form/password.php',
				'config'=> '',
			),
			'email' => array(
				'title' => 'email',
				'path'  => 'form/email.php',
				'config'=> '#length',
			),
			'date' => array(
				'title' => 'date',
				'path'  => 'form/date.php',
				'config'=> '',
			),
			'textarea' => array(
				'title' => 'textarea',
				'path'  => 'form/textarea.php',
				'config'=> '',
			),
			'ckeditor' => array(
				'title' => 'ckeditor',
				'path'  => 'form/ckeditor.php',
				'config'=> '',
			),
			'jqueryte' => array(
				'title' => 'jqueryte',
				'path'  => 'form/jqueryte.php',
				'config'=> '',
			),
			'image' => array(
				'title' => 'image',
				'path'  => 'form/image.php',
				'config'=> '#image,#filetype',
			),
			'thumbnail' => array(
				'title' => 'thumbnail',
				'path'  => '',
				'config'=> '',
			),
			'file' => array(
				'title' => 'file',
				'path'  => 'form/file.php',
				'config'=> '#filetype',
			),
		);
	
	/** Variable ini belum dipake*/
	public $belongsToTemplate = array(
			'select' => array(
				'title' => 'select',
				'path'  => 'form/select.php',
				'config'=> '#belongsto'
			),
			'radio' => array(
				'title' => 'radio',
				'path'  => 'form/radio.php',
				'config'=> '#belongsto',
			)
		);

	/** Variable ini belum dipake*/
	public $otherTemplate = array(
			'random' => array(
				'title' => 'random',
				'path'  => 'form/random.php',
				'config'=> '#random'
			)
		);

	public function __construct() {
		parent::__construct();

		$this->load->dbforge();
		$this->load->helper('directory');
	}
	
	public function index() {
		$this->render($this->view);
	}

	public function getTableList() {
		if (!$this->input->is_ajax_request()) {
			redirect("generator/index");
			return;
		}

		$tableList = $this->db->list_tables();
		echo json_encode($tableList);
	}

	public function manage() {
		$map = directory_map(APPPATH.'controllers');

		$array  = $this->_parseFolder("", $map);

		$data['controllerList'] = $array;
		$data['tableList'] = $this->db->list_tables();
		$this->render($this->view, $data);
	}

	public function deleteController() {
		if (!$this->input->is_ajax_request()) {
			redirect("generator/manage");
			return;
		}

		if(!isset($_POST['table_name'])){
			echo json_encode($this->msg['failed']);
			return;
		}

		$tableName  = $this->input->post("table_name");
		$folderName = $this->input->post("folder_name");
		$controllerName = $this->input->post("controller_name");
		$mode       = $this->input->post("mode");

		if (!$this->db->table_exists($tableName)) {
			$this->msg['failed']['message'] = "The table doesn't exists.";
			echo json_encode($this->msg['failed']);
			return;
		}

		$destinationView = str_replace("_", "-", $tableName);
		$modelGenerator  = new ModelGenerator();
		$result 		 = $modelGenerator->getConfiguration($tableName);

		if(!empty($folderName)){
			$folderName .= "/";
		}

		if ($mode == "only-crud") {
			deleteFolder(APPPATH . "controllers/" . $folderName . $controllerName);
			deleteFolder(APPPATH . "models/". $result["modelName"]. ".php");
			
			deleteFolder(APPPATH . "views/". $folderName . $destinationView);
			
			$this->msg['success']['message'] = "The CRUD files have successfully deleted.";
			echo json_encode($this->msg['success']);

		} else if($mode == "table-crud") {

			if ($this->dbforge->drop_table($tableName)) {
				deleteFolder(APPPATH . "controllers/" . $folderName . $controllerName);
				deleteFolder(APPPATH . "models/". $result["modelName"]. ".php");
				
				deleteFolder(APPPATH . "views/". $folderName . $destinationView);

				$this->msg['success']['message'] = "The ".$tableName." table and CRUD files have successfully deleted.";
				echo json_encode($this->msg['success']);
			}else{
				$this->msg['failed']['message'] = "Failed to delete the ".$tableName." table.";
				echo json_encode($this->msg['failed']);
			}
		}

		$this->setSideMenu();
		$this->clearFolder();
	}

	public function deleteTable() {
		if (!$this->input->is_ajax_request()) {
			redirect("generator/manage");
			return;
		}

		if(!isset($_POST['table_name'])){
			echo json_encode($this->msg['failed']);
			return;
		}

		$tableName  = $this->input->post("table_name");
		
		if (!$this->db->table_exists($tableName)) {
			$this->msg['failed']['message'] = "The table doesn't exists.";
			echo json_encode($this->msg['failed']);
			return;
		}

		if ($this->dbforge->drop_table($tableName)) {
			
			$this->msg['success']['message'] = "The ".$tableName." table have successfully deleted.";
			echo json_encode($this->msg['success']);
		}else{
			$this->msg['failed']['message'] = "Failed to delete the ".$tableName." table.";
			echo json_encode($this->msg['failed']);
		}
	}

	public function getSettings() {
		if (!isset($_POST['table_name'])) {
			return;
		}
		
		$tableName 	  = $_POST['table_name'];
		$isCrud 	  = isset($_POST['is_crud']) ? TRUE : FALSE;

		$isTimestamps = isset($_POST['is_timestamps']) ? TRUE : FALSE;
		$isSoftDelete = isset($_POST['is_softdelete']) ? TRUE : FALSE;

		$createdField = !empty($_POST['created_field']) 
						? $_POST['created_field'] : 'created';
		$updatedField = !empty($_POST['updated_field']) 
						? $_POST['updated_field'] : 'updated';
		$deletedField = !empty($_POST['deleted_field']) 
						? $_POST['deleted_field'] : 'deleted';

		$folderName   = !empty($_POST['folder_name']) 
						? $_POST['folder_name'] : '';

		$modelGenerator = new ModelGenerator();
		$result 		= $modelGenerator->getConfiguration(
								$tableName, $createdField, $updatedField, $deletedField
						  );

		if ($result['status'] != 1) {
			echo json_encode($result);
			return;
		}

		$result['title'] 	 	= $result['modelName']." Table";
		$result['tableName'] 	= $tableName;

		$result['isCrud'] 		= $isCrud;

		$result['isTimestamps'] = $isTimestamps;
		$result['isSoftDelete'] = $isSoftDelete;

		$result['createdField'] = $createdField;
		$result['updatedField'] = $updatedField;
		$result['deletedField'] = $deletedField;

		$result['folderName']   = $folderName;

		$result['listModel']    = $this->getListModel();

		$view = $this->renderPartial("generator/fields", $result, TRUE);

		$this->msg['success']['message'] = "";
		$this->msg['success']['view'] 	 = $view;
		echo json_encode($this->msg['success']);
	}

	public function submitConfiguration() {
		if (!isset($_POST['Field'])) {
			return;
		}
		
		$fields   = $_POST['Field'];
		$settings = $_POST['Settings'];
		
		$modelGenerator = new ModelGenerator();
		$crudGenerator  = new CrudGenerator();
		
		/* Generate Model */
		$result = $modelGenerator->generate($fields, $settings);
		
		if($settings['isCrud'] == 1){
			
			/* Generate CRUD */
			$result = $crudGenerator->generate($fields, $settings);
			if($result['status'] == 1){
				$this->setSideMenu();

				$this->msg['success']['message'] = "The CRUD is successfully generated.";
				echo json_encode($this->msg['success']);
			}else{
				$this->msg['failed']['message'] = $result['message'];
				echo json_encode($this->msg['failed']);
			}
		}else{
			if($result['status'] == 1){
				$this->msg['success']['message'] = "The Model is successfully created.";
				echo json_encode($this->msg['success']);
			}else{
				$this->msg['failed']['message'] = $result['message'];
				echo json_encode($this->msg['failed']);
			}
		}
	}

	public function getCreate(){
		if (!isset($_POST['table_name'])) {
			return;
		}
		
		$tableName 	  = $_POST['table_name'];
		$isCrud 	  = isset($_POST['is_crud']) ? TRUE : FALSE;

		$isTimestamps = isset($_POST['is_timestamps']) ? TRUE : FALSE;
		$isSoftDelete = isset($_POST['is_softdelete']) ? TRUE : FALSE;

		$createdField = !empty($_POST['created_field']) 
						? $_POST['created_field'] : 'created';
		$updatedField = !empty($_POST['updated_field']) 
						? $_POST['updated_field'] : 'updated';
		$deletedField = !empty($_POST['deleted_field']) 
						? $_POST['deleted_field'] : 'deleted';

		$folderName   = !empty($_POST['folder_name']) 
						? $_POST['folder_name'] : '';

		$modelGenerator = new ModelGenerator();
		$result 		= $modelGenerator->getConfiguration(
								$tableName, $createdField, $updatedField, $deletedField, "create"
						  );

		if ($result['status'] != 1) {
			echo json_encode($result);
			return;
		}

		$result['title'] 		= "Create ".$tableName." Table";
		$result['tableName'] 	= $tableName;

		$result['isCrud'] 		= $isCrud;

		$result['isTimestamps'] = $isTimestamps;
		$result['isSoftDelete'] = $isSoftDelete;

		$result['createdField'] = $createdField;
		$result['updatedField'] = $updatedField;
		$result['deletedField'] = $deletedField;

		$result['folderName']   = $folderName;
		
		$result['listModel']    = $this->getListModel();

		$view = $this->renderPartial("generator/create", $result, TRUE);

		$this->msg['success']['message'] = "";
		$this->msg['success']['view'] 	 = $view;
		echo json_encode($this->msg['success']);
	}

	public function submitCreateTable(){
		if (!isset($_POST['Field'])) {
			return;
		}
		
		$fields   = $_POST['Field'];
		$settings = $_POST['Settings'];
		
		$modelGenerator = new ModelGenerator();
		$crudGenerator  = new CrudGenerator();
		
		/* Create Table */
		$result = $modelGenerator->createTable($fields, $settings);

		if($result['status'] != 1){
			echo json_encode($result);
			die;
		}

		$settings['primary'] = $result['primary'];

		$newFields = array();

		foreach($fields as $values){
			$newFields[$values['name']] = $values;
		}

		$fields = $newFields;

		/* Generate Model */
		$result = $modelGenerator->generate($fields, $settings);
		
		if($settings['isCrud'] == 1){
			
			/* Generate CRUD */
			$result = $crudGenerator->generate($fields, $settings);
			if($result['status'] == 1){
				
				$this->setSideMenu();

				$this->msg['success']['message'] = "The CRUD is successfully generated.";
				echo json_encode($this->msg['success']);
			}else{
				$this->msg['failed']['message'] = $result['message'];
				echo json_encode($this->msg['failed']);
			}
		}else{
			if($result['status'] == 1){
				$this->msg['success']['message'] = "The Model is successfully created.";
				echo json_encode($this->msg['success']);
			}else{
				$this->msg['failed']['message'] = $result['message'];
				echo json_encode($this->msg['failed']);
			}
		}
	}

	protected function setSideMenu() {
		$map = directory_map(APPPATH.'controllers');

		$string = "";
		$array  = $this->_parseFolder("", $map);

		/* Create menu list for each controller */
		if(!empty($array)){
			foreach ($array as $row) {
				$title = ucwords(str_replace("-", " ", $row['title']));
				$string .= '<li><a href="<?php echo site_url(\''.$row['url'].'\');?>">'.$title.'</a></li>'."\n";
			}
		} else {
			$string .= '<li><a href="#">No controller found</a></li>'."\n";
		}

		createFile(APPPATH.'views/partial/', 'menu.php', $string);
	}

	private function _parseFolder($keys = '', $map = array()){

		$array = array();

		/* Get available controller */
		foreach ($map as $key => $value) {
			if (!is_array($value)) {
				$temp 		= explode(".", $value);
				$extension  = end($temp);
				array_pop($temp);

				if ($extension == "php") {
					$temp = implode("", $temp);
					
					preg_match_all('/((?:^|[A-Z])[a-z0-9]+)/', $temp,$matches);
					$controller = $this->extractClassName($matches[0]);

					$skipedController = array("generator", "auth", "profile");
					
					if (!in_array($controller, $skipedController)) {
						$array[] = array(
							'title' => $controller, 
							'url' => $keys.$controller,
							'filename' => $value,
							'foldername' => $keys
						);
					}
				}
			}else{
				$array = array_merge($array, $this->_parseFolder(str_replace("//", "/", $keys."/".$key."/"), $value));
			}
		}

		return $array;
	}

	protected function clearFolder(){
		$map = directory_map(APPPATH.'controllers');
		$mapView = directory_map(APPPATH.'views');

		$this->_clearFolder(APPPATH.'controllers/', $map);
		$this->_clearFolder(APPPATH.'views/', $mapView);
	}

	private function _clearFolder($string = "", $map = array()){
		foreach ($map as $key => $value) {
			if(is_array($value) && count($value) > 0){
				$this->_clearFolder($string . $key . "/", $value);

				$checkMap = directory_map($string . $key);
				if(count($checkMap) == 0){
					deleteFolder($string . $key);
				}

			}else if(is_array($value) && count($value) == 0){
				deleteFolder($string . $key);
			}
		}
	}

	protected function getListModel(){		
		$map = directory_map(APPPATH.'models');
		
		$array = array();
		/* Get available controller */
		foreach ($map as $key => $value) {
			if (!is_array($value)) {
				$temp 		= explode(".", $value);
				$extension  = end($temp);
				array_pop($temp);

				if ($extension == "php") {
					$temp = implode("", $temp);
					
					if($temp !== "Auth"){
						$this->load->model($temp);

						$model = new $temp();
						
						$primary    = $model->getPrimary();
						$properties = $model->getProperties();
						
						$stringProperties = implode(",", $properties);

						$array[] = array(
									'model'		=>$temp, 
									'primary'	=> $primary, 
									'properties'=>$stringProperties
								);
					}
				}
			}
		}
		
		return $array;
	}
}

class ModelGenerator extends GeneratorController
{
	
	public    $modelTheme   = "views/generator/class/model.php";
	protected $folderTarget = "models/";

	public function __construct() {
		parent::__construct();

		$this->modelTheme   = APPPATH.$this->modelTheme;
		$this->folderTarget = APPPATH.$this->folderTarget;
	}

	/* Get configuration for current model*/
	public function getConfiguration($tableName, $createdField = "created", $updatedField = "updated", $deletedField = "deleted", $mode = "generate"){
		
		if($mode == "generate"){
			if (!$this->db->table_exists($tableName)) {
				return array(
					"status"	=> 2,
					"message"	=> "The table doesn't exists."
				);
			}

			$fields 	= $this->db->field_data($tableName);
			$primary 	= $this->getPrimary($fields);
			$modelName 	= getClassName($tableName);

			$ignoredField = array($createdField, $updatedField, $deletedField);

			return array(
				"status" 		=> 1,
				"fields" 		=> $fields,
				"primary" 		=> $primary,
				"modelName" 	=> $modelName,
				"ignoredField"  => $ignoredField,
				"message" 		=> "Get configuration files"
			);

		}else if($mode == "create"){

			if ($this->db->table_exists($tableName)) {
				return array(
					"status"	=> 2,
					"message"	=> "The table has already exists."
				);
			}

			$modelName 	  = getClassName($tableName);
			$ignoredField = array($createdField, $updatedField, $deletedField);

			return array(
				"status" 		=> 1,
				"modelName" 	=> $modelName,
				"ignoredField"  => $ignoredField,
				"message" 		=> "Get configuration files"
			);
		}
	}

	public function generate($fields = array(), $settings = array()) {		
		/*  
			$tableName, $primary$, $modelName, $ignoredField, $isCrud,
			$isTimestamps, $isSoftDelete, $createdField, $updatedField, $deletedField
		*/	extract($settings);

		$timestampsField = $ignoredField;
		$ignoredField[]  = $primary;

		$ignoredType   = array();
		$ignoredType[] = "password";
		$ignoredType[] = "image";
		$ignoredType[] = "file";
		$ignoredType[] = "random";

		$pathModelTheme = $this->modelTheme;
		$template 		= file_get_contents($pathModelTheme);

		$variable   = $validator = $label = $relationship = "";
		$thumbField = array();

		/* Check if there is a thumb field or not */
		foreach ($fields as $key => $values) {
			if (!empty($values['image']['thumb'])) {
				$thumbField[] = $values['image']['thumb'];
			}
		}

		foreach ($fields as $key => $values) {
			$variable .= "public \${$key};\n\t";

			if (   !in_array($key, $ignoredField) 
				&& !in_array($key, $thumbField) 
				&& !in_array($values['type'], $ignoredType)
			) {
				
				/* Validator */
				$validator .= "'{$modelName}[{$key}]' => 'required";

				if ($values['type'] == 'text' || $values['type'] == 'email') {
					if (!empty($values['min_length'])) {
						$validator .= "|min_length[".$values['min_length']."]";
					}

					if (!empty($values['max_length'])) {
						$validator .= "|max_length[".$values['max_length']."]";
					}
				}	

				if ($values['type'] == 'select' || $values['type'] == 'radio') {
					$validator .= "|numeric";

					$relationship .= "\n\tpublic function get".$values['fk']['model']."(){\n\t\treturn \$this->belongsTo('".$values['fk']['model']."','".$key."');\n\t}\n";
				}

				if ($values['type'] == 'email') {
					$validator .= "|valid_email";
				}

				$validator .= "',\n\t\t\t";
				
				/* Label Validator */
				$label .= "'{$modelName}[{$key}]' => '".getLabel($key)."',\n\t\t\t";
			}
		}

		if($isTimestamps){
			foreach ($timestampsField as $value) {
				if($value == $deletedField){
					if($isSoftDelete){
						$variable .= "public \${$value};\n\t";
					}
				}else{
					if($isTimestamps){
						$variable .= "public \${$value};\n\t";
					}
				}
				
			}
		}

		/* Render Template */
		$template = str_replace("{content:class}", 		 $modelName, 	$template);
		$template = str_replace("{content:tableName}",   $tableName, 	$template);
		$template = str_replace("{content:primary}", 	 $primary, 	 	$template);

		$template = str_replace("{content:variable}", 	 $variable,  	$template);
		$template = str_replace("{content:validator}", 	 $validator, 	$template);
		$template = str_replace("{content:label}", 		 $label, 	 	$template);
		$template = str_replace("{content:relationship}",$relationship, $template);

		/* Settings if timestamps active or not*/
		if(!$isTimestamps){
			$template = str_replace("{content:timestamps}", "protected \$timestamps = FALSE;\n\t", $template);
		}else{
			$template = str_replace("{content:timestamps}", "", $template);
		}
		
		/* Settings if softdelete active or not*/
		if($isSoftDelete){
			$template = str_replace("{content:softDeletes}", "protected \$softDeletes = TRUE;", $template);
		}else{
			$template = str_replace("{content:softDeletes}", "", $template);
		}

		/* Created Field for Timestamps*/
		if($createdField != 'created'){
			$template = str_replace("{content:createdField}", "protected \$createdField = '{$createdField}';\n\t", $template);
		}else{
			$template = str_replace("{content:createdField}", "", $template);
		}

		/* Updated Field for Timestamps*/
		if($updatedField != 'updated'){
			$template = str_replace("{content:updatedField}", "protected \$updatedField = '{$updatedField}';\n\t", $template);
		}else{
			$template = str_replace("{content:updatedField}", "", $template);
		}

		/* Deleted Field for Timestamps*/
		if($deletedField != 'deleted'){
			$template = str_replace("{content:deletedField}", "protected \$deletedField = '{$deletedField}';\n", $template);
		}else{
			$template = str_replace("{content:deletedField}", "", $template);
		}

		/* Model File Name */
		$fileName = $modelName.".php";
		
		/* Create file on the folder target */
		$result = createFile($this->folderTarget, $fileName, $template);
		if($result === TRUE){
			return array(
				"status" => 1,
				"fields" => $fields,
				"primary" => $primary,
				"modelName" => $modelName,
				"ignoredField" => $ignoredField,
				"message" => "Success"
			);
		}

		return array(
				"status" => 2,
				"fields" => $fields,
				"primary" => $primary,
				"modelName" => $modelName,
				"ignoredField" => $ignoredField,
				"message" => $result['message']
			);
	}

	public function createTable($fields = array(), $settings = array()) {
		/*  
			$tableName, $primary$, $modelName, $ignoredField, $isCrud,
			$isTimestamps, $isSoftDelete, $createdField, $updatedField, $deletedField
		*/	extract($settings);

		$primary = null;
		$fk = array();

		$columns = array();

		foreach($fields as $values){
			$constraint = !empty($values['max_length']) ? $values['max_length'] : 255;

			if($values['type'] == "primary" || $values['type'] == "select" || $values['type'] == "radio"){
				if($values['type'] == "primary"){
					$columns[$values['name']] = array(
													'type' => 'INT',
													'auto_increment' => TRUE
												);
					$primary = $values['name'];
				}else{
					$columns[$values['name']] = array(
													'type' => 'INT',
													'unsigned' => TRUE
												);
					$fk[] = $values['name'];					
				}
			}else if(
				$values['type'] == "text"  || $values['type'] == "password" || 
				$values['type'] == "email" || $values['type'] == "image"    ||
				$values['type'] == "image" || $values['type'] == "thumb"    ||
				$values['type'] == "file"  || $values['type'] == "random"
			){
				$columns[$values['name']] = array(
												'type' => 'VARCHAR',
												'constraint' => $constraint
											);

			}else if($values['type'] == "date"){
				$columns[$values['name']] = array(
												'type' => 'DATE'
											);

			}else if($values['type'] == "number"){
				$columns[$values['name']] = array(
												'type' => 'INT'
											);

			}else if(
				$values['type'] == "textarea" || $values['type'] == "ckeditor" ||
				$values['type'] == "jqueryte" 
			){
				$columns[$values['name']] = array(
												'type' => 'TEXT'
											);
			}
		}

		if($isTimestamps){
			foreach($ignoredField as $ignore){
				$columns[$ignore] = array('type' => 'DATETIME', 'null' => TRUE);
			}
		}

		/* Start using dbforge*/
		$this->dbforge->add_field($columns);
		$this->dbforge->add_key($primary, TRUE);

		foreach($fk as $value){
			$this->dbforge->add_key($value);
		}
		
		$result = $this->dbforge->create_table($tableName, TRUE);
		
		if($result === TRUE){
			return array(
				"status"  => 1,
				"primary" => $primary,
				"message" => "Table has created"
			);
		}

		return array(
				"status"  => 2,
				"message" => "Failed to create table"
			);
	}

	protected function getPrimary($fields = array()){
		foreach($fields as $field){
			if($field->primary_key==1){
				return $field->name;
			}
		}
		return NULL;
	}
}

Class CrudGenerator extends GeneratorController{
	
	/* Theme Folder Path */
	public 	  $baseTheme 		= "views/generator/";
	
	/* Controller Theme Path */
	public    $controllerTheme  = "views/generator/class/controller.php";
	/* Class Folder */
	public 	  $classFolder 		= "views/generator/class/";
	/* Folder target for controller */
	protected $folderTarget 	= "controllers/";

	public function __construct() {
		parent::__construct();

		$this->baseTheme        = APPPATH.$this->baseTheme.$this->templateName.'/';

		$this->controllerTheme  = APPPATH.$this->controllerTheme;
		$this->classFolder		= APPPATH.$this->classFolder;
		$this->folderTarget		= APPPATH.$this->folderTarget;
	}

	public function generate($fields = array(), $settings = array()) {
		
		/*  
			$tableName, $primary, $modelName, $ignoredField, $isCrud,
			$isTimestamps, $isSoftDelete, $createdField, $updatedField, $deletedField
		*/	extract($settings);

		$pathControllerTheme = $this->controllerTheme;
		$template 			 = file_get_contents($pathControllerTheme);

		$relatedModelData  = $beforeValidate = $beforeSave  = "";
		$relatedModel      = "'{$modelName}',\n\t\t\t\t";

		$thumbField = array();

		// Check if there is a thumb field or not
		foreach ($fields as $key => $values) {

			if (!empty($values['image']['thumb'])) {
				$thumbField[] = $values['image']['thumb'];
			}
		}

		//check folder field
		$tempFolderName = "";

		if($folderName !== ""){
			$folderName = trim($folderName, "/");

			$arrFolderName  = explode("/", $folderName);
			
			foreach ($arrFolderName as $value) {
				$tempFolderName .= "$value/";
				$this->createFolder(APPPATH."controllers/".$tempFolderName);
			}
		}

		$belongsTo = array();
		$fieldShowed = array("'$primary'");

		foreach ($fields as $key => $values) {

			if(isset($values['show'])){
				$fieldShowed[] = "'$key'";
			}
			
			if ($values['type'] == "select" || $values['type'] == "radio") {
				$relatedModel .= "'".$values['fk']['model']."',\n\t\t\t\t";
				$relatedModelData .= "\$data['all".$values['fk']['model']."']	= \$this->".$values['fk']['model']."->all();\n\t\t";

				$belongsTo[$key] = $values;
			}

			if ($values['type'] == "password") {
				
				$beforeValidate .= 
			//===content====//
			"\$this->load->library('encrypt');

			\${$key}    = \$this->input->post(\"{$key}\");
			\$raw{$key} = \${$key};

			if (!empty(\${$key})) {
				\${$key}        = \$this->encrypt->sha1(\${$key});
				\$model->{$key} = \${$key};
			}\n";
			//===endcontent====//
				
				$beforeSave .= 
				//===content====//
				"if (empty(\$model->{$key})) {
					\$this->msg['invalid']['message'] = \"The ".getLabel($key)." field is required.\";
					echo json_encode(\$this->msg['invalid']);
					exit();
				}\n\n";
				//===endcontent====//
			}

			if ($values['type'] == "image" || $values['type'] == "file") {

				$partial = file_get_contents($this->classFolder. "partial/image.php");
				
				$isThumb = isset($values['image']['is_thumb']) ? "TRUE":"FALSE";
				$partial = str_replace("{partial:is_create_thumb}", $isThumb, $partial);

				$isCrop  = isset($values['image']['is_crop']) ? "TRUE":"FALSE";
				$partial = str_replace("{partial:is_crop}", $isCrop, $partial);

				$scriptThumb = "";
				if($isThumb == "TRUE"){
					$scriptThumb = "//if create thumb
						if(\$isCreateThumb){
							\$model->{partial:thumb_field} 	= \$folder.\$data['raw_name'].\"_thumb\".\$data['file_ext'];
							
							//if without cropping
							if(!\$isCrop){
								\$this->createThumb(\$imgPath,{partial:width},{partial:height});
							}
						}";
				}

				$partial = str_replace("{partial:script_thumb}", $scriptThumb, $partial);

				$scriptCrop = "";
				if($isCrop == "TRUE"){
					$scriptCrop = "//if with cropping
						if(\$isCrop){
							\$scaleWidth = {partial:scale_width};
							\$scaleHeight= {partial:scale_height};

							\$callback = isset(\$_POST['callback'])
									   ? \$_POST['callback'] : NULL;

							\$this->msg['success']['crop'] = \$this->crop(\$model->{partial:key}, \$callback, \$isCreateThumb, \$scaleWidth, \$scaleHeight);
						}";
				}

				$partial = str_replace("{partial:script_crop}", $scriptCrop, $partial);

				$partial = str_replace("{partial:key}", $key, $partial);
				$partial = str_replace("{partial:allowed_types}", $values['filetype'], $partial);
				
				$thumbWidth  = $values['image']['width']  != "" ? $values['image']['width']  : 300;
				$thumbHeight = $values['image']['height'] != "" ? $values['image']['height'] : 300;

				$partial = str_replace("{partial:width}", $thumbWidth, $partial);
				$partial = str_replace("{partial:height}", $thumbHeight, $partial);
				
				if($isThumb == "TRUE" && $isCrop == "TRUE"){
					$scaleWidth  = $thumbWidth;
					$scaleHeight = $thumbHeight;
				}else{
					$scaleWidth  = $values['image']['scale_width']  != "" ? $values['image']['scale_width']  : 1;
					$scaleHeight = $values['image']['scale_height'] != "" ? $values['image']['scale_height'] : 1;
				}

				$partial = str_replace("{partial:scale_width}", $scaleWidth, $partial);
				$partial = str_replace("{partial:scale_height}", $scaleHeight, $partial);

				if (!empty($values['image']['thumb'])) {
					$thumb_field = $values['image']['thumb'];
				}else{
					$thumb_field = "change_this_variable";
				}
				
				$partial = str_replace("{partial:thumb_field}", $values['image']['thumb'], $partial);

				$beforeSave .= $partial;
			}
		}

		$belongsToExcelString = "";
		$i = 0;
		foreach ($belongsTo as $key => $row) {
			if($i != 0){
				$belongsToExcelString .= " else ";
			}
			$belongsToExcelString .= "if(\$key == \"".$key."\"){
									\$this->spreadsheet->write(\$object->".lcfirst($row['fk']['model'])."->".$row['fk']['label'].");
								}";
			$i++;
		}

		if($belongsToExcelString == ""){
			$belongsToExcelString  = "\$this->spreadsheet->write(\$value);";
		}else{
			$belongsToExcelString .= "else{
									\$this->spreadsheet->write(\$value);
								}";
		}

		$fieldShowed = implode(",", $fieldShowed);

		$template = str_replace("{content:class}", $modelName, $template);
		$template = str_replace("{content:primary}", $primary, $template);
		$template = str_replace("{content:related_model}", $relatedModel, $template);
		$template = str_replace("{content:related_model_data}", $relatedModelData, $template);
		$template = str_replace("{content:before_validate}", $beforeValidate, $template);
		$template = str_replace("{content:before_save}", $beforeSave, $template);

		$template = str_replace("{content:field_showed}", $fieldShowed, $template);		
		$template = str_replace("{content:belongsto_excel}", $belongsToExcelString, $template);		

		$fileName = $modelName."Controller.php";

		$folderNameString = "";
		$pathController = "{\$this->controller}";

		if($tempFolderName !== ""){
			$this->folderTarget .= $tempFolderName;

			$folderNameString = "/**
	 * Controller folder name
	 *
	 * @var string
	 * @access public
	 */
	public \$folder = '".trim($tempFolderName,"/")."';

	/**
	 * Controller Segment on URL
	 *
	 * @var integer
	 * @access public
	 */
	protected \$controllerSegment = ".(count($arrFolderName) + 1).";

	/**
	 * Action Segment on URL
	 *
	 * @var integer
	 * @access public
	 */
	protected \$actionSegment = ".(count($arrFolderName) + 2).";";

			$pathController = "{\$this->folder}/{\$this->controller}";
		}

		$template = str_replace("{content:folder_name}"    , $folderNameString , $template);
		$template = str_replace("{content:path_controller}", $pathController , $template);
		
		$result = createFile($this->folderTarget, $fileName, $template);
		if($result !== TRUE){
			return array(
				"status" => 2,
				"message" => "Cannot create {$modelName}Controller : ".$result['message']
			);
		}

		/* Create index.php file*/
		$template = file_get_contents($this->baseTheme. "index.php");

		$thead = $textbox_search_thead = $tbody = $tbody_view = $fieldType = "";
		$count = 4;

		foreach ($fields as $key => $values) {
			if(isset($values['show'])){
				$count++;

				//Thead on Table
				$partialTemplate = file_get_contents($this->baseTheme. "partial/thead.php");
				
				$partialTemplate = str_replace("{content:fieldName}", $key, $partialTemplate);
				$partialTemplate = str_replace("{content:fieldLabel}", getLabel($key), $partialTemplate);
				
				$thead .= $partialTemplate;

				//Thead Search
				if($values['type'] == "select" || $values['type'] == "radio"){
					$partialTemplate = file_get_contents($this->baseTheme. "partial/select-thead.php");
						
					$partialTemplate = str_replace("{content:fieldPrimary}" , $values['fk']['id']	, $partialTemplate);
					$partialTemplate = str_replace("{content:fieldName}"	, $key 					, $partialTemplate);
					$partialTemplate = str_replace("{content:fieldLabel}"	, getLabel($key) 		, $partialTemplate);
					$partialTemplate = str_replace("{content:fieldTitle}"	, $values['fk']['label'], $partialTemplate);
					$partialTemplate = str_replace("{content:modelName}"	, $values['fk']['model'], $partialTemplate);
					
					$textbox_search_thead .= $partialTemplate;
					
					//Tbody
					$tbody .= "<td><?php echo \$row->".lcfirst($values['fk']['model'])."->".$values['fk']['label'].";?></td>";

				}else{
					
					$fieldType = $values['type'] == "date" ? "datepicker": "";

					$partialTemplate = file_get_contents($this->baseTheme. "partial/input-thead.php");
					
					$partialTemplate = str_replace("{content:fieldName}", $key, $partialTemplate);
					$partialTemplate = str_replace("{content:fieldLabel}", getLabel($key), $partialTemplate);
					$partialTemplate = str_replace("{content:fieldType}", $fieldType, $partialTemplate);

					$textbox_search_thead .= $partialTemplate;

					//Tbody
					if ($values['type'] == "image") {
					
						if(isset($values['image']['is_thumb'])){
							$tbody .= "<td><img class=\"img-thumbnail\" width=\"170\" src=\"<?php echo base_url().\$row->".$values['image']['thumb'].";?>\"></td>\n\t\t\t\t\t\t";
						}else{
							$tbody .= "<td><img class=\"img-thumbnail\" width=\"170\" src=\"<?php echo base_url().\$row->".$key.";?>\"></td>\n\t\t\t\t\t\t";	
						}

					} else if($values['type'] == "file") {
					
						$tbody .= "<td><a href=\"<?php echo base_url().\$row->".$key.";?>\">Download file</a></td>\n\t\t\t\t\t\t";
					
					} else if($values['type'] == "date") {
					
						$tbody .= "<td><?php echo date(\"d M Y\", strtotime(\$row->".$key."));?></td>\n\t\t\t\t\t\t";
					
					} else {
					
						$tbody .= "<td><?php echo \$row->".$key.";?></td>\n\t\t\t\t\t\t";
					
					}
				}

			}

			if(!in_array($key, $ignoredField) && $key != $primary && !in_array($key, $thumbField)){
				
				if($values['type'] == "select" || $values['type'] == "radio"){
					
					$tbody_view .= "<tr>\n\t\t<td>".getLabel($key)."</td>\n\t\t<td>:</td>\n\t\t<td><?php echo \$model->".lcfirst($values['fk']['model'])."->".$values['fk']['label'].";?></td>\n\t</tr>\n";

				} else if($values['type'] == "image") {

					if(isset($values['image']['is_thumb'])){
						$tbody_view .= "<tr>\n\t\t<td>".getLabel($key)."</td>\n\t\t<td>:</td>\n\t\t<td><img width=\"170\" src=\"<?php echo base_url().\$model->".$values['image']['thumb'].";?>\"></td>\n\t</tr>\n";
					} else {
						$tbody_view .= "<tr>\n\t\t<td>".getLabel($key)."</td>\n\t\t<td>:</td>\n\t\t<td><img width=\"170\" src=\"<?php echo base_url().\$model->".$key.";?>\"></td>\n\t</tr>\n";
					}

				} else if($values['type'] == "file") {
				
					$tbody_view .= "<tr>\n\t\t<td>".getLabel($key)."</td>\n\t\t<td>:</td>\n\t\t<td><a href=\"<?php echo base_url().\$model->".$key.";?>\">Download file</a></td>\n\t</tr>\n";
				
				} else if($values['type'] == "date") {
				
					$tbody_view .= "<tr>\n\t\t<td>".getLabel($key)."</td>\n\t\t<td>:</td>\n\t\t<td><?php echo date(\"d M Y\", strtotime(\$model->".$key."));?></td>\n\t</tr>\n";
				
				} else if($values['type'] == "password" && isset($values['show'])) {
				
					$tbody_view .= "<tr>\n\t\t<td>".getLabel($key)."</td>\n\t\t<td>:</td>\n\t\t<td><?php echo \$model->".$key.";?></td>\n\t</tr>\n";
				
				} else if($values['type'] == "password" && !isset($values['show'])) {
				
					$tbody_view .= "";
				
				} else {
				
					$tbody_view .= "<tr>\n\t\t<td>".getLabel($key)."</td>\n\t\t<td>:</td>\n\t\t<td><?php echo \$model->".$key.";?></td>\n\t</tr>\n";
				
				}
			}
		}

		$template = str_replace("{content:primary}"				, $primary 				, $template);
		$template = str_replace("{content:thead}"				, $thead 				, $template);
		$template = str_replace("{content:textbox_search_thead}", $textbox_search_thead , $template);
		$template = str_replace("{content:count}"				, $count 				, $template);
		$template = str_replace("{content:tbody}"				, $tbody 				, $template);
		
		$template = str_replace("{content:createdField}"		, $createdField 		, $template);
		$template = str_replace("{content:updatedField}"		, $updatedField 		, $template);
		$template = str_replace("{content:deletedField}"		, $deletedField 		, $template);
		
		$fileName = "index.php";

		$dirName  = str_replace("_", "-", $tableName);

		if($tempFolderName !== ""){
			$this->createFolder(APPPATH."views/".$tempFolderName);
			$viewPathFile = APPPATH."views/".$tempFolderName.$dirName."/";
		}else{
			$viewPathFile = APPPATH."views/".$dirName."/";
		}

		$this->createFolder($viewPathFile);
		$this->createFolder($viewPathFile."trash/");
		
		$result = createFile($viewPathFile, $fileName, $template);
		if($result !== TRUE){
			return array(
				"status" => 2,
				"message" => "Cannot create index.php file : ".$result['message']
			);
		}

		/* Create trash/index.php file*/
		$template = file_get_contents($this->baseTheme. "index-trash.php");

		$template = str_replace("{content:primary}"				, $primary 				, $template);
		$template = str_replace("{content:thead}"				, $thead 				, $template);
		$template = str_replace("{content:textbox_search_thead}", $textbox_search_thead , $template);
		$template = str_replace("{content:count}"				, $count 				, $template);
		$template = str_replace("{content:tbody}"				, $tbody 				, $template);
		
		$template = str_replace("{content:createdField}"		, $createdField 		, $template);
		$template = str_replace("{content:updatedField}"		, $updatedField 		, $template);
		$template = str_replace("{content:deletedField}"		, $deletedField 		, $template);

		$fileName = "index.php";

		$result = createFile($viewPathFile."trash/", $fileName, $template);
		if($result !== TRUE){
			return array(
				"status" => 2,
				"message" => "Cannot create trash/index.php file : ".$result['message']
			);
		}

		/* Create page.php file*/
		$template = file_get_contents($this->baseTheme. "page.php");

		$template = str_replace("{content:primary}"				, $primary 				, $template);
		$template = str_replace("{content:count}"				, $count 				, $template);
		$template = str_replace("{content:tbody}"				, $tbody 				, $template);
		
		$template = str_replace("{content:createdField}"		, $createdField 		, $template);
		$template = str_replace("{content:updatedField}"		, $updatedField 		, $template);
		$template = str_replace("{content:deletedField}"		, $deletedField 		, $template);
		
		$fileName = "page.php";

		$result = createFile($viewPathFile, $fileName, $template);
		if($result !== TRUE){
			return array(
				"status" => 2,
				"message" => "Cannot create page.php file : ".$result['message']
			);
		}

		/* Create trash/page.php file*/
		$template = file_get_contents($this->baseTheme. "page-trash.php");

		$template = str_replace("{content:primary}"				, $primary 				, $template);
		$template = str_replace("{content:count}"				, $count 				, $template);
		$template = str_replace("{content:tbody}"				, $tbody 				, $template);
		
		$template = str_replace("{content:createdField}"		, $createdField 		, $template);
		$template = str_replace("{content:updatedField}"		, $updatedField 		, $template);
		$template = str_replace("{content:deletedField}"		, $deletedField 		, $template);
		
		$fileName = "page.php";

		$result = createFile($viewPathFile."trash/", $fileName, $template);
		if($result !== TRUE){
			return array(
				"status" => 2,
				"message" => "Cannot create trash/page.php file : ".$result['message']
			);
		}

		/* Create view.php file*/
		$template = file_get_contents($this->baseTheme. "view.php");

		$template = str_replace("{content:primaryLabel}"	, getLabel($primary) , $template);
		$template = str_replace("{content:primary}"			, $primary 			 , $template);
		$template = str_replace("{content:tbody_view}"		, $tbody_view 		 , $template);
		
		$template = str_replace("{content:createdField}"	, $createdField 	 , $template);
		$template = str_replace("{content:updatedField}"	, $updatedField 	 , $template);
		$template = str_replace("{content:deletedField}"	, $deletedField 	 , $template);
		
		$fileName = "view.php";

		$result = createFile($viewPathFile, $fileName, $template);
		if($result !== TRUE){
			return array(
				"status" => 2,
				"message" => "Cannot create view.php file : ".$result['message']
			);
		}

		/* Create edit.php file*/
		$template = file_get_contents($this->baseTheme. "edit.php");
		$contentFields = "";

		foreach ($fields as $key => $values) {
			if(!in_array($key, $ignoredField) && $key != $primary && !in_array($key, $thumbField) && $values['type'] != "thumb") {
				$type = $values['type'];

				$content_thumb = "";
				if ($values['type'] == "image") {
					if(isset($values['image']['is_thumb'])){
						$content_thumb = 
				//content
				"<?php if(!empty(\$model->".$values['image']['thumb'].")):?>
				<div class=\"form-group\">
					<img src=\"<?php echo base_url().\$model->thumb;?>\" width=\"170\">
				</div>
				<?php endif;?>";
				//content

					}
				}

				$partialTemplate = file_get_contents($this->baseTheme. "form/". $type . ".php");

				$partialTemplate = str_replace("{content:fieldPrimary}" , $values['fk']['id']	, $partialTemplate);
				$partialTemplate = str_replace("{content:key}"			, $key 					, $partialTemplate);
				$partialTemplate = str_replace("{content:fieldLabel}"	, getLabel($key) 		, $partialTemplate);
				$partialTemplate = str_replace("{content:fieldTitle}"	, $values['fk']['label'], $partialTemplate);
				$partialTemplate = str_replace("{content:modelName}"	, $modelName			, $partialTemplate);
				$partialTemplate = str_replace("{content:fkModel}"		, $values['fk']['model'], $partialTemplate);
				$partialTemplate = str_replace("{content:thumb}"		, $content_thumb		, $partialTemplate);
				
				$partialTemplate = str_replace("{content:length}"		, $values['random']['length'], $partialTemplate);
				$partialTemplate = str_replace("{content:type}"			, $values['random']['type'], $partialTemplate);

				$contentFields .= $partialTemplate;
			}
		}

		$template = str_replace("{content:primary}", $primary, $template);
		$template = str_replace("{content:fields}", $contentFields, $template);

		$fileName = "edit.php";

		$result = createFile($viewPathFile, $fileName, $template);
		if($result !== TRUE){
			return array(
				"status" => 2,
				"message" => "Cannot create edit.php file : ".$result['message']
			);
		}

		return array(
			"status" => 1,
			"message" => "Success"
		);
	}

	protected function createFolder($path) {
		if (!is_dir($path)) {
			mkdir($path, 0777);
		}
	}
}