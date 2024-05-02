<style id="styles" type="text/css">
<?php 
$template_id = get_preference('receipt_template') ? get_preference('receipt_template') : 1;
echo html_entity_decode(get_the_postemplate($template_id,'template_css'));
?>
</style>
<?php
include DIR_VENDOR.'parser/lex/lib/Lex/ArrayableInterface.php';
include DIR_VENDOR.'parser/lex/lib/Lex/ArrayableObjectExample.php';
include DIR_VENDOR.'parser/lex/lib/Lex/Parser.php';
include DIR_VENDOR.'parser/lex/lib/Lex/ParsingException.php';
$data = get_postemplate_data($invoice_id);
$parser = new Lex\Parser();
$template = html_entity_decode(get_the_postemplate($template_id,'template_content'));
echo $parser->parse($template, $data);
?>

<div class="table-responsive footer-actions">
  <table class="table">
    <tbody>
      <tr class="no-print">
        <td colspan="2">
          <button onClick="window.printContent('invoice', {title:'<?php echo $invoice_id;?>',scrrenSize:'halfScreen'});" class="btn btn-info btn-block">
            <span class="fa fa-fw fa-print"></span> 
            <?php echo trans('button_print'); ?>
          </button>
        </td>
      </tr>
      <?php if ((user_group_id() == 1 || has_permission('access', 'sms_sell_invoice')) && get_preference('sms_alert')):?>
        <tr class="no-print">
          <td colspan="2">
            <button id="sms-btn" data-invoiceid="<?php echo $invoice_id; ?>" class="btn btn-danger btn-block">
              <span class="fa fa-fw fa-comment-o"></span> 
              <?php echo trans('button_send_sms'); ?>
            </button>
          </td>
        </tr>
      <?php endif; ?>
      <?php if ((user_group_id() == 1 || has_permission('access', 'send_whatsapp_message'))):?>
        <tr class="no-print">
          <td colspan="2">
            <?php
            $store_name = store('name');
            $message = "Thank You for Purchasing From {$store_name}. \n Your Invoice id Is {$invoice_id}. \n Total amount payable is {$data['payable_amount']}. \n Keep Loving & Keep Sharing. \n Made With Love By ITsolution24";
            ?>
            <a href="https://web.whatsapp.com/send?phone=<?php echo $data['customer_phone'];?>&text=<?php echo urlencode($message);?>&source=https://www.mahabusiness.com/admin/pos.php&data=" target="_blink" class="btn btn-warning btn-block">
              <span class="fa fa-fw fa-paper-plane"></span> 
              <?php echo trans('button_send_whatsapp_message'); ?>
            </a>
          </td>
        </tr>
      <?php endif;?>
      <?php if ((user_group_id() == 1 || has_permission('access', 'email_sell_invoice'))):?>
        <tr class="no-print">
          <td colspan="2">
            <button id="email-btn" data-customerName="<?php echo $invoice_info['customer_name']; ?>" data-invoiceid="<?php echo $invoice_id;?>" class="btn btn-success btn-block">
              <span class="fa fa-fw fa-envelope-o"></span> 
              <?php echo trans('button_send_email'); ?>
            </button>
          </td>
        </tr>
      <?php endif;?>
      <tr class="no-print">
        <td colspan="2">
          <a class="btn btn-primary btn-block" href="pos.php?invoice_id=<?php echo $invoice_id;?>">
            <span class="fa fa-fw fa-edit"></span> <?php echo trans('button_edit_this_invoice'); ?>
          </a>
        </td>
      </tr>
      <tr class="no-print">
        <td colspan="2">
          <a class="btn btn-default btn-block" href="pos.php">
            &larr; <?php echo trans('button_back_to_pos'); ?>
          </a>
        </td>
      </tr>
      <tr class="text-center">
        <td colspan="2">
          <br>
          <p class="powered-by">
            <small>&copy; ONZWO.COM</small>
          </p>
        </td>
      </tr>
    </tbody>
  </table>
</div>