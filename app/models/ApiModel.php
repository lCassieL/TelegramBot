<?php
class ApiModel extends Model {
    public function getProductsByFilters() {
        if($this->db->connect_errno === 0) {
            $category_id = $_SESSION['category_id'] ? " AND products_categories.category_id=".$_SESSION['category_id'] : '';
            $order_by = $_SESSION['order_by'] ? " ORDER BY ".$_SESSION['order_by'] : '';
            $query = "SELECT products.id, products.name, products.price, products.date FROM products, products_categories WHERE products.id = products_categories.product_id".$category_id.$order_by;
            $res = $this->db->query($query);
            if($res) {
                return $res->fetch_all(MYSQLI_ASSOC);
            } else {
                return false;
            }
        }
    }

    public function getProduct($id) {
        if($this->db->connect_errno === 0) {
            $query = "SELECT * FROM products WHERE id=".(int)$id;
            $res = $this->db->query($query);
            if($res) {
                return $res->fetch_all(MYSQLI_ASSOC);
            } else {
                return false;
            }
        }
    }
}