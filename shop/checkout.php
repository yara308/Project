<?php 
ob_start();
session_start();
include realpath(__DIR__.'/../').'/_init.php';
function validate_request_data($request) 
{
  if (!validateString($request['full_name'])) {
    throw new Exception(trans('error_full_name_is_required'));
  }
  if (!valdateMobilePhone($request['phone_number'])) {
    throw new Exception(trans('error_phone_number_is_required'));
  }
  if (!validateString($request['address'])) {
    throw new Exception(trans('error_address_is_required'));
  }

}
$address = isset($session->data['address']) ? json_decode($session->data['address'], true) : array();
$errors = array();
if ($request->server['REQUEST_METHOD'] == 'POST' AND isset($request->post['action_type']) AND $request->post['action_type'] == 'ADDADDRESS')
{
    try {

        validate_request_data($request->post['address']);
        $session->data['address'] = json_encode($request->post['address']);
        $address['selectedShippingZone'] = $request->post['selectedShippingZone'];

        redirect('payment_cashier.php');
    } catch (Exception $e) { 

        $errors[] = $e->getMessage();
    }
}

$document->setTitle(trans('title_checkout'));
include('header_home.php');?>

    <div class="page-content-wrapper">
      <div class="container">
        <!-- Profile Wrapper-->
        <div class="profile-wrapper-area py-3">
          <!-- User Information-->
          <div class="card user-info-card">
            <div class="card-body p-4 d-flex align-items-center">
              <div class="user-profile me-3">
                <div class="change-user-thumb">
                  
                </div>
              </div>
              <div class="user-info">
                <p class="mb-0 text-dark">الكويت فيب </p>
                <h4 class="mb-0">اضف بيانات الشحن</h4>
              </div>
            </div>
          </div>

          <!-- User Meta Data-->
          <div class="card user-data-card">
            <div class="card-body">
<?php if (!empty($errors)):?>
                        <?php foreach ($errors as $err):?>
                        <div class="customer-zone mb-20">
                            <p style="font-size:16px;" class="text-danger"><?php echo $err;?></p>
                        </div>
                        <?php endforeach;?>
                    <?php endif;?>
              <form id="checkoutForm" class="form-horizontal" action="checkout.php" method="post">
                <input type="hidden" name="action_type" value="ADDADDRESS">
                <div class="mb-3">
                  <div class="title mb-2"><i class="fa-solid fa-user"></i><span>أسم العميل</span></div>
                  <input class="form-control" id="full_name" name="address[full_name]" placeholder="Full name" type="text" value="<?php echo isset($address['full_name']) ? $address['full_name'] : '';?>">
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="fa-solid fa-phone"></i><span>رقم الهاتف</span></div>
               
 </div>
<div class="mb-3">
                   <input class="form-select" id="phone_number" name="address[phone_number]" placeholder="Phone nuber" type="text" value="<?php echo isset($address['phone_number']) ? $address['phone_number'] : '';?>">
                </div>
 <!--  نوع الشحن
 <div class="mb-3">
                  <div class="title mb-2"><i class="fa-solid fa-location-arrow"></i><span>المحافظه-المنطقه</span></div>
               
             
                    
      <select class="form-select" ng-model="selectedShippingZone" ng-change="updateTotal()" required>
<option value="" disabled selected>اختر منطقة الشحن</option>// 
    <option ng-repeat="zone in shippingZones" value="{{zone.cost}}" ng-selected="$last">{{zone.zone}}</option>
</select>

				  </div>
-->
                <div class="mb-3">
                  <div class="title mb-2"><i class="fa-solid fa-location-arrow"></i><span>العنوان</span></div>
                  <input class="form-control" id="address" name="address[address]" class="billing-address" placeholder="Enter address here" type="text" value="<?php echo isset($address['address']) ? $address['address'] : '';?>">
                </div>

                <button class="btn btn-success w-100" type="submit"> اضف العنوان واكمال الشراء</button>
              </form>
            </div>

          </div>
        </div>
 
         <!-- Shipping Method Choose-->
          <div class="shipping-method-choose mb-3">
            <div class="card shipping-method-choose-title-card bg-success">
              <div class="card-body">
                <h6 class="text-center mb-0 text-white">سله المشتريات</h6>
              </div>
            </div>


            <div class="card shipping-method-choose-card">
              <div class="card-body">
                <div class="shipping-method-choose">
                  <ul class="ps-0">
                  
                     <li ng-repeat="items in itemArray" class="single-product-cart">
    <input id="normalShipping" type="radio">
    <label for="normalShipping">
        {{ items.name }} X {{ items.quantity }}
        <span>{{ (items.price * items.quantity)  | formatDecimal:2 }}</span>
    </label>
</li>
 
<div>
    المجموع الكلي للمنتجات: {{ getTotal() }} د.ك
</div>
                   
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Cart Amount Area-->
          <div class="card cart-amount-area">
            <div class="card-body d-flex align-items-center justify-content-between">
              <h5 class="total-price mb-0">KWD<span >{{ getTotal()  | formatDecimal:2 }} </span></h5>
            </div>
          </div>
      </div>
    </div>



<?php include('footer.php');?>