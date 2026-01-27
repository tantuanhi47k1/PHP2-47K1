<?php
class BrandController extends Controller
{
    private $brandModel;

    public function __construct()
    {
        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] != 2) {
            header("Location: /auth/adminLogin");
            exit;
        }
        $this->brandModel = $this->model('BrandModel');
    }

    public function index()
    {
        $brands = $this->brandModel->all();
        $this->view('admin/brand/index', [
            'brands' => $brands
        ]);
    }

    public function create()
    {
        $this->view('admin/brand/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'        => $_POST['name'] ?? '',
                'logo'        => $_POST['logo'] ?? '',
                'description' => $_POST['description'] ?? ''
            ];

            $this->brandModel->create($data);
            $_SESSION['success'] = "Thêm thương hiệu thành công!";
            header("Location: /brand/index");
            exit;
        }
    }

    public function edit($id)
    {
        $brand = $this->brandModel->find($id);
        if (!$brand) {
            header("Location: /brand/index");
            exit;
        }
        $this->view('admin/brand/edit', ['brand' => $brand]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'        => $_POST['name'] ?? '',
                'logo'        => $_POST['logo'] ?? '',
                'description' => $_POST['description'] ?? ''
            ];

            $this->brandModel->update($id, $data);
            $_SESSION['success'] = "Cập nhật thương hiệu thành công!";
            header("Location: /brand/index");
            exit;
        }
    }

    public function delete($id)
    {
        $this->brandModel->delete($id);
        $_SESSION['success'] = "Đã xóa thương hiệu!";
        header("Location: /brand/index");
        exit;
    }
}