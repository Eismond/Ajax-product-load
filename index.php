<?php
require __DIR__ . "/model.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Тестовое Эйсмонд Андрей</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="t8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    
</head>
<body>
<div class="container-width">
  <section class="products">
    <div class="products-grid">
      <ul class="products-grid-container" data-per="<?php echo $per_page ?>">
        <?php foreach (getItems(1, $per_page) as $item): ?>
            <li class="product-card">
              <div class="product-image-container">
                <div class="product-image">
                  <img src="<?php echo $item['img']; ?>" alt="<?php echo $item['title']; ?>">
                </div>
              </div>
              <?php if ($item['new']): ?>
                    <div class="product-bage product-bage-new">NEW</div>
                <?php endif; ?>
              
              <?php if ($item['discountCost'] !== null): ?><div class="product-bage product-bage-sale">Sale</div><?php endif; ?>
              <div class="product-title"><?php echo $item['title']; ?></div>
              <div class="product-description"><?php echo $item['description']; ?></div>
              <div class="product-price">
                <div class="product-price-current"><span class="currency-symbol">$</span><?php echo $item['discountCost'] ? $item['discountCost'] : $item['cost']; ?></div>
                <?php if ($item['discountCost'] !== null): ?>
                <div class="product-price-old"><span class="currency-symbol">$</span><?php echo $item['cost']; ?></div><?php endif; ?></div>
              <div class="btn-product-container">
                <a href="" class="btn btn-add-cart">ADD TO CART</a>
                <a href="" class="btn btn-gray">VIEW</a>
              </div>
            </li>
        <?php endforeach; ?>
      </ul>
      <p id="loader"><img src="img/index.azure-round-loader.svg"></p>
      <button class="btn btn-load-more">Load more</button>
    </div>
  </section>
  <footer>
    <div class="footer-row">
      <div class="footer-column">
        <div class="heading">hot offers</div>
        <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae. Suspendisse sollicitudin velit sed leo. Ut pharetra augue nec augue. Nam elit magna, hend.</p>
        <ul>
          <li>Vestibulum ante ipsum primis in faucibus orci luctus</li>
          <li>Nam elit magna hendrerit sit amet tincidunt ac</li>
          <li>Quisque diam lorem interdum vitae dapibus ac scele</li>
          <li>Donec eget tellus non erat lacinia fermentum</li>
          <li>Donec in velit vel ipsum auctor pulvin</li>
        </ul>
      </div>
      <div class="footer-column">
        <div class="heading">hot offers</div>
        <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae. Suspendisse sollicitudin velit sed leo. Ut pharetra augue nec augue. Nam elit magna, hend.</p>
        <ul>
          <li>Vestibulum ante ipsum primis in faucibus orci luctus</li>
          <li>Nam elit magna hendrerit sit amet tincidunt ac</li>
          <li>Quisque diam lorem interdum vitae dapibus ac scele</li>
          <li>Donec eget tellus non erat lacinia fermentum</li>
          <li>Donec in velit vel ipsum auctor pulvin</li>
        </ul>
      </div>
      <div class="footer-column">
        <div class="heading">Store information</div>
        <div class="contact-info">
          <div class="contact-item">
            <span class='icon-cont'><i class="fas fa-map-marker-alt"></i></span>
            <p class="contact-item-info">
              Company Inc., 8901 Marmora Road, Glasgow, D04 89GR
            </p>
          </div>
        </div>
        <div class="contact-info">
          <div class="contact-item">
            <span class='icon-cont'><i class="fa fa-phone fa-flip-horizontal"></i></span>
            <p class="contact-item-info">
              Call us now toll free: <a href="tel:(800) 2345-6789">(800) 2345-6789</a>
            </p>
          </div>
        </div>
        <div class="contact-info">
          <div class="contact-item">
            <span class='icon-cont'><i class="far fa-envelope"></i></span>
            <div class="contact-item-info">
              <p>Customer support: <a href="mailto: support@example.com">support@example.com</a></p>
              <p>Press: <a href="mailto: pressroom@example.com">pressroom@example.com</a></p>
            </div>
          </div>
        </div>
        <div class="contact-info">
          <div class="contact-item">
            <span class='icon-cont'><i class="fab fa-skype"></i></span>
            <p class="contact-item-info">
              Skype: <a href="skype:sample-username">sample-username</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){

            var list_product = '';
            var per_page = $('.products-grid-container').attr('data-per');
            var page = 2;
            var total = 0;
            var countLi = $('.products-grid-container li').length;
            var isAjax = false;
            var dclick = false;

            function getProduct(page, per_page) {
                isAjax = true;
                $.ajax({
                    url: 'list.php',
                    type: 'GET',
                    cache: false,
                    data: {
                        page: page,
                        per_page: per_page,
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        list_product = '';
                        total = data.total;
                        for(var id in data.entities) {
                            costString = '';
                            discountCostString = '';
                            productImg = '';
                            productBadgeNew = '';
                            productBadgeSale = '';
                            countLi++;
                            var product = data.entities[id];
                            var discountCost = product.discountCost;                            
                            var discountCost = product.discountCost;
                            if ( discountCost != "" && discountCost != undefined ) {var discountCostString = '<div class="product-price"><div class="product-price-current"><span class="currency-symbol">$</span>' + discountCost +'</div><div class="product-price-old"><span class="currency-symbol">$</span>' + product.cost + '</div></div>';productBadgeSale = '<div class="product-bage product-bage-sale">Sale</div>'}else{
                                var discountCostString = '<div class="product-price"><div class="product-price-current"><span class="currency-symbol">$</span>' + product.cost +'</div></div>'; };
                            if ( product.img != "" && product.img != undefined ) {var productImg = '<img src="' + product.img + '" alt="' + product.title + '">'}else{var productImg = '<img src="img/img_product.png" alt="' + product.title + '">'};
                            if ( product.title != "" && product.title != undefined ) {var productTitle = '<div class=\'product-title\'>' + product.title + '</div>'};
                            if ( product.description != "" && product.description != undefined ) {var productDescription = '<div class="product-description">' + product.description + '</div>'};
                             if ( product.new != "" && product.new != undefined ) {var productBadgeNew = '<div class="product-bage product-bage-new">NEW</div>'};
                            
                            list_product += '<li class="product-card hide">' + '<div class="product-image-container"><div class="product-image">' + productImg + '</div></div>' + productBadgeNew + productBadgeSale + productTitle + productDescription + discountCostString + ' <div class="btn-product-container"><a href="" class="btn btn-add-cart">ADD TO CART</a><a href="" class="btn btn-gray">VIEW</a></div></li>';

                        }
                        $('#loader').hide();
                        isAjax = false;
                        if(dclick) {
                            dclick = false;
                            $('button').click();
                        }
                    }
                });
                
            }
            getProduct(page, per_page);
            $('button').bind("click", function(){
                if(isAjax) {  
                    //alert (isAjax);                  
                    $('#loader').show();
                    dclick = true;
                } else {
                    page++;
                     $('.products-grid-container li:last-of-type').after(list_product);   
                             $('.product-card').animate({height: "100%", opacity: 1 }, 300 );        
                    if(total <= countLi) {
                        $('button').remove();
                    }
                    getProduct(page, per_page);
                }

            });

        });
    </script>
</body>
</html>