<div class="container bootdey">
    <div class="col-md-3">
        <section class="panel">
            <div class="panel-body">
                <input type="text" placeholder="Keyword Search" class="form-control" />
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                Category
            </header>
            <div class="panel-body">
                <ul class="nav prod-cat">
                    <li>
                        <a href="#" onclick="filterByCategory(-1)">
                            <i class="fa fa-angle-right"></i> all
                        </a>
                    </li>
                    <?php
                    foreach($this->categories as $category) {
                    ?>
                    <li>
                        <a href="#" onclick="filterByCategory(<?= $category['id'] ?>)">
                            <i class="fa fa-angle-right"></i> <?= $category['name'] ?> (<?= $category['amount'] ?>)
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                Filter
            </header>
            <div class="panel-body">
                <select onchange="filterBy()" id="select_filter" class="form-control hasCustomSelect" style="">
                    <option value="">-----</option>
                    <option value="price ASC">cheap</option>
                    <option value="name">alphabetically</option>
                    <option value="date DESC">new</option>
                </select>
            </div>
        </section>
    </div>
    <div class="col-md-9">
    <section class="panel">
            <div class="panel-body">
                <div class="pull-right">
                    <ul class="pagination pagination-sm pro-page-list">
                        <li><a href="#">1</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <div id="products" class="row product-list">
            <?php 
            foreach($this->products as $product) { 
            ?>
            <div class="col-md-4">
                <section class="panel">
                    <div class="pro-img-box">
                        <img src="https://via.placeholder.com/250x220/FFFF00" alt="" />
                        <a href="#" onclick="getProduct(<?= $product['id'] ?>)" class="adtocart">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </div>

                    <div class="panel-body text-center">
                        <h4>
                            <a href="#" class="pro-title">
                                <?= $product['name'] ?>
                            </a>
                        </h4>
                        <p class="price"><?= $product['price'] ?> грн</p>
                    </div>
                </section>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="product_price" class="modal-body text-muted">
        0
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button data-dismiss="modal" type="button" class="btn btn-danger">Buy</button>
      </div>
    </div>
  </div>
</div>