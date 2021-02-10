<?php
defined('CORE_PATH') or exit('no access');

class Validator
{
    private $errors = [];
    private $user;
    private $age;

    public function __construct($request)
    {
        //prepare for validation, escape strings
        $newPost = array_map('htmlspecialchars', $request);
        //validate all input
        $this->checkEmail($newPost['email']);
        $this->checkDate($newPost['birthdate']);
        $this->checkMessage($newPost['message']);
        $this->checkName($newPost['fullname']);

        if (empty($this->errors)) {
            $this->setAge($newPost['birthdate']);
            //if all data is validated successfully, create user object
            $this->user = new User($newPost['fullname'], $this->age, $newPost['email'], $newPost['message']);
        }

    }

    public function getUser()
    {
        return $this->user;
    }

    private function checkEmail($email)
    {
        if (!empty($email)) {

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = 'Invalid email address';
            }
        }
    }

    private function checkName($name)
    {
        if (empty($name)) {
            $this->errors['fullname'] = 'Name is required';
        } else if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $this->errors['fullname'] = 'Incorrect full name, Only letters and space allowed';

        } else {

            $name = explode(' ', $name);
            if (empty($name[0]) || empty($name[1])) {
                $this->errors['fullname'] = 'Missing first or second name.';
            }

        }
    }


    private function checkDate($date)
    {
        if (empty($date)) {
            $this->errors['birthdate'] = 'Date is required';
        } elseif (!empty($date)) {
            $testArray = explode('/', $date);
            if (count($testArray) === 3) {
                if (checkdate($testArray[0], $testArray[1], $testArray[2])) {
                    $this->errors['birthdate'] = 'Date is invalid';
                }
            } else {
                $this->errors['birthdate'] = 'Date is too short';
            }
        }
    }

    private function setAge($date)
    {
        $from = new DateTime($date);
        $to = new DateTime('today');
        $this->age = $from->diff($to)->y;
    }

    private function checkMessage($message)
    {
        if (empty($message)) {
            $this->errors['message'] = 'Message field is required';
        } elseif (mb_strlen($message) > 800) {
            $this->errors['message'] = 'Message is too long. Only 800 characters is allowed';
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getAge()
    {
        return $this->age;
    }
}