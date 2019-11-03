<?php
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Forms\SignUpForm;
use App\Forms\SignInForm;

class UserController extends BaseController
{
    public function __construct($user)
    {
        parent::__construct($user);
        $this->model = new UserModel();
    }

    public function signUpAction($request)
    {
        if ($request->method == 'GET')
        {
            $form = new SignUpForm();
            $this->view->render('user/signUpForm.html', ['form' => $form]);
        }

        if ($request->method == 'POST')
        {
            $form = new SignUpForm($request->POST);

            if ($form->isValid()) {
                $password = hash('sha256', $form->cleaned_data['password']);

                $this->model->signUp(
                    $form->cleaned_data['email'],
                    $password,
                    $form->cleaned_data['first_name'],
                    $form->cleaned_data['last_name']
                );
                
                header('Location: http://localhost/articles ');
            } else {
                $this->view->render('user/signUpForm.html', ['form' => $form]);
            }
        }
    }

    public function signInAction($request)
    {
        if ($request->method == 'GET')
        {
            $form = new SignInForm();
            $this->view->render('user/signInForm.html', ['form' => $form]);
        }

        if ($request->method == 'POST')
        {
            $form = new SignInForm($request->POST);

            if ($form->isValid()) {
                $password = hash('sha256', $form->cleaned_data['password']);

                $this->model->signIn(
                    $form->cleaned_data['email'],
                    $password,
                    $request->session
                );

                header('Location: http://localhost/articles ');
            }
        }
    }

    public function logoutAction($request)
    {
        $request->session->delete('user');
        header('Location: http://localhost/articles ');
    }
}
