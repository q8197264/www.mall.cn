<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\NotifyService;

class UsersController extends Controller
{
    private $userService;
    private $emailService;

    public function __construct(UserService $userService, NotifyService $emailService)
    {
        $this->userService = $userService;
        $this->emailService = $emailService;
        echo '<pre>';
    }

    //
    public function index()
    {
        $this->userService->getAllUsers();

        var_dump(route('users.create'));
    }

    public function login()
    {
        $data = $this->userService->login();
        echo json_encode($data);
    }

    public function show()
    {
        $response = $this->userService->show();

        echo json_encode($response);
    }

    public function create()
    {
        echo 'create';
    }

    public function store()
    {
        echo 'I am store';
    }
    
    public function edit(int $id)
    {
        var_dump($id);
        echo 'edit';
        echo $this->userService->login();
        $this->emailService->send(['msg'=>'hello world']);
    }

    public function update(int $id)
    {
        var_dump($id);
    }

    public function destory($id)
    {
        var_dump($id);
    }
}
