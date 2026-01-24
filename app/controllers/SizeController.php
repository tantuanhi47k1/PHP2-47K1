<?php
class SizeController extends Controller
{

    public function index()
    {
        $sizeModel = $this->model('SizeModel');
        $data = $sizeModel->all();
        $title = "Quản lý Size";
        $this->view('admin/product/size/index', ['title' => $title, 'sizes' => $data]);
    }

    public function create()
    {
        $this->view('admin/product/size/create');
    }

    public function store()
    {
        if (empty($_POST['name']) || strlen($_POST['name']) < 1 || strlen($_POST['name']) > 50) {
            $mess = "Tên Size không được để trống, không ít hơn 1 hoặc nhiều hơn 50 ký tự";
            $this->view('admin/product/size/create', ['mess' => $mess]);
            return;
        }

        $sizeModel = $this->model('SizeModel');

        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'status' => $_POST['status']
        ];

        $sizeModel->create($data);

        header("Location: /admin/product/size");
    }

    public function edit($id)
    {

        $sizeModel = $this->model('SizeModel');
        $size = $sizeModel->find($id);

        $this->view('admin/product/size/edit', ['size' => $size]);
    }

    public function update($id)
    {
        if (empty($_POST['name']) || strlen($_POST['name']) < 1 || strlen($_POST['name']) > 50) {
            $mess = "Tên Size không hợp lệ!";
            $sizeModel = $this->model('SizeModel');
            $size = $sizeModel->find($id);
            $this->view('admin/product/size/edit', ['size' => $size, 'mess' => $mess]);
            return;
        }

        $sizeModel = $this->model('SizeModel');
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'status' => $_POST['status']
        ];

        $sizeModel->update($id, $data);

        header("Location: /admin/product/size");
    }

    public function delete($id)
    {
        $sizeModel = $this->model('SizeModel');
        $sizeModel->delete($id);

        header("Location: /admin/product/size");
    }
}
