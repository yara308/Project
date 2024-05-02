<?php 
ob_start();
session_start();
include realpath(__DIR__).'/_init.php';

$reference_no = isset($request->get['reference_no']) ? $request->get['reference_no'] : '';

if (!$reference_no) {
    redirect('products.php');
}

$model = registry()->get('loader')->model('quotation');
$order_info = $model->getQuotationInfo($reference_no);

if (!$order_info) {
    redirect('products.php');
}

$invoice_id = $order_info['invoice_id'];
$status = $order_info['status'];
$pmethod_details = json_decode($order_info['pmethod_details'],true);
$pmethod_name = isset($pmethod_details['name']) ? $pmethod_details['name'] : '';
if (!$pmethod_name) {
    redirect('products.php');
}

$document->setTitle(trans('title_order_placed'));
include('header.php');?>

    <div class="breadcrumb-area section-padding-1 border-top-2 border-bottom-2 pt-30 pb-30">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center breadcrumb-center">
                <h2>Order Successfully Placed!</h2>
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="products.php">Shop</a>
                    </li>
                    <li class="active">Order Placed</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-area cart-main-area pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-8 col-12 mx-auto">
                    <div class="card mb-20">
                        <div class="card-body text-center">
                            <!-- <h2 class="text-warning"><i class="fa fa-fw fa-clock-o"></i> Waiting for payment</h2> -->
                            <h2 class="text-warning"><i class="fa fa-fw fa-clock-o"></i> Thank you for your purchase!</h2>
                            <h3>Reference number is : <span class="text-danger"><?php echo $reference_no;?></span></h3>
                            <?php if ($invoice_id):?>
                            <h3>Invoice ID: <span class="text-success"><?php echo $invoice_id;?></span></h3>
                            <?php endif;?>
                            <h4>Order Status: <span class="text-warning"><?php echo $status;?></span></h4>
                            <?php switch ($pmethod_name) {
                                case 'cod':
                                    echo '<hr><h4 class="mt-20">*** Please have this amount ready on delivery day ***</h4>';
                                    break;

                                case 'bank_transfer':
                                    break;

                                 case 'bkash':
                                    echo '<hr><h4 class="text-info mt-20">*** You have to pay within 48 hours ***</h4>';
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }?>
                            <h2 class="text-warning"><?php echo get_currency_symbol();?><?php echo currency_format($order_info['payable_amount']);?></h2>
                        </div>
                    </div>

                    <?php switch ($pmethod_name) {
                        case 'cod':
                            break;

                        case 'bank_transfer':
                            ?>
                            <div class="your-order-area bg-white mb-20">
                                <h3>Bank Transfer Instructions</h3>
                                <div class="your-order-wrap gray-bg-4">
                                    <div class="your-order-info-wrap">
                                        <div class="your-order-info">
                                            <h5 class="font-weight-bold">Bank Account Details</h5>
                                                <address>
                                                    Bank account detals goes here...
                                                </address>
                                            <h5 class="font-weight-bold">How to make a bank transfer</h5>
                                            <ol>
                                                <li>Online bank transfers. Log in to your online account and select the option for making a payment. ...</li>
                                                <li>Telephone transfers. Call your bank's telephone banking service. ...</li>
                                                <li>In-branch bank transfers. If you have the money in cash, you can pay it into the account of the person you owe it to in-branch.</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            break;

                         case 'bkash':
                            ?>
                                <div class="your-order-area bg-white mb-20">
                                <h3>bKash Payment Instructions</h3>
                                    <div class="your-order-wrap gray-bg-4">
                                        <div class="your-order-info-wrap">
                                            <div class="your-order-info">
                                                <div class="mb-10">
                                                    You can make payments from your bKash Account to any “Merchant” who accepts “bKash Payment”. Now you can bKash your Payment at more than 47,000 outlets nationwide. To bKash your Payment follow the steps below.
                                                </div>
                                                <ol>
                                                    <li>Go to your bKash Mobile Menu by dialing *247#</li>
                                                    <li>Choose “Payment”</li>
                                                    <li>Enter the Merchant bKash Account Number <b>(<?php echo store('mobile') ? store('mobile') : '+8801737346122';?>)</b></li>
                                                    <li>Enter the amount you want to pay</li>
                                                    <li>Enter a reference* against your payment (you can mention the purpose of the transaction in one word. e.g. Bill)</li>
                                                    <li>Enter the Counter Number* (the salesperson at the counter will tell you the number)</li>
                                                    <li>Now enter your bKash Mobile Menu PIN to confirm</li>
                                                </ol>
                                                <div class="mb-10">
                                                    Done! You will receive a confirmation message from bKash.
                                                </div>
                                                <div class="mb-10">
                                                    *If Reference or Counter No. or both are not applicable, you can skip them by entering 0
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            break;
                        
                        default:
                            # code...
                            break;
                    }?>


                    <div class="your-order-area">
                        <h3>Order Summary</h3>
                        <div class="your-order-wrap gray-bg-4">
                            <div class="your-order-info-wrap">
                                <div class="your-order-info">
                                    <ul>
                                        <li>Product <span>Total</span></li>
                                    </ul>
                                </div>
                                <div class="your-order-info order-subtotal">                                        
                                    <ul>
                                        <li>
                                            <a href="cart.php" title="View Cart">Subtotal (<?php echo $order_info['total_items'];?> items)</a> <span><?php echo get_currency_symbol();?><?php echo currency_format($order_info['payable_amount']);?> </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="your-order-info order-shipping">
                                    <ul>
                                        <li>Shipping Fee <span>-</span></li>
                                        <li>Others Charge <span>-</span></li>
                                    </ul>
                                </div>
                                <div class="your-order-info order-total">
                                    <ul>
                                        <li>Total <span><?php echo get_currency_symbol();?><?php echo currency_format($order_info['payable_amount']);?></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-20">
                <div class="col-lg-7 col-md-7 col-sm-8 col-12 mx-auto text-center">
                    <div>
                        <a class="btn btn-info bg-info" href="account.php?tab=orders">Track Your Orders</a>
                    </div>
                    <div class="mt-30">
                        <a class="text-info" href="products.php">Continue Shopping &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
if (localStorage.getItem("swal")) {
    localStorage.getItem("swal");
    localStorage.setItem("swal","");
}
</script>

<?php include('footer.php');?>