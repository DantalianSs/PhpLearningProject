<?php

namespace MyProject\Controllers;

use MyProject\Models\Users\User;
use MyProject\Services\UsersAuthService;
use MyProject\View\View;

abstract class AbstractController
{
    /** @var View */
    protected $view;

    /** @var User|null */
    protected $user;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        //if ($this->user->getAuthToken() !== '') {
            $this->view->setVar('user', $this->user);
            //return;
        //}
        $this->view->setVar('user', null);
    }

    protected function getInputData()
    {
        return json_decode(
            file_get_contents('php://input'),
            true
        );
    }
}