<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    CodeIgniter
 * @author    EllisLab Dev Team
 * @copyright    Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright    Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license    http://opensource.org/licenses/MIT    MIT License
 * @link    http://codeigniter.com
 * @since    Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Form Validation Class
 *
 * @package        CodeIgniter
 * @subpackage    Libraries
 * @category    Validation
 * @author        EllisLab Dev Team
 * @link        http://codeigniter.com/user_guide/libraries/form_validation.html
 */
class Nip_Form_validation extends CI_Form_validation
{

    /**
     * Run the Validator
     *
     * This function does all the work.
     *
     * @param    string    $group
     * @return    bool
     */
    public function run($object = null, $group = '')
    {
        if ($object !== null) {
            $object = (array) $object;
        } else {
            $object = $_POST;
        }
        // Do we even have any data to process?  Mm?
        $validation_array = empty($this->validation_data) ? $object : $this->validation_data;
        if (count($validation_array) === 0) {
            return false;
        }

        // Does the _field_data array containing the validation rules exist?
        // If not, we look to see if they were assigned via a config file
        if (count($this->_field_data) === 0) {
            // No validation rules?  We're done...
            if (count($this->_config_rules) === 0) {
                return false;
            }

            if (empty($group)) {
                // Is there a validation rule for the particular URI being accessed?
                $group = trim($this->CI->uri->ruri_string(), '/');
                isset($this->_config_rules[$group]) or $group = $this->CI->router->class . '/' . $this->CI->router->method;
            }

            $this->set_rules(isset($this->_config_rules[$group]) ? $this->_config_rules[$group] : $this->_config_rules);

            // Were we able to set the rules correctly?
            if (count($this->_field_data) === 0) {
                log_message('debug', 'Unable to find validation rules');
                return false;
            }
        }

        // Load the language file containing error messages
        $this->CI->lang->load('form_validation');

        // Cycle through the rules for each field and match the corresponding $validation_data item
        foreach ($this->_field_data as $field => $row) {
            // Fetch the data from the validation_data array item and cache it in the _field_data array.
            // Depending on whether the field name is an array or a string will determine where we get it from.
            if ($row['is_array'] === true) {
                $this->_field_data[$field]['postdata'] = $this->_reduce_array($validation_array, $row['keys']);
            } elseif (isset($validation_array[$field])) {
                $this->_field_data[$field]['postdata'] = $validation_array[$field];
            }
        }

        // Execute validation rules
        // Note: A second foreach (for now) is required in order to avoid false-positives
        //     for rules like 'matches', which correlate to other validation fields.
        foreach ($this->_field_data as $field => $row) {
            // Don't try to validate if we have no rules set
            if (empty($row['rules'])) {
                continue;
            }

            $this->_execute($row, $row['rules'], $this->_field_data[$field]['postdata']);
        }

        // Did we end up with any errors?
        $total_errors = count($this->_error_array);
        if ($total_errors > 0) {
            $this->_safe_form_data = true;
        }

        // Now we need to re-set the POST data with the new, processed data
        $this->_reset_post_array();

        return ($total_errors === 0);
    }

    /**
     * Match one field to another when on edit session
     *
     * @access    public
     * @param    string
     * @param    field
     * @return    bool
     */
    public function is_edit_unique($str, $field)
    {
        list($table, $field, $primary, $id) = explode('.', $field);
        $query = $this->CI->db->limit(1)->get_where($table, array($field => $str, $primary . " !=" => $id));

        return $query->num_rows() === 0;
    }
}
