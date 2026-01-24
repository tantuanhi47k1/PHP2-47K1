<?php
class ColorController extends Controller
{

    public function index()
    {
        $colorModel = $this->model('ColorModel');
        $data = $colorModel->all();
        $title = "Quản lý màu sắc";
        $this->view('admin/product/color/index', ['title' => $title, 'colors' => $data]);
    }

    public function create()
    {
        $this->view('admin/product/color/create');
    }

    public function store()
    {
        if (empty($_POST['name']) || strlen($_POST['name']) < 2 || strlen($_POST['name']) > 50) {
            $mess = "Tên màu sắc không được để trống, không ít hơn 2 hoặc nhiều hơn 50 ký tự";
            $this->view('/product/color/create', ['mess' => $mess]);
            return;
        }

        $colorModel = $this->model('ColorModel');

        $data = [
            'name' => $_POST['name'],
        ];

        $colorModel->create($data);

        header("Location: /color");
    }

    public function edit($id)
    {

        $colorModel = $this->model('ColorModel');
        $color = $colorModel->find($id);

        $this->view('admin/product/color/edit', ['item' => $color]);
    }

    public function update($id)
    {
        if (empty($_POST['name']) || strlen($_POST['name']) < 2 || strlen($_POST['name']) > 50) {
            $mess = "Tên màu sắc không hợp lệ!";
            $colorModel = $this->model('ColorModel');
            $color = $colorModel->find($id);
            $this->view('admin/product/color/edit', ['item' => $color, 'mess' => $mess]);
            return;
        }

        $colorModel = $this->model('ColorModel');

        $data = [
            'name' => $_POST['name']
        ];

        $colorModel->update($id, $data);

        header("Location: /color");
    }

    public function delete($id)
    {
        $colorModel = $this->model('ColorModel');
        $colorModel->delete($id);

        header("Location: /color");
    }
}
