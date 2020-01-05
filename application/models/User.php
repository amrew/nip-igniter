<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User extends Nip_Model
{
    protected $tableName = "user";
    protected $primary = "id";

    protected $softDeletes = true;

    public $id;
    public $username;
    public $password;
    public $nama;
    public $email;
    public $role_id;
    public $status_id;
    public $picture;
    public $created;
    public $updated;
    public $deleted;

    protected $validator = array(
        'username' => 'required|max_length[255]|is_unique[user.username]',
        'email' => 'required|max_length[255]|valid_email|is_unique[user.email]',
        'role_id' => 'required|numeric',
        'status_id' => 'required|numeric',
    );

    protected $label = array(
        'username' => 'Username',
        'email' => 'Email',
        'role_id' => 'Role',
        'status_id' => 'Status',
    );

    public function __construct($options = array())
    {
        parent::__construct($options);
    }

    public function beforeValidate()
    {
        if (!empty($this->id)) {
            $this->validator['username'] = 'required|max_length[255]|is_edit_unique[user.username.id.' . $this->id . ']';
            $this->validator['email'] = 'required|max_length[255]|valid_email|is_edit_unique[user.email.id.' . $this->id . ']';
        }
    }

    public function getRole()
    {
        return $this->belongsTo('Role', 'role_id');
    }

    public function getStatus()
    {
        return $this->belongsTo('Status', 'status_id');
    }

}
