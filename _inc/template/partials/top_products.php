<?php 
if (top_products(from(), to(), 3)) {
  foreach (top_products(from(), to(), 3) as $product) {
    $top_products['name'][] = limit_char($product['item_name'],15);
    $top_products['quantity'][] = currency_format($product['quantity']);
  } 
} else {
  $top_products['name'] = array();
  $top_products['quantity'] = array();
}


if (top_profitable_products(from(), to(), 3)) {
  foreach (top_profitable_products(from(), to(), 3) as $product) {
    $top_profitable_products['name'][] = limit_char($product['item_name'],15);
    $top_profitable_products['profit'][] = currency_format($product['profit']);
  } 
} else {
  $top_profitable_products['name'] = array();
  $top_profitable_products['profit'] = array();
}

$tab_active = 'by_quantity';
?>
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">
      <?php echo trans('text_top_products'); ?>
    </h3>
  </div>
  <div class="box-body p-0">
    <div class="nav-tabs-custom mb-0">
        <ul class="nav nav-tabs">
          <li class="<?php echo $tab_active == 'by_quantity' ? 'active' : null;?>">
              <a style="padding-top:3px;padding-bottom:3px;" href="#by_quantity" data-toggle="tab" aria-expanded="false">
              <?php echo trans('text_as_quantity'); ?>
            </a>
          </li>
          <li class="<?php echo $tab_active == 'by_profit' ? 'active' : null;?>">
              <a style="padding-top:3px;padding-bottom:3px;" href="#by_profit" data-toggle="tab" aria-expanded="false">
              <?php echo trans('text_as_profit'); ?>
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane<?php echo $tab_active == 'by_quantity' ? ' active' : null;?>" id="by_quantity">
            <canvas id="topProducts" height="220"></canvas>
          </div>
          <div class="tab-pane<?php echo $tab_active == 'by_profit' ? ' active' : null;?>" id="by_profit">
            <canvas id="topProfitableProducts" height="220"></canvas>
          </div>
        </div>
      </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  var topProducts = <?php echo json_encode(array_values($top_products['name'])); ?>;
  var topProductsQuantity = <?php echo json_encode(array_values($top_products['quantity'])); ?>;
  var ctx = document.getElementById("topProducts");
  var myPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: topProducts,
        datasets: [
            {
              label: "Top",
              backgroundColor: ["#e6194B", "#f58231", "#ffe119", "#3cb44b", "#4363d8", "#f032e6", "#42d4f4", "#9A6324", "#469990", "#fabebe"],
              data: topProductsQuantity
            },
        ],
      },
      options: {
          responsive: true,
          tooltips: {
              mode: 'index',
              intersect: true
          },
          hover: {
              mode: 'nearest',
              intersect: true
          }
      }
  });

  var topProfitableProducts = <?php echo json_encode(array_values($top_profitable_products['name'])); ?>;
  var topProfitableProductsProfit = <?php echo json_encode(array_values($top_profitable_products['profit'])); ?>;
  var ctx = document.getElementById("topProfitableProducts");
  var myPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: topProfitableProducts,
        datasets: [
            {
              label: "Top",
              backgroundColor: ["#e6194B", "#f58231", "#ffe119", "#3cb44b", "#4363d8", "#f032e6", "#42d4f4", "#9A6324", "#469990", "#fabebe"],
              data: topProfitableProductsProfit
            },
        ],
      },
      options: {
          responsive: true,
          tooltips: {
              mode: 'index',
              intersect: true
          },
          hover: {
              mode: 'nearest',
              intersect: true
          }
      }
  });
});
</script>