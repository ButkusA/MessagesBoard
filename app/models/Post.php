<?php
defined('CORE_PATH') or exit('no access');
require_once CORE_PATH . '/AutoLoader.php';
require_once APP_PATH . '/config.php';

/**
 * Class Post to deal with data between
 * the form input and db selection for visualisation
 */
class Post
{

    private $validator;//validation class object
    private $db;//database class object
    private $autoload;//autoload obj
    private $validationErrors;//an array to store validation errors from input

    public function __construct()
    {
        $this->autoload = new AutoLoader();
        $this->autoload->load('Validator', 'model');
        $this->autoload->load('Database', 'core');
        $this->db = new Database();
    }

    public function savePost($request)
    {
        $this->validator = new Validator($request);
        $this->validationErrors = $this->validator->getErrors();
        if (empty($this->validationErrors)) {
            $result = $this->db->insert(TABLE, $this->validator->getUser());
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } else {
            return $this->validationErrors;
        }
    }

    public function getAll()
    {
        return $this->db->select(TABLE);
    }

    //Selecting post limit for one page
    public function getLimitForPage($start, $end)
    {
        return $this->db->select(TABLE, 'LIMIT ' . $start . ', ' . $end);
    }

    //selecting the newest pos for js operations
    public function getNewestPost()
    {
        return $this->db->select(TABLE, ' ORDER by time DESC LIMIT 1');
    }

    //selecting the lowest post id for js operations
    public function getOldestPost()
    {
        return $this->db->select(TABLE, 'ORDER BY ID DESC', 'MIN(ID)');
    }
}