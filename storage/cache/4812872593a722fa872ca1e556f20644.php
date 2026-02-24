
<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --primary-color: #009981;
        }

        .text-brand {
            color: var(--primary-color) !important;
        }

        .btn-brand {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-brand:hover {
            background-color: #007a67;
            color: white;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #555;
        }

        .img-edit-preview {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
            transition: all 0.2s;
        }

        .image-container {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }

        .thumb-selector {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 5px;
            cursor: pointer;
        }
        
        .image-container:hover .img-edit-preview {
            border-color: var(--primary-color);
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-brand m-0">Cập nhật Sản phẩm #<?= $product['id'] ?></h4>
                    <a href="/product" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Quay lại</a>
                </div>

                <?php if(isset($mess)): ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><?= $mess ?></div>
                    </div>
                <?php endif; ?>
                
                <div id="ajax-alert" style="display:none;" class="alert alert-success align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i> <span id="ajax-msg"></span>
                </div>

                <form action="/product/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="card p-4">
                        <div class="row g-4">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                        value="<?= htmlspecialchars($product['name']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Giá bán gốc (VND) <span class="text-danger">*</span></label>
                                    <input type="number" name="base_price" class="form-control" required
                                        value="<?= $product['base_price'] ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mô tả ngắn</label>
                                    <textarea name="short_description" class="form-control" rows="2"><?= htmlspecialchars($product['short_description'] ?? '') ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mô tả chi tiết</label>
                                    <textarea name="description" class="form-control" rows="6"><?= htmlspecialchars($product['description']) ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-4">
                                    <label class="form-label">Album hình ảnh</label>
                                    <div class="alert alert-info small py-2">
                                        <i class="bi bi-info-circle"></i> Click vào nút tròn dưới ảnh để chọn làm ảnh đại diện.
                                    </div>
                                    
                                    <div class="row g-2 mb-3">
                                        <?php if(!empty($images)): ?>
                                            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-4 image-container text-center">
                                                    <img src="/<?= $img['image_path'] ?>" class="img-edit-preview">
                                                    
                                                    <div class="thumb-selector" onclick="selectThumbnail(this)">
                                                        <input class="form-check-input set-thumb-btn me-1" 
                                                               type="radio" 
                                                               name="thumbnail_selector" 
                                                               id="img_<?= $img['id'] ?>"
                                                               value="<?= $img['id'] ?>"
                                                               data-product-id="<?= $product['id'] ?>"
                                                               <?= $img['is_thumbnail'] ? 'checked' : '' ?>
                                                               style="cursor: pointer;">
                                                        <label class="form-check-label small" for="img_<?= $img['id'] ?>" style="cursor: pointer;">
                                                            Đại diện
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <div class="col-12"><small class="text-muted fst-italic">Chưa có ảnh nào.</small></div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <label class="form-label small text-muted">Thêm ảnh mới (chọn nhiều)</label>
                                    <input type="file" name="images[]" class="form-control form-control-sm" multiple accept="image/*">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select" required>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?= $c['id'] ?>"
                                                <?= $c['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($c['name']) ?>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Thương hiệu</label>
                                    <select name="brand_id" class="form-select">
                                        <option value="">-- Chọn thương hiệu --</option>
                                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?= $b['id'] ?>"
                                                <?= $product['brand_id'] == $b['id'] ? 'selected' : '' ?>>
                                                <?= $b['name'] ?>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Trạng thái</label>
                                    <select name="status" class="form-select">
                                        <?php $currentStatus = isset($product['status']) ? $product['status'] : 1; ?>
                                        <option value="1" <?= $currentStatus == 1 ? 'selected' : '' ?>>Đang bán</option>
                                        <option value="0" <?= (string) $currentStatus === '0' ? 'selected' : '' ?>>Tạm ẩn</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-brand w-100 fw-bold py-2">
                                    <i class="bi bi-check-lg me-1"></i> Lưu thay đổi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.set-thumb-btn').forEach(radio => {
            radio.addEventListener('change', function() {
                const imageId = this.value;
                const productId = this.getAttribute('data-product-id');
                const msgBox = document.getElementById('ajax-alert');
                const msgText = document.getElementById('ajax-msg');

                const formData = new FormData();
                formData.append('product_id', productId);

                fetch('/product/setThumbnail/' + imageId, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success') {
                        msgBox.style.display = 'flex';
                        msgBox.className = 'alert alert-success d-flex align-items-center';
                        msgText.innerText = 'Đã cập nhật ảnh đại diện thành công!';

                        setTimeout(() => {
                            msgBox.style.display = 'none';
                        }, 3000);
                    } else {
                        alert('Lỗi: ' + (data.message || 'Không thể cập nhật'));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Đã xảy ra lỗi kết nối!');
                });
            });
        });

        function selectThumbnail(div) {
            const radio = div.querySelector('input[type="radio"]');
            if(radio && !radio.checked) {
                radio.checked = true;
                radio.dispatchEvent(new Event('change')); 
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/admin/product/edit.blade.php ENDPATH**/ ?>