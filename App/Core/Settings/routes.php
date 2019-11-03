<?php
use Core\Router;

// article
Router::add('articles', 'ArticleController', 'allArticlesAction');
Router::add('article/create', 'ArticleController', 'createAction');
Router::add('article/{id:\d+}/delete', 'ArticleController', 'deleteAction');
Router::add('article/{id:\d+}/page', 'ArticleController', 'articlePageAction');
Router::add('article/{id:\d+}/update', 'ArticleController', 'updateAction');
Router::add('article/{id:\d+}/add-like', 'ArticleController', 'addLikeAction');

// user
Router::add('user/register', 'UserController', 'signUpAction');
Router::add('user/login', 'UserController', 'signInAction');
Router::add('user/logout', 'UserController', 'logoutAction');
