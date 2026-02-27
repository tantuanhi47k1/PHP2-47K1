<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Quản lý thành viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Quản lý thành viên</h4>
    <a class="btn btn-outline-secondary btn-sm" href="/member/index">Làm mới</a>
  </div>

  <?php 
    $isEdit = isset($editMember) && !empty($editMember); 
  ?>

  <!-- FORM: tạo/sửa -->
  <form method="post" action="<?php echo e($isEdit ? '/member/update/' . $editMember['id'] : '/member/store'); ?>" enctype="multipart/form-data" class="row g-3 mb-4">
    <div class="col-md-2">
      <label class="form-label">Đời *</label>
      <input type="number" name="gen" class="form-control" value="<?php echo e($isEdit ? $editMember['gen'] : ''); ?>" required>
    </div>

    <div class="col-md-5">
      <label class="form-label">Họ tên *</label>
      <input type="text" name="name" class="form-control" value="<?php echo e($isEdit ? $editMember['name'] : ''); ?>" required>
    </div>

    <div class="col-md-5">
      <label class="form-label">Chi/Nhánh</label>
      <input type="text" name="branch" class="form-control" value="<?php echo e($isEdit ? ($editMember['branch'] ?? '') : ''); ?>">
    </div>

    <div class="col-md-3">
      <label class="form-label">Năm sinh</label>
      <input type="number" name="birth" class="form-control" value="<?php echo e($isEdit ? ($editMember['birth'] ?? '') : ''); ?>">
    </div>

    <div class="col-md-3">
      <label class="form-label">Năm mất</label>
      <input type="number" name="death" class="form-control" value="<?php echo e($isEdit ? ($editMember['death'] ?? '') : ''); ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Vợ/Chồng</label>
      <input type="text" name="spouse" class="form-control" value="<?php echo e($isEdit ? ($editMember['spouse'] ?? '') : ''); ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Hình đại diện (tuỳ chọn)</label>
      <input type="file" name="avatar" class="form-control" accept="image/*">
      <div class="form-text">Backend nên giới hạn: jpg/png/webp, max 2MB.</div>
      
      <?php if($isEdit && !empty($editMember['avatar'])): ?>
          <div class="mt-2">
              <img src="/<?php echo e($editMember['avatar']); ?>" width="60" height="60" class="rounded object-fit-cover border">
          </div>
      <?php endif; ?>
    </div>

    <div class="col-md-6">
      <label class="form-label">Cha (ID)</label>
      <input type="text" name="father_id" class="form-control" value="<?php echo e($isEdit ? ($editMember['father_id'] ?? '') : ''); ?>">
    </div>

    <div class="col-12">
      <label class="form-label">Ghi chú</label>
      <textarea name="note" class="form-control" rows="2"><?php echo e($isEdit ? ($editMember['note'] ?? '') : ''); ?></textarea>
    </div>

    <div class="col-12">
      <button class="btn <?php echo e($isEdit ? 'btn-success' : 'btn-primary'); ?>"><?php echo e($isEdit ? 'Cập nhật' : 'Lưu'); ?></button>
      <?php if($isEdit): ?>
        <a href="/member/index" class="btn btn-outline-secondary">Huỷ</a>
      <?php else: ?>
        <button type="reset" class="btn btn-outline-secondary">Reset</button>
      <?php endif; ?>
    </div>
  </form>

  <!-- SEARCH: tìm kiếm danh sách -->
  <form method="get" action="/member/index" class="row g-2 align-items-end mb-3">
    <div class="col-sm-8 col-md-6">
      <label class="form-label">Tìm kiếm</label>
      <input type="text" name="q" class="form-control" placeholder="Tên / chi / đời / ghi chú..." value="<?php echo e($_GET['q'] ?? ''); ?>">
      </div>
    <div class="col-sm-4 col-md-2">
      <button class="btn btn-outline-primary w-100">Tìm</button>
    </div>
  </form>

  <!-- TABLE -->
  <div class="table-responsive">
    <table class="table table-bordered table-sm align-middle">
      <thead class="table-light">
        <tr>
          <th width="70">ID</th>
          <th width="70">Đời</th>
          <th width="70">Ảnh</th>
          <th>Họ tên</th>
          <th width="200">Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <!-- Backend loop -->
        <?php if(!empty($members)): ?>
            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($m['id']); ?></td>
              <td><?php echo e($m['gen']); ?></td>
              <td>
                <!-- Nếu có ảnh: -->
                <?php if(!empty($m['avatar'])): ?>
                  <img src="/<?php echo e($m['avatar']); ?>" alt="avatar" width="40" height="40" class="rounded object-fit-cover">
                <?php endif; ?>
                <!-- Nếu không có ảnh: để trống hoặc icon -->
                </td>
              <td><?php echo e($m['name']); ?></td>
              <td>
                <a class="btn btn-sm btn-outline-primary" href="/member/edit/<?php echo e($m['id']); ?>">Sửa</a>
                <form method="post" action="/member/delete/<?php echo e($m['id']); ?>" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xoá?');">
                  <button class="btn btn-sm btn-outline-danger">Xoá</button>
                </form>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center text-muted py-3">Không có dữ liệu</td>
            </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>
</body>
</html><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/member.blade.php ENDPATH**/ ?>