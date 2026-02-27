<?php
class MemberController extends Controller {

    public function index() {
        $memberModel = $this->model('MemberModel');

        $q = $_GET['q'] ?? '';
        if ($q !== '') {
            $members = $memberModel->search($q);
        } else {
            $members = $memberModel->all();
        }

        $this->view('member', [
            'members' => $members
        ]);
    }


    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /member/index");
            exit;
        }

        $memberModel = $this->model('MemberModel');
        $avatarPath = null;

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
            $targetDir = 'image/member/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $fileName = time() . '_' . basename($_FILES['avatar']['name']);
            $targetPath = $targetDir . $fileName;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                $avatarPath = $targetPath;
            }
        }

        $memberModel->create([
            'gen'       => $_POST['gen'],
            'name'      => $_POST['name'],
            'branch'    => $_POST['branch'] ?? null,
            'birth'     => $_POST['birth'] ?? null,
            'death'     => $_POST['death'] ?? null,
            'spouse'    => $_POST['spouse'] ?? null,
            'father_id' => $_POST['father_id'] ?? null,
            'note'      => $_POST['note'] ?? null,
            'avatar'    => $avatarPath
        ]);

        header("Location: /member/index");
        exit;
    }

    public function edit($id) {
        $memberModel = $this->model('MemberModel');
        $editMember = $memberModel->find($id);

        if (!$editMember) {
            header("Location: /member/index");
            exit;
        }

        $members = $memberModel->all();

        $this->view('member', [
            'members' => $members,
            'editMember' => $editMember
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /member/index");
            exit;
        }

        $memberModel = $this->model('MemberModel');
        $currentMember = $memberModel->find($id);

        if (!$currentMember) {
            header("Location: /member/index");
            exit;
        }

        $avatarPath = $currentMember['avatar'];

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
            $targetDir = 'image/member/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $fileName = time() . '_up_' . basename($_FILES['avatar']['name']);
            $targetPath = $targetDir . $fileName;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                if (!empty($currentMember['avatar']) && file_exists($currentMember['avatar'])) {
                    unlink($currentMember['avatar']);
                }
                $avatarPath = $targetPath;
            }
        }

        $memberModel->updateMember($id, [
            'gen'       => $_POST['gen'],
            'name'      => $_POST['name'],
            'branch'    => $_POST['branch'] ?? null,
            'birth'     => $_POST['birth'] ?? null,
            'death'     => $_POST['death'] ?? null,
            'spouse'    => $_POST['spouse'] ?? null,
            'father_id' => $_POST['father_id'] ?? null,
            'note'      => $_POST['note'] ?? null,
            'avatar'    => $avatarPath
        ]);

        header("Location: /member/index");
        exit;
    }

    public function delete($id) {
        $memberModel = $this->model('MemberModel');
        $member = $memberModel->find($id);

        if ($member) {
            if (!empty($member['avatar']) && file_exists($member['avatar'])) {
                unlink($member['avatar']);
            }
            $memberModel->delete($id);
        }

        header("Location: /member/index");
        exit;
    }
}
?>