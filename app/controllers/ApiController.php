<?php
class ApiController extends Controller {
    public function action_bycategory($category_id = false) {
        $_SESSION['category_id'] = $category_id == -1 ? false : (int)$category_id;
        $this->model = new ApiModel();
        $products = $this->model->getProductsByFilters();
        GenerateHeader::generateHeader(true, 200, 'get products by category', "products", $products);
    }

    public function action_byfilter($filter = false) {
        $_SESSION['order_by'] = $filter ? urldecode($filter) : false;
        $this->model = new ApiModel();
        $products = $this->model->getProductsByFilters();
        GenerateHeader::generateHeader(true, 200, 'get products by filter', "products", $products);
    }

    public function action_product($id) {
        $this->model = new ApiModel();
        $product = $this->model->getProduct($id);
        GenerateHeader::generateHeader(true, 200, 'get product', "product", $product);
    }
}