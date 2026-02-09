<?php
class AttributeController extends Controller {

    public function index() {
        $attrModel = $this->model('AttributeModel');

        $attributes = $attrModel->allWithValues();
        
        $this->view('admin/attribute/index', [
            'attributes' => $attributes
        ]);
    }

    public function storeAttribute() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name'])) {
            $this->model('AttributeModel')->createAttribute(trim($_POST['name']));
            $_SESSION['success'] = "Đã thêm loại thuộc tính mới!";
        }
        header("Location: /attribute/index");
        exit;
    }

    public function storeValue() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['attribute_id']) && !empty($_POST['value'])) {
            $this->model('AttributeModel')->createValue($_POST['attribute_id'], trim($_POST['value']));
            $_SESSION['success'] = "Đã thêm giá trị mới!";
        }
        header("Location: /attribute/index");
        exit;
    }

    public function deleteAttribute($id) {
        $this->model('AttributeModel')->deleteAttribute($id);
        $_SESSION['success'] = "Đã xóa loại thuộc tính!";
        header("Location: /attribute/index");
        exit;
    }

    public function deleteValue($id) {
        $conn = (new Model())->connect();
        $stmt = $conn->prepare("SELECT * FROM attribute_values WHERE id = ?");
        $stmt->execute([$id]);
        $val = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($val) {
            if (strtolower($val['value']) === 'none') {
                $_SESSION['error'] = "CẢNH BÁO: Không thể xóa giá trị mặc định [None]!";
                header("Location: /attribute/index");
                exit;
            }
        }

        $this->model('AttributeModel')->deleteValue($id);
        
        $_SESSION['success'] = "Đã xóa giá trị thuộc tính!";
        header("Location: /attribute/index");
        exit;
    }
}