<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$document->setTitle(trans('title_cart'));
include('header_home.php');?>
    <div class="page-content-wrapper">
      <div class="container">
        <!-- Cart Wrapper-->
        <div class="cart-wrapper-area py-3">
          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
              <table class="table mb-0">
                <tbody>
                  <tr ng-repeat="items in itemArray">
                    <th scope="row"><a ng-click="removeItemFromInvoice($index, items.id)" onClick="return false;" class="remove-product" href="#"><i class="fa-solid fa-xmark"></i></a></th>
                    <td ng-show="items.img"><img class="rounded" src="https://control.elmattger.com/storage{{items.img}}" alt=""></td>
                    <td ><a  href="product_details.php?product_id={{ items.id }}">{{ items.name }}<span style="font-size:20px; ">{{ items.price | formatDecimal:2 }}X{{ items.quantity }} ={{ items.subTotal | formatDecimal:2 }}</span></a>
<!---<span>{{ items.price * items.quantity }}</span>
<span>{{ 2.00 | formatDecimal:2 }}</span>
<pre>{{ items | json }}</pre>--->
</td>
                    <td>
                      <div class="quantity">
                      
<td class="product-quantity">
                                           
                 
<div class="quantity-button-handler" ng-click="DecreaseItemFromInvoice(items.id,1)" class="dec qtybutton" style="font-size:30px;color:red;">-</div>
                                                    <input class="qty-text" type="text" name="qtybutton" value="{{ items.quantity }}">
<div class="quantity-button-handler" ng-click="addItemToInvoice(items.id,1)" style="font-size:30px; color:green;" class="inc qtybutton">+</div>
                                               
                                          
                                        </td>
						  <tr>

                    <td>
						  <th>

						  </th>
						  
						  </tr>
                      </div>
                    </td>
                  </tr>


                 <!---
 <tr ng-repeat="items in itemArray" class="single-product-cart">
                                        <td class="product-remove">
                                            <a ng-click="removeItemFromInvoice($index, items.id)" onClick="return false;" class="text-danger" href="#"><i class="negan-icon-simple-close"></i></a>
                                        </td>
                                        <td class="product-cart-img">
                                            <a ng-show="!items.img" href="#"><img style="width:60px;height:70px;" ng-src="assets/img/cart/cart-3.jpg" alt=""></a>
                                            <a ng-show="items.img" href="#"><img style="width:60px;height:70px;" ng-src="<?php echo FILEMANAGERURL;?>/{{items.img}}" alt=""></a>

                                        <td class="product-cart-name"><a href="product_details.php?product_id={{ items.id }}">{{ items.name }}</a></td>
                                        <td class="product-price-cart"><span class="amount">${{ items.price | formatDecimal:2 }}</span></td>
                                        <td class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <div ng-click="DecreaseItemFromInvoice(items.id,1)" class="dec qtybutton">-</div>
                                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="{{ items.quantity }}">
                                                <div ng-click="addItemToInvoice(items.id,1)" class="inc qtybutton">+</div>
                                            </div>
                                        </td>
                                        <td class="product-total"><span>${{ items.subTotal | formatDecimal:2 }}</span></td>
                                    </tr>



                 --->
                </tbody>
              </table>
            </div>
          </div>
          <!-- Coupon Area-->
          <div class="card coupon-card mb-3">
            <div class="card-body">
              <div class="apply-coupon">
                <h6 class="mb-0">Have a coupon?</h6>
                <p class="mb-2">Enter your coupon code here &amp; get awesome discounts!</p>
                <div class="coupon-form">
                  <form action="#">
                    <input class="form-control" type="text" placeholder="KUW2023">
                    <button class="btn btn-primary" type="submit">Apply</button>

                  </form>

                </div>
              </div>
            </div>
          </div>
          <!-- Cart Amount Area-->
          <div class="card cart-amount-area">
            <div class="card-body d-flex align-items-center justify-content-between">
                    <ul class="total-price mb-0">
                            <li >Subtotal (1 Items) <span > KWD:{{ totalAmount | formatDecimal:3 }}</span></li>
                            
                            <li> الاجمالي <span style="font-size:20px; color:whight;" >د.ك {{ totalAmount | formatDecimal:3 }}</span></li>
                        </ul>
                        <a ng-show="totalQuantity" class="btn btn-warning" href="checkout.php">Proceed to Checkout</a>
      
            </div>
          </div>
        </div>
      </div>
    </div>
    
<?php include('footer.php');?>