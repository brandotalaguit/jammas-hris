<?php 
if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Filename: Itc_model.php
* Author: Brando Talaguit (ITC Developer)
*/
class MY_Model extends CI_Model
{
	protected $table = NULL;
	protected $primary_key = "Id";
	protected $primary_filter = "intval";
	protected $order_by = "";

	protected $timestamps = TRUE;
	protected $soft_delete = TRUE;

	protected $protected_attribute = array();

	private $_select = "*";
	protected $_database = NULL;
	protected $_database_connection = NULL;

	/* validation */
	private $validated = TRUE;
	private $row_fields_to_update = array();


	/**
	 * The various callbacks available to the model. Each are
	 * simple lists of method names (methods will be run on $this).
	 */
	protected $before_create = array();
	protected $after_create = array();
	protected $before_update = array();
	protected $after_update = array();
	protected $before_get = array();
	protected $after_get = array();
	protected $before_delete = array();
	protected $after_delete = array();
	protected $before_soft_delete = array();
	protected $after_soft_delete = array();

	protected $callback_parameters = array();

	
	public $_db = array();

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

	public $rules = array();

	function __construct()
	{
		parent::__construct();
		$this->load->library('user_agent');

		$this->_set_connection();
	}

	public function is_soft_delete()
	{
		return $this->soft_delete;
	}

	/**
	 * Set the fillable attributes for the model.
	 *
	 * @param  array $fillable
	 * @return this
	 */
	public function fillable(array $fillable)
	{
	    $this->fillable = $fillable;
	    return $this;
	}
	/**
	 * Get the fillable attributes for the model.
	 *
	 * @return array
	 */
	public function getFillable()
	{
	    return $this->fillable;
	}
	/**
	 * Get the fillable attributes of a given array.
	 *
	 * @param  array $attributes
	 * @return array
	 */
	protected function fillableFromArray(array $attributes)
	{
	    if (count($this->fillable) > 0) {
	        return array_intersect_key($attributes, array_flip($this->fillable));
	    }
	    return $attributes;
	}

	public function array_from_object($fields)
	{
		$data = array();
		foreach ($fields as $key => $value) 
		{
			$data[$key] = $value;
		}

		return $data;
	}

	public function array_from_post($fields)
	{
		$data = array();
		foreach ($fields as $field) 
		{
			$data[$field] = $this->input->post($field);
		}

		return $data;
	}

	public function array_from_post2()
	{
		$data = array();
		foreach ($this->input->post() as $key => $value) 
		{
			$data[$key] = $this->input->post($key);
		}

		return $data;
	}

	public function get($id = NULL, $single = FALSE)
	{
		if ($id != NULL) 
		{
			$filter = $this->primary_filter;
			$id = $filter($id);
			$this->db->where("$this->table_name"."."."$this->primary_key", $id);
			$method = 'row';
		}
		elseif ($single == TRUE) 
		{
			$method = 'row';
		}
		else
		{
			$method = 'result';
		}

		if (!count($this->db->ar_orderby)) 
		{
			$this->db->order_by($this->order_by);
		}

		$this->db->where("$this->table_name.is_actived", 1);
		$this->_db = $this->db->get($this->table_name);
		$result = $this->_db->$method();
		// $result = $this->db->get($this->table_name)->$method();

		$this->db->close();
		return $result;
	}

	public function get_by($where, $single = FALSE)
	{
		$this->db->where($where);
		
		return $this->get(NULL, $single);
	}

	public function count($where = NULL)
	{
		$this->db->from($this->table_name);

		if (isset($where))
		$this->db->where($where);

		if ($this->is_soft_delete())
		$this->db->where('is_actived', 1);

		$result = $this->db->count_all_results();
		$this->db->close();
		
		return $result;
	}

	public function protect_attribute($post)
	{
		if (is_array($post)) 
		{
			foreach ($this->protected_attribute as $attr) 
			{
				if (in_array($attr, $this->protected_attribute)) 
					unset($post[$attr]);
			}
		}

		return $post;
	}

	public function save($post, $id = NULL)
	{

		$post = $this->protect_attribute($post);

		# set timestamps
		if ($this->timestamps == TRUE) 
		{
			$now = date('Y-m-d H:i:s');
			$id || $post['created_at'] = $now;
			$post['updated_at'] = $now;
		}

		// table field filter
		// if ($post == FALSE) 
		// {
		// 	!count($this->fillable)	|| $post = $this->fillableFromArray($post);
		// }

		if ($post == FALSE) 
		{
			return FALSE;
		}

		if ($id === NULL) 
		{
			!isset($post[$this->primary_key]) || $post[$this->primary_key] = NULL;

			# This is an insert
			$this->db->insert($this->table_name, $post);
			$id = $this->db->insert_id();
			
			// log
			$msg = "Record Id $id has been successfully saved.";
		}
		else
		{
			$filter = $this->primary_filter;
			
			# This is an update
			$this->db->where($this->primary_key, $filter($id))->update($this->table_name, $post);
			
			// log
			$msg = "Record Id $id has been successfully updated.";
		}

		// flash data
		$this->db->flush_cache();
		$this->session->set_flashdata('id', $id);
		$this->session->set_flashdata('error', $msg);

		// Return the ID
		return $id === NULL ? $this->db->insert_id() : $id;
	}

	public function delete_by($where, $single = FALSE)
	{

		if (empty($where)) 
		{
			return FALSE;
		}

		$this->db->set('is_actived', 0);
		$this->db->set('deleted_at', date('Y-m-d H:i:s'));
		$this->db->where($where);

		if ($this->soft_delete === TRUE) 
		{
			$this->db->update($this->table_name);
			$this->db->flush_cache();

			return $this->db->affected_rows();
		}
		else
		{
			$this->session->set_flashdata('error', "Sorry this application can not perform a batch permanently deletion.<br/>If still want to continue you have to removed it individually.");
			$this->db->flush_cache();
			return FALSE;
		}
	}

	public function delete($id)
	{
		$filter = $this->primary_filter;
		$id = $filter($id);

		if (!$id) 
		{
			return FALSE;
		}

		
		$this->db->set('is_actived', 0);
		$this->db->set('deleted_at', date('Y-m-d H:i:s'));
		$this->db->where($this->primary_key, $id);
		$this->db->limit(1);

		if ($this->soft_delete === TRUE) 
		{
			
			$this->db->update($this->table_name);
			$this->db->flush_cache();

			$this->session->set_flashdata('id', $id);
			$this->session->set_flashdata('error', "Record id $id has been successfully deleted.");
		}
		else
		{
			$this->session->set_flashdata('error', "Record id $id has been permanently deleted.");
			$this->db->flush_cache();

			$this->session->set_flashdata('id', $id);
			$this->db->delete($this->table_name);
		}

	}


	/**
     * A method to facilitate easy bulk inserts into a given table.
     * @param string $table_name
     * @param array $column_names A basic array containing the column names
     *  of the data we'll be inserting
     * @param array $rows A two dimensional array of rows to insert into the
     *  database.
     * @param bool $escape Whether or not to escape data
     *  that will be inserted. Default = true.
     * @author Kenny Katzgrau <katzgrau@gmail.com>
     */

    public function insert_rows($column_names, $rows, $escape = true)
    {
        /* Build a list of column names */
        $columns    = array_walk($column_names, array($this, 'prepare_column_name') );
        $columns    = implode(',', $column_names);

        /* Escape each value of the array for insertion into the SQL string */
        if( $escape ) array_walk_recursive( $rows, array( $this, 'escape_value' ) );

        /* Collapse each rows of values into a single string */
        $length = count($rows);
        for($i = 0; $i < $length; $i++) $rows[$i] = implode(',', $rows[$i]);

        /* Collapse all the rows into something that looks like
         *  (r1_val_1, r1_val_2, ..., r1_val_n),
         *  (r2_val_1, r2_val_2, ..., r2_val_n),
         *  ...
         *  (rx_val_1, rx_val_2, ..., rx_val_n)
         * Stored in $values
         */
        $values = "(" . implode( '),(', $rows ) . ")";

        $sql = "INSERT INTO $this->table_name ( $columns ) VALUES $values";

        return $this->db->simple_query($sql);
    }


    /**
     * public function fields($fields)
     * does a select() of the $fields
     * @param $fields the fields needed
     * @return $this
     */
    public function fields($fields = NULL)
    {
        if(isset($fields))
        {
            if($fields == '*count*')
            {
                $this->_select = '';
                $this->_database->select('COUNT(*) AS counted_rows',FALSE);
            }
            else
            {
                $this->_select = array();
                $fields = (!is_array($fields)) ? explode(',', $fields) : $fields;
                if (!empty($fields))
                {
                    foreach ($fields as &$field)
                    {
                        $exploded = explode('.', $field);
                        if (sizeof($exploded) < 2)
                        {
                            $field = $this->table . '.' . $field;
                        }
                    }
                }
                $this->_select = $fields;
            }
        }
        else
        {
            $this->_select = NULL;
        }
        return $this;
    }

    /**
     * public function limit($limit, $offset = 0)
     * Sets a rows limit to the query
     * @param $limit
     * @param int $offset
     * @return $this
     */
    public function limit($limit, $offset = 0)
    {
        $this->_database->limit($limit, $offset);
        return $this;
    }

    /**
     * public function group_by($grouping_by)
     * A wrapper to $this->_database->group_by()
     * @param $grouping_by
     * @return $this
     */
    public function group_by($grouping_by)
    {
        $this->_database->group_by($grouping_by);
        return $this;
    }

    /**
     * public function order_by($criteria, $order = 'ASC'
     * A wrapper to $this->_database->order_by()
     * @param $criteria
     * @param string $order
     * @return $this
     */
    public function order_by($criteria, $order = 'ASC')
    {
        if(is_array($criteria))
        {
            foreach ($criteria as $key=>$value)
            {
                $this->_database->order_by($key, $value);
            }
        }
        else
        {
            $this->_database->order_by($criteria, $order);
        }
        return $this;
    }

    /**
     * public function on($connection_group = NULL)
     * Sets a different connection to use for a query
     * @param $connection_group = NULL - connection group in database setup
     * @return obj
     */
    public function on($connection_group = NULL)
    {
        if(isset($connection_group))
        {
            $this->_database->close();
            $this->load->database($connection_group);
            $this->_database = $this->db;
        }
        return $this;
    }

    /**
     * public function reset_connection($connection_group = NULL)
     * Resets the connection to the default used for all the model
     * @return obj
     */
    public function reset_connection()
    {
        if(isset($connection_group))
        {
            $this->_database->close();
            $this->_set_connection();
        }
        return $this;
    }

    /**
     * Trigger an event and call its observers. Pass through the event name
     * (which looks for an instance variable $this->event_name), an array of
     * parameters to pass through and an optional 'last in interation' boolean
     */
    public function trigger($event, $data = array(), $last = TRUE)
    {
        if (isset($this->$event) && is_array($this->$event))
        {
            foreach ($this->$event as $method)
            {
                if (strpos($method, '('))
                {
                    preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);
                    $method = $matches[1];
                    $this->callback_parameters = explode(',', $matches[3]);
                }
                $data = call_user_func_array(array($this, $method), array($data, $last));
            }
        }
        return $data;
    }

    /**
     * private function _set_connection()
     *
     * Sets the connection to database
     */
    private function _set_connection()
    {
        if(isset($this->_database_connection))
        {
            $this->_database = $this->load->database($this->_database_connection,TRUE);
        }
        else
        {
            $this->load->database();
            $this->_database =$this->db;
        }
        // This may not be required
        return $this;
    }


    function escape_value(& $value)
    {
        if( is_string($value) )
        {
            $value = "'" . mysql_real_escape_string($value) . "'";
        }
    }

    function prepare_column_name(& $name)
    {
        $name = "`$name`";
    }


}

/*Location: ./application/models/MY_Model.php*/