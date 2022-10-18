<?php
class MainModel extends Model {
    public function getProducts() {
        if($this->db->connect_errno === 0) {
            $query = "SELECT * FROM products;";
            $res = $this->db->query($query);
            if($res) {
                return $res->fetch_all(MYSQLI_ASSOC);
            } else {
                return false;
            }
        }
    }

    public function getCategories() {
        if($this->db->connect_errno === 0) {
            $query = "SELECT categories.id, categories.name, count(*) as amount FROM categories, products_categories where products_categories.category_id = categories.id group by category_id;";
            $res = $this->db->query($query);
            if($res) {
                return $res->fetch_all(MYSQLI_ASSOC);
            } else {
                return false;
            }
        }
    }

    public function getProductsByCategory() {
        if($this->db->connect_errno === 0) {
            $category_id = $_SESSION['category_id'] ? " AND products_categories.category_id=".$_SESSION['category_id'] : '';
            $query = "SELECT products.id, products.name, products.price, products.date FROM products, products_categories WHERE products.id = products_categories.product_id".$category_id;
            $res = $this->db->query($query);
            if($res) {
                return $res->fetch_all(MYSQLI_ASSOC);
            } else {
                return false;
            }
        }
    }
}