<?php
class UserController extends Controller {

    public function index() {
        $userModel = $this->model('UserModel');
        $users = $userModel->all();

        $this->view('admin/user/index', [
            'users' => $users
        ]);
    }

    public function create() {
        $this->view('admin/user/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /user/index");
            exit;
        }

        $userModel = $this->model('UserModel');
        $avatarPath = 'image/avatar/default.png';

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
            $targetDir = 'image/avatar/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $fileName = time() . '_' . basename($_FILES['avatar']['name']);
            $targetPath = $targetDir . $fileName;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                $avatarPath = $targetPath;
            }
        }

        $userModel->create([
            'full_name'     => $_POST['full_name'],
            'email'         => $_POST['email'], 
            'password'      => $_POST['password'],
            'phone'         => $_POST['phone'] ?? null,
            'address'       => $_POST['address'] ?? null,
            'avatar'        => $avatarPath,
            'auth_provider' => 'local',
            'google_id'     => null
        ]);

        header("Location: /user/index");
        exit;
    }

    public function edit($id) {
        $userModel = $this->model('UserModel');
        $user = $userModel->find($id);

        if (!$user) {
            header("Location: /user/index");
            exit;
        }

        $this->view('admin/user/edit', [
            'user' => $user
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /user/index");
            exit;
        }

        $userModel = $this->model('UserModel');
        $currentUser = $userModel->find($id);

        if (!$currentUser) {
            header("Location: /user/index");
            exit;
        }

        $avatarPath = $currentUser['avatar'];

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
            $targetDir = 'image/avatar/';
            $fileName = time() . '_up_' . basename($_FILES['avatar']['name']);
            $targetPath = $targetDir . $fileName;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                if ($currentUser['avatar'] !== 'image/avatar/default.png' && file_exists($currentUser['avatar'])) {
                    unlink($currentUser['avatar']);
                }
                $avatarPath = $targetPath;
            }
        }

        $userModel->update($id, [
            'full_name' => $_POST['full_name'],
            'email'     => $_POST['email'],
            'password'  => $_POST['password'],
            'phone'     => $_POST['phone'] ?? null,
            'address'   => $_POST['address'] ?? null,
            'avatar'    => $avatarPath
        ]);

        header("Location: /user/index");
        exit;
    }

    public function delete($id) {
        $userModel = $this->model('UserModel');
        $user = $userModel->find($id);

        if ($user) {
            if ($user['avatar'] !== 'image/avatar/default.png' && file_exists($user['avatar'])) {
                unlink($user['avatar']);
            }
            $userModel->delete($id);
        }

        header("Location: /user/index");
        exit;
    }
}