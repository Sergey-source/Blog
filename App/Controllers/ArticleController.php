<?php
use App\Controllers\BaseController;
use App\Models\ArticleModel;
use App\Forms\CreateArticleForm;
use App\Forms\UpdateArticleForm;

class ArticleController extends BaseController
{
    private $model;

    public function __construct($user)
    {
        parent::__construct($user);
        $this->model = new ArticleModel();
    }

    public function allArticlesAction($request)
    {
        $articles = $this->model->getAllArticles();
        $this->view->render('allArticles.html', ['articles' => $articles]);
    }

    public function createAction($request)
    {
        if ($request->method == 'GET')
        {
            $form = new CreateArticleForm();
            $this->view->render('createArticleForm.html', ['form' => $form]);
        }

        if ($request->method == 'POST')
        {
            $form = new CreateArticleForm($request->POST);

            if ($form->isValid()) {
                $title = $form->cleaned_data['title'];
                $body = $form->cleaned_data['body'];
                $this->model->create($title, $body);

                header('Location: http://localhost/articles ');
            }
        }
    }

    public function deleteAction($request, $id)
    {
        if ($this->model->delete($id)) {
            header('Location: http://localhost/articles ');
        } else {
            $this->errorHandler->error404();
        }
    }

    public function articlePageAction($request, $id)
    {
        if ($article = $this->model->getArticle($id)) {
            $this->view->render('articlePage.html', ['article' => $article]);
        } else {
            $this->errorHandler->error404();
        }
    }

    public function updateAction($request, $id)
    {
        if ($request->method == 'GET')
        {
            if ($article = $this->model->getById($id)) {
                $form = new UpdateArticleForm();
                $form->setValues([
                    'title' => $article['title'],
                    'body' => $article['body']
                ]);

                $this->view->render('updateArticleForm.html', ['form' => $form, 'article_id' => $article['id']]);
            } else {
                $this->errorHandler->error404();
            }
        }

        if ($request->method == 'POST')
        {
            $form = new UpdateArticleForm($request->POST);

            if ($form->isValid()) {
                $title = $form->cleaned_data['title'];
                $body = $form->cleaned_data['body'];

                $this->model->update($title, $body, $id);
                header('Location: http://localhost/articles ');
            }
        }
    }

    public function addLikeAction($request, $article_id)
    {
        $user_id = $request->user->get('id');

        if ($this->model->userLiked($article_id, $user_id)) {
            $this->model->deleteLike($article_id, $user_id);
        } else {
            $this->model->addLike($article_id, $user_id);
        }

        $redirect = sprintf('Location: http://localhost/article/%d/page ', $article_id);
        header($redirect);
    }

}
