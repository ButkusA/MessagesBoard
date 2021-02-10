<?php

class PostController extends controller
{
    private $post;
    private $result;

    public function __construct()
    {
        $this->post = $this->model('Post');
        if (isset($_POST)) {
            //Starting to validate
            $this->result = $this->post->savePost($_POST);
        }
    }
    /**
     * Controlling form action with redirection,
     * depending from validation result
     */
    public function index()
    {
        if ($this->result && !is_array($this->result)) {
            //Redirecting to index if no errors found
            header("Location: /MyMvc/public/");

        } else {
            //Redirecting to index with validation errors
            header("Location: /MyMvc/public/?" . http_build_query($this->result));
        }
    }
    /**
     * method to send a needed data for ajax
     */
    public function ajaxIndex()
    {
        if ($this->result && !is_array($this->result)) {
            $jsonArray = array(
                'status'=> 1,
                'all'=> $this->post->getAll(),
                'oldest' => $this->post->getOldestPost(),
                'newPost' => $this->post->getNewestPost()
            );
            //sending data to ajax
            header('Content-Type:application/json');
            echo json_encode($jsonArray);

        } else {
            header('Content-Type:application/json');
            //sending all errors to ajax
            echo json_encode($this->result);
        }
    }
}