<?php

defined('CORE_PATH') or exit('no access');
require_once CORE_PATH . '/Pagination.php';

class HomeController extends Controller
{
    private $post;//post class object
    private $pagination; //pagination class object
    private $pageNumber;//current page number
    private $allPosts;

    public function __construct()
    {
        //Declaring posts class
        $this->post = $this->model('Post');
        $this->allPosts = $this->post->getAll();
        if(!empty($this->allPosts)){
            //Declaring pagination class to get all info about pages
            $this->pagination = new Pagination(LISTINPAGE, sizeof($this->allPosts));
        }

    }
    /**
     *Default view method
     */
    public function index()
    {
        if(!empty($this->allPosts)){
            $this->view('home/index', json_encode($this->post->getLimitForPage($this->pagination->getOffset(), $this->pagination->getCount())));
        }else{
            $this->view('home/index');
        }

    }

    public function getPages()
    {
        return $this->pagination->getPages();
    }

    public function getPNumber()
    {
        return $this->pageNumber;
    }

}