<?php
class AdminOrderController extends Controller
{
    public function index()
    {
        $orderModel = $this->model('OrderModel');
        $orders = $orderModel->all(); 

        $this->view('admin/orders/index', [
            'orders' => $orders
        ]);
    }

    public function detail($id)
    {
        $orderModel = $this->model('OrderModel');
        $orderDetailModel = $this->model('OrderDetailModel');

        $order = $orderModel->find($id);

        $orderDetails = $orderDetailModel->getDetailsByOrderId($id); 

        $this->view('admin/orders/detail', [
            'order' => $order,
            'orderDetails' => $orderDetails
        ]);
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'];
            $newStatus = $_POST['status'];

            $orderModel = $this->model('OrderModel');
            $currentOrder = $orderModel->find($orderId);
            $originalStatus = $currentOrder['status'];

            if ($originalStatus == 4 || ($newStatus == 4 && in_array($originalStatus, [2, 3]))) {
                $_SESSION['error'] = "Thao tác thay đổi trạng thái không hợp lệ!";
                header("Location: /adminOrder/index");
                exit;
            }

            $orderModel->updateStatus($orderId, $newStatus);
            $_SESSION['success'] = "Cập nhật thành công!";
            header("Location: /adminOrder/index");
            exit;
        }
    }
}