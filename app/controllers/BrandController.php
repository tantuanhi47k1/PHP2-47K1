<?php
class BrandController extends Controller {

    public function index() {
        $brandModel = $this->model('BrandModel');
        $brands = $brandModel->all(); 
        $this->view('admin/brand/index', ['brands' => $brands]);
    }

    public function create() {
        $this->view('admin/brand/create');
    }

    public function store() {
        $brandModel = $this->model('BrandModel');
        $logoPath = ''; 

        if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
            $targetDir = 'image/brand/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $fileName = time() . '_' . basename($_FILES['logo']['name']);
            $targetPath = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath)) {
                $logoPath = $targetPath;
            }
        }

        $brandData = [
            'name'        => $_POST['name'],
            'logo'        => $logoPath,
            'description' => $_POST['description'] ?? ''
        ];

        $brandModel->create($brandData);
        header("Location: /brand");
    }

    public function edit($id) {
        $brand = $this->model('BrandModel')->find($id);
        $this->view('admin/brand/edit', ['brand' => $brand]);
    }

    public function update($id) {
        $brandModel = $this->model('BrandModel');
        $oldBrand = $brandModel->find($id);
        $logoPath = $oldBrand['logo'];

        if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
            $targetDir = 'image/brand/';
            $fileName = time() . '_' . basename($_FILES['logo']['name']);
            $targetPath = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath)) {
                $logoPath = $targetPath;
            }
        }

        $brandData = [
            'name'        => $_POST['name'],
            'logo'        => $logoPath,
            'description' => $_POST['description']
        ];

        $brandModel->update($id, $brandData);
        header("Location: /brand");
    }

    public function delete($id) {
    $brandModel = $this->model('BrandModel');
    
    $brand = $brandModel->find($id);

    if ($brand) {
        $imagePath = $brand['logo'];
        if (!empty($imagePath) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $brandModel->delete($id);
    }

    header("Location: /brand");
    exit;
}
}