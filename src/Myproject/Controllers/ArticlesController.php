<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\UsersAuthService;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Exceptions\ForbiddenException;


class ArticlesController extends AbstractController
{

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        /*$reflector = new \ReflectionObject($article);
        $properties = $reflector->getProperties();
        $propertiesNames = [];
        foreach ($properties as $property) {
            $propertiesNames[] = $property->getName();
        }
        var_dump($propertiesNames);
        return;*/

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
        ]);
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    public function add(): void
    {
        /*$author = User::getById(1);

        $article = new Article();
        $article->setAuthor($author);
        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');

        $article->save();

        $article->delete();

        var_dump($article);*/

        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException();
        }

        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/add.php');
    }

    public function delete(int $articleId): void
    {
        $article = Article::getById($articleId);
        if ($article === null) {
            echo 'Статьи с таким id не существует!';
            return;
        }
        echo (var_dump($article) . "\n succesfully deleted");
        $article->delete();
    }
}