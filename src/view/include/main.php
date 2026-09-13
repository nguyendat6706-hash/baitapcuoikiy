<!-- <section style="text-align: center;">
            <img src="../img/images.jpg" style="height: auto; width: 500px;" alt="">
        </section>
             -->
<section>
    <div class="center-text">
        <div class="title_section">
            <div class="bar"></div>
            <h2 class="center-text-share">SẢN PHẨM NỔI BẬT</h2>
        </div>
    </div>
    <div class="icon-bottom-title">
        <img src="../../../img/design/line.webp" alt="" />
    </div>
    <!-- <div class="openFilter">
                    <button id="filterButton"><i class="fa-solid fa-sliders" style="margin-right: 5px;"></i>Lọc theo sản phẩm</button>
                </div> -->

    <!-- daiiiiiii -->
</section>



<section id="product">
    <div class="products">
        <?php
        // var_dump($data);
        foreach ($data->data as $product) {
            echo "
        
            <div class='row'>
              
                  <a href='../details/detail.html'>
                      
                          <img src='../../public/img/ruou_vang_do.png' alt='{$product['TenSanPham']}' />
                          <div class='product-card-content'>
                              <div class='price'>
                                  <h4 class='name-product'>{$product['TenSanPham']}</h4>
                                  <p class='price-tea'>" . number_format($product['Gia'], 0, ',', '.') . "đ</p>
                              </div>
                            <form action='homepage.php?action=addToCart' method='POST'>
                              <input type='hidden' name='product_id' value='{$product['MaSanPham']}'>
                              <input type='hidden' name='product_price' value='{$product['Gia']}'>
                              <input type='hidden' name='quantity' value='1'>
                              <div class='buy-btn-container'>
                                  <input type='submit' name='addToCart' value='mua ngay'>
                              </div>
                            </form>
                          </div>
                     
                  </a>
              
          </div>";
        }

        ?>
    </div>
    <div>
        <ul class="listPage"></ul>
    </div>
</section>
<!-- Tin tuc -->
<section class="Home-titleSection">
    <div class="Home-lineSection-2"></div>
    <h2 class="Home-txtTitle">TIN TỨC</h2>
    <div class="Home-lineSection-2"></div>
</section>

<section class="Home-grid-container">
    <div class="Home-grid-item">
        <img class="Home-gird-item-img" src="../../public/img/drunk.jpg" alt="" />
        <div class="home-title-context">
            <h1 class="Home-title-heading">
                Uống rượu vang mỗi ngày, nên hay không?
            </h1>
            <p class="Home-context">
                Nếu bạn thật sự rất thích rượu vang, thì bạn chắc hẳn sẽ có xu
                hướng mất kiểm soát bản thân. Điều này thì cũng dễ hiểu vì khi bạn
                thực sự thích một điều gì đó thì việc dừng lại cũng giống như cực
                hình.
            </p>
        </div>
    </div>
</section>

<!-- service -->
<section class="Home-service">
    <div class="Home-service-child">
        <img class="Home-service-img" src="../../public/img/img_delivery.png" alt="" />
        <h2 class="home-heading-sercive">Giao Hàng nhanh</h2>
        <p class="home-txt-sercive">
            Winemart sẽ luôn cố gắng giao hàng nhanh nhất có thể
        </p>
    </div>
</section>
