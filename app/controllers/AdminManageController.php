<?php
class AdminManageController extends Controller {

    public function index() {
        $admins = $this->model('AdminModel')->all();
        $this->view('admin/adminmanage/index', ['admins' => $admins]);
    }

    public function create() {
        $this->view('admin/adminmanage/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $avatarPath = 'image/avatar/admin-default.png';

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                $targetDir = 'image/avatar/admins/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
                
                $fileName = time() . '_' . basename($_FILES['avatar']['name']);
                $avatarPath = $targetDir . $fileName;
                move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarPath);
            }

            $this->model('AdminModel')->create([
                'username' => $_POST['username'],
                'email'    => $_POST['email'],
                'password' => $_POST['password'],
                'role'     => (int)$_POST['role'],
                'avatar'   => $avatarPath
            ]);

            header("Location: /adminmanage/index");
            exit;
        }
    }

    public function edit($id) {
        $admin = $this->model('AdminModel')->find($id);
        if (!$admin) {
            header("Location: /adminmanage/index");
            exit;
        }
        $this->view('admin/adminmanage/edit', ['admin' => $admin]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminModel = $this->model('AdminModel');
            $currentAdmin = $adminModel->find($id);
            $avatarPath = $currentAdmin['avatar'];

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                $targetPath = 'image/avatar/admins/' . time() . '_' . $_FILES['avatar']['name'];
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                    if ($avatarPath !== 'image/avatar/admin-default.png' && file_exists($avatarPath)) {
                        unlink($avatarPath);
                    }
                    $avatarPath = $targetPath;
                }
            }

            $adminModel->update($id, [
                'username' => $_POST['username'],
                'email'    => $_POST['email'],
                'password' => $_POST['password'],
                'role'     => (int)$_POST['role'],
                'avatar'   => $avatarPath
            ]);

            header("Location: /adminmanage/index");
            exit;
        }
    }

    public function delete($id) {
        $this->model('AdminModel')->delete($id);
        header("Location: /adminmanage/index");
    }
}