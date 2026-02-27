<?php
class CategoryController extends Controller
{
    public function index()
    {
        $categoryModel = $this->model('CategoryModel');
        $data = $categoryModel->all();
        $this->view('admin/category/index', ['categories' => $data]);
    }

    public function create()
    {
        $categories = $this->model('CategoryModel')->all();
        $this->view('admin/category/create', ['categories' => $categories]);
    }

    public function store()
    {
        if (empty($_POST['name']) || strlen($_POST['name']) < 3) {
            $mess = "Tên danh mục không hợp lệ!";
            $this->view('admin/category/create', [
                'mess' => $mess,
                'categories' => $this->model('CategoryModel')->all()
            ]);
            return;
        }

        $slug = $this->vn_to_str($_POST['name']);

        $parentId = $_POST['parent_id'] ?? null;
        $parentId = (empty($parentId) || $parentId == '0') ? null : $parentId;

        $data = [
            'name'      => $_POST['name'],
            'slug'      => $slug,
            'parent_id' => $parentId
        ];

        $this->model('CategoryModel')->create($data);
        header("Location: /category");
        exit;
    }

    public function edit($id)
    {
        $categoryModel = $this->model('CategoryModel');
        $category = $categoryModel->find($id);
        $categories = $categoryModel->all();

        $this->view('admin/category/edit', [
            'category' => $category,
            'categories' => $categories
        ]);
    }

    public function update($id)
    {
        if (empty($_POST['name']) || strlen($_POST['name']) < 3) {
            header("Location: /category/edit/$id?error=Tên không hợp lệ");
            return;
        }

        $slug = $this->vn_to_str($_POST['name']);

        $parentId = $_POST['parent_id'] ?? null;
        $parentId = (empty($parentId) || $parentId == '0') ? null : $parentId;

        $data = [
            'name'      => $_POST['name'],
            'slug'      => $slug,
            'parent_id' => $parentId
        ];

        $this->model('CategoryModel')->update($id, $data);
        header("Location: /category");
        exit;
    }

    public function delete($id)
    {
        $this->model('CategoryModel')->delete($id);
        header("Location: /category");
        exit;
    }

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
        $str = trim($str);
        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        $str = str_replace(' ','-',$str);
        $str = preg_replace('/[^a-zA-Z0-9\-\_]/', '', $str);
        return strtolower($str);
    }
}