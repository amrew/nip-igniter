				if (!empty($_FILES['{partial:key}']['name'])) {

					$folder = "./public/uploads/".strtolower("{$this->Model}/");

					if(!is_dir($folder)){
						mkdir($folder);
					}

					$config['upload_path']	 = $folder;
					$config['allowed_types'] = '{partial:allowed_types}';
					$config['max_size']		 = '10000';

					$this->upload->initialize($config);

					if (!$this->upload->do_upload('{partial:key}')) {
						$this->msg['failed']['message'] = $this->upload->display_errors();
						echo json_encode($this->msg['failed']);
						exit();
					} else {
						$data 			= $this->upload->data();
						$model->{partial:key} = $folder.$data['file_name'];

						$isCreateThumb  = {partial:is_create_thumb};
						$isCrop 		= {partial:is_crop};
						{partial:script_thumb}
						{partial:script_crop}
					}
				}

