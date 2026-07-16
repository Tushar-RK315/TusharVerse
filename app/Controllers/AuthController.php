<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Controllers;

use TusharRk315\Tusharverse\Core\Controller;
use TusharRk315\Tusharverse\Core\Request;
use TusharRk315\Tusharverse\Core\Response;
use TusharRk315\Tusharverse\Core\Validator;
use TusharRk315\Tusharverse\Core\Flash;
use TusharRk315\Tusharverse\Core\Session;
use TusharRk315\Tusharverse\Repositories\UserRepository;
use TusharRk315\Tusharverse\Core\Csrf;

class AuthController extends Controller
{   
    public function login(): void
    {
        $this->view('auth/login');
    }

    public function register(): void
    {
        $this->view('auth/register');
    }

    public function forgotPassword(): void
    {
        $this->view('auth/forgot-password');
    }

    public function resetPassword(): void
    {
        $this->view('auth/reset-password');
    }

    public function authenticate(): void
    {
        $request = new Request();
        $response = new Response();
        $validator = new Validator();

        $email = trim((string) $request->post('email'));
        $password = (string) $request->post('password');

        $token = (string) $request->post('_token');

        if (!Csrf::verify($token)) {

        Flash::set('errors', json_encode([
            'csrf' => ['Invalid CSRF token.']
        ]));

        $response->redirect('/login');
        return;
        }

        $validator
            ->required('email', $email)
            ->email('email', $email)
            ->required('password', $password);

        if ($validator->fails()) {
            Session::flash('old.email', $email);
            Flash::set('errors', json_encode($validator->errors()));
            $response->redirect('/login');
            return;
        }

        $userRepository = new UserRepository();

        $user = $userRepository->findByEmail($email);

        if (!$user) {
            Session::flash('old.email', $email);
            Flash::set('errors', json_encode([
                'email' => ['Email does not exist.']
            ]));

            $response->redirect('/login');
            return;
        }

        if (!password_verify($password, $user['password'])) {
            Session::flash('old.email', $email);
            Flash::set('errors', json_encode([
                'password' => ['Incorrect password.']
            ]));

            $response->redirect('/login');
            return;
        }
        
        Session::regenerate();
        Session::set('user', [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
        ]);

        Flash::set('success', 'Login successful.');
        $response->redirect('/dashboard');
    }

    public function registerPost(): void
    {
        $request = new Request();
        $response = new Response();

        $name = trim((string) $request->post('name'));
        $email = trim((string) $request->post('email'));
        $password = (string) $request->post('password');
        $confirmPassword = (string) $request->post('confirm_password');

        $token = (string) $request->post('_token');

        if (!Csrf::verify($token)) {

            Flash::set('errors', json_encode([
                'csrf' => ['Invalid CSRF token.']
            ]));

            $response->redirect('/register');
            return;
        }


        $validator = new Validator();

        $validator
            ->required('name', $name)
            ->required('email', $email)
            ->email('email', $email)
            ->required('password', $password)
            ->min('password', $password, 6)
            ->required('confirm_password', $confirmPassword);

        if ($password !== $confirmPassword) {
            $validator->addError('confirm_password', 'Passwords do not match.');
        }

        $userRepository = new UserRepository();

        if ($userRepository->findByEmail($email)) {
            $validator->addError('email', 'Email already exists.');
        }

        if ($validator->fails()) {
            Session::flash('old.name', $name);
            Session::flash('old.email', $email);

            Flash::set('errors', json_encode($validator->errors()));

            $response->redirect('/register');
            return;
        }

        if (!$userRepository->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ])) {
            Session::flash('old.name', $name);
            Session::flash('old.email', $email);

            Flash::set('errors', json_encode([
                'general' => ['Unable to create account. Please try again.']
            ]));

            $response->redirect('/register');
            return;
        }

        Flash::set('success', 'Registration successful. Please log in.');
        $response->redirect('/login');
    }

        public function logout(): void
    {
        Session::destroy();

        Flash::set('success', 'Logged out successfully.');

        (new Response())->redirect('/login');
    }
}