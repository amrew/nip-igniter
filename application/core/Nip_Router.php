<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Nip_Router extends CI_Router
{

    public $postfix_controller_name = 'Controller';

    /**
     * Set class name
     *
     * @param    string    $class    Class name
     * @return    void
     */
    public function set_class($class)
    {
        $class = $this->camelize_name($class) . $this->postfix_controller_name;
        $this->class = str_replace(array('/', '.'), '', $class);
    }

    /**
     * Set method name
     *
     * @param    string    $method    Method name
     * @return    void
     */
    public function set_method($method)
    {
        $method = $this->camelize_name($method, true);
        $this->method = $method;
    }

    protected function camelize_name($name, $is_lower_first = false)
    {
        $array = explode('-', $name);
        $array = array_map('ucfirst', $array);
        $new_name = implode('', $array);

        if ($is_lower_first) {
            $new_name = lcfirst($new_name);
        }
        return $new_name;
    }

    /**
     * Set default controller
     *
     * @return    void
     */
    protected function _set_default_controller()
    {
        if (empty($this->default_controller)) {
            show_error('Unable to determine what should be displayed. A default route has not been specified in the routing file.');
        }

        // Is the method being specified?
        if (sscanf($this->default_controller, '%[^/]/%s', $class, $method) !== 2) {
            $method = 'index';
        }

        $find_class = $this->camelize_name($class) . $this->postfix_controller_name;

        if (!file_exists(APPPATH . 'controllers/' . $this->directory . ucfirst($find_class) . '.php')) {
            // This will trigger 404 later
            return;
        }

        $this->set_class($class);
        $this->set_method($method);

        // Assign routed segments, index starting from 1
        $this->uri->rsegments = array(
            1 => $class,
            2 => $method,
        );

        log_message('debug', 'No URI present. Default controller set.');
    }
}
