<?php
class MainController extends Controller {
    public function action_products() {
        if (!isset($_SESSION['category_id'])) {
            $_SESSION['category_id'] = false;
        }
        if (!isset($_SESSION['order_by'])) {
            $_SESSION['order_by'] = false;
        }
        $this->model = new MainModel();
        if($_SESSION['category_id']) {
            $this->view->products = $this->model->getProductsByCategory();
        } else {
            $this->view->products = $this->model->getProducts();    
        }
        $this->view->categories = $this->model->getCategories();
        $this->view->page = 'page_main_products';
        $this->view->render();
    }
}