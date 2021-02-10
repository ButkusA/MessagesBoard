<?php
/**
 * class to control the pages
 * selection to see limited data on 1 page
 */

class Pagination
{
    //Total Data in the Message table
    private $total;
    //Records per page
    private $perPage;
    //Number of a current page
    private $pageNumber;
    //Pages available based on total and perPage;
    private $pages;

    /**
     * Pagination constructor.
     * @param $perPage - Number of records to return per page
     * @param $total - Total records in table
     */
    public function __construct($perPage, $total)
    {
        if (isset($_GET['page'])) {
            $this->pageNumber = $_GET['page'];
        } else {
            $this->pageNumber = 1;
        }
        $this->total = $total;
        $this->perPage = $perPage;
        $this->pages = ceil($this->total/$perPage);
        //$this->pageNumber = $this->changePage($pageNumber);
        $this->changePage();
    }
    public function changePage(){
        if ($this->pageNumber <= 0) {
            $this->pageNumber = 1;
        }

        // Maximum set number
        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        //return $this->pageNumber;
    }

    /**
     *Number of records to return per page
     */
    public function getCount(){
        //Return max number of records
        if($this->pages > 1) {
            if ($this->total > $this->perPage) {
                return $this->perPage;
            }
        }
        //If not, just return the last data
        return $this->total;
    }

    /**
     *Select index to start with data selection
     */
    public function getOffset(){
        $offset = $this->perPage * ($this->pageNumber - 1);
        if ($offset < 1){

            return 0;
        } else{
            return $offset;
        }
    }

    /**
     * Total number of pages available
     * @return int
     */
    public function getPages(){
        return $this->pages;
    }

    /**
     * Get the current page number
     * @return int
     */
    public function getPageNumber(){
        return $this->pageNumber;
    }
}