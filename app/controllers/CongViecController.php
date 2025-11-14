<?php
require_once 'app/models/CongViecModel.php';

class CongViecController {
    private $model;

    public function __construct() {
        $this->model = new CongViecModel();
    }

    public function index() {
        $plans = $this->model->getApprovedPlans();
        require 'app/views/xemcongviec.php';

    }

   
    public function detail() {
    if (!isset($_GET['id'])) die("Thiếu ID");

    $id = $_GET['id'];
    $plan = $this->model->getPlanById($id);
    $tasks = $this->model->getTasksByPlanId($id);

    require 'app/views/chitietkehoach.php';
}

}