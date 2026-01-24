<?php
class BrandController extends Controller {

    // lấy ds brand
    public function index() {
        $brandModel = $this->model('BrandModel');
        $data = $brandModel->all();
        $this->view('/admin/brand/index', ['brands' => $data]);
    }

    // tạo brand
    public function create() {
        $this->view('admin/brand/create');
    }

    public function store() {
        $imagePath = ''; 

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = 'image/brand/';
            
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true); 
            }

            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath;
            }
        }

        // slug chuẩn tiếng Việt
        $slug = !empty($_POST['slug']) ? $this->vn_to_str($_POST['slug']) : $this->vn_to_str($_POST['name']);

        $data = [
            'name' => $_POST['name'],
            'slug' => $slug,
            'image' => $imagePath, 
            'status' => $_POST['status']
        ];

        $this->model('BrandModel')->create($data);
        header("Location: /brand");
    }

    public function edit($id) {
        $brand = $this->model('BrandModel')->find($id);
        $this->view('admin/brand/edit', ['brand' => $brand]);
    }

    public function update($id) {
        $brandModel = $this->model('BrandModel');
        
        $currentBrand = $brandModel->find($id);
        $imagePath = $currentBrand['image']; 

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            
            $targetDir = 'image/brand/';
            
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true); 
            }

            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                if (!empty($imagePath) && file_exists($imagePath)) {
                    unlink($imagePath);
                }
                
                $imagePath = $targetFilePath;
            }
        }

        $slug = !empty($_POST['slug']) ? $this->vn_to_str($_POST['slug']) : $this->vn_to_str($_POST['name']);

        $data = [
            'name' => $_POST['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'status' => $_POST['status']
        ];

        $brandModel->update($id, $data);
        header("Location: /brand");
    }

    public function delete($id) {
        $brandModel = $this->model('BrandModel');
        $brandModel->delete($id);
        header("Location: /brand");
    }

    // chuyển slug có dấu => ko dấu
    private function vn_to_str($str) {
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        
        // loại bỏ khoảng trắnhg
        $str = trim($str);

        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        
        // thay khoảng trắng bằng -
        $str = str_replace(' ','-',$str);
        
        // delete ktđb
        $str = preg_replace('/[^a-zA-Z0-9\-\_]/', '', $str);
        
        return strtolower($str);
    }
}