<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Services\EmailSender;
use MyProject\Services\UsersAuthService;
use MyProject\Controllers\MainController;

class UsersController extends AbstractController
{
    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация', 'userActivation.php', [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
            }
        }

        $this->view->renderHtml('users/signUp.php');
    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::getById($userId);
        if (!empty($user)) {
            $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
            if ($isCodeValid) {
                $user->activate();
                $this->view->renderHtml('users/activationSuccessful.php');
                UserActivationService::clearActivationCode($user);
            }
            return;
        }
            
        $this->view->renderHtml('users/activationError.php');
        return;
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }   
        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        $user = UsersAuthService::getUserByToken();
        UsersAuthService::deleteToken();
        UsersAuthService::clearCookie();
        $user = null; 
        $this->view->renderHtml('users/logout.php');
    }
}