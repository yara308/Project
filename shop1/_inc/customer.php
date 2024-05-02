<?php 
ob_start();
session_start();
include realpath(__DIR__.'/../../').'/_init.php';

$customer_model = registry()->get('loader')->model('customer');

function validate_request_data($request) 
{
  if (!validateString($request->post['customer_name'])) {
    throw new Exception(trans('error_name'));
  }

  if (!validateInteger($request->post['birthday_day'])) {
    throw new Exception(trans('error_birthday_day'));
  }

  if (!validateInteger($request->post['birthday_month'])) {
    throw new Exception(trans('error_birthday_month'));
  }

  if (!validateInteger($request->post['birthday_year'])) {
    throw new Exception(trans('error_birthday_year'));
  }

  if (!validateInteger($request->post['gender'])) {
    throw new Exception(trans('error_gender'));
  }

  if (!validateString($request->post['customer_address'])) {
    throw new Exception(trans('error_address'));
  }
}

function validate_existance($request, $id = 0)
{
  //...
}

if ($request->server['REQUEST_METHOD'] == 'POST' AND isset($request->post['action_type']) AND $request->post['action_type'] == 'UPDATE')
{
  try {
    $id = isset($session->data['cid']) ? $session->data['cid'] : '';
    $the_customer = get_the_customer($id);
    if (!$the_customer) {
      throw new Exception(trans('error_invalid_customer'));
    }
    validate_request_data($request);
    validate_existance($request, $id);
    $dob = $request->post['birthday_year'].'-'.$request->post['birthday_month'].'-'.$request->post['birthday_day'];
    $data = array(
      'gtin' => $the_customer['gtin'],
      'customer_state' => $the_customer['customer_state'],
      'customer_name' => $request->post['customer_name'],
      'dob' => $dob,
      'customer_email' => $the_customer['customer_email'],
      'customer_mobile' => $the_customer['customer_mobile'],
      'customer_sex' => $request->post['gender'],
      'customer_age' => $the_customer['customer_age'],
      'customer_address' => $request->post['customer_address'],
      'customer_city' => $the_customer['customer_city'],
      'customer_country' => $the_customer['customer_country'],
      'status' => 1,
      'sort_order' => 1,
      'customer_store' => get_store_ids(),
    );
    $customer_id = $customer_model->editCustomer($id, $data);
    header('Content-Type: application/json');
    echo json_encode(array('msg' => trans('text_update_success'), 'id' => $customer_id));
    exit();

  } catch (Exception $e) { 

    header('HTTP/1.1 422 Unprocessable Entity');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array('errorMsg' => $e->getMessage()));
    exit();
  }
}

function validate_update_request_data($request) 
{
  if (!validateString($request->post['current_password'])) {
    throw new Exception(trans('error_current_password'));
  }

  if (!validateString($request->post['new_password'])) {
    throw new Exception(trans('error_new_password'));
  }

  if (!validateString($request->post['retype_password'])) {
    throw new Exception(trans('error_retype_password'));
  }
}

if ($request->server['REQUEST_METHOD'] == 'POST' AND isset($request->post['action_type']) AND $request->post['action_type'] == 'CHANGEPASSWORD')
{
  try {

    $customer_id = isset($session->data['cid']) ? $session->data['cid'] : '';
    $the_customer = get_the_customer($customer_id);
    if (!$the_customer) {
      throw new Exception(trans('error_invalid_customer'));
    }

    validate_update_request_data($request);

    if ($request->post['current_password'] !== $the_customer['raw_password']) {
      throw new Exception(trans('error_current_password_not_matched'));
    }

    if ($request->post['new_password'] !== $request->post['retype_password']) {
      throw new Exception(trans('error_retype_password_not_matched'));
    }

    $statement = db()->prepare("UPDATE `customers` SET `password` = ?, `raw_password` = ? WHERE `customer_id` = ?");
    $statement->execute(array(md5($request->post['new_password']), $request->post['new_password'], $customer_id));

    header('Content-Type: application/json');
    echo json_encode(array('msg' => trans('text_password_update_success'), 'id' => $customer_id));
    exit();

  } catch (Exception $e) { 

    header('HTTP/1.1 422 Unprocessable Entity');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array('errorMsg' => $e->getMessage()));
    exit();
  }
}

if ($request->server['REQUEST_METHOD'] == 'POST' AND isset($request->post['action_type']) AND $request->post['action_type'] == 'CHANGEEMAIL')
{
  try {

    $customer_id = isset($session->data['cid']) ? $session->data['cid'] : '';
    $the_customer = get_the_customer($customer_id);
    if (!$the_customer) {
      throw new Exception(trans('error_invalid_customer'));
    }

    if (!validateEmail($request->post['email_address'])) {
      throw new Exception(trans('error_email_address'));
    }

    $statement = db()->prepare("UPDATE `customers` SET `customer_email` = ? WHERE `customer_id` = ?");
    $statement->execute(array($request->post['email_address'], $customer_id));

    header('Content-Type: application/json');
    echo json_encode(array('msg' => trans('text_email_update_success'), 'id' => $customer_id));
    exit();

  } catch (Exception $e) { 

    header('HTTP/1.1 422 Unprocessable Entity');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array('errorMsg' => $e->getMessage()));
    exit();
  }
}

if ($request->server['REQUEST_METHOD'] == 'POST' AND isset($request->post['action_type']) AND $request->post['action_type'] == 'CHANGEPHONE')
{
  try {

    $customer_id = isset($session->data['cid']) ? $session->data['cid'] : '';
    $the_customer = get_the_customer($customer_id);
    if (!$the_customer) {
      throw new Exception(trans('error_invalid_customer'));
    }

    if (!valdateMobilePhone($request->post['phone_number'])) {
      throw new Exception(trans('error_phone_number'));
    }

    $statement = db()->prepare("UPDATE `customers` SET `customer_mobile` = ? WHERE `customer_id` = ?");
    $statement->execute(array($request->post['phone_number'], $customer_id));

    header('Content-Type: application/json');
    echo json_encode(array('msg' => trans('text_phone_number_update_success'), 'id' => $customer_id));
    exit();

  } catch (Exception $e) { 

    header('HTTP/1.1 422 Unprocessable Entity');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array('errorMsg' => $e->getMessage()));
    exit();
  }
}


function validate_register_request_data($request) 
{
  // Validate name
  if (!validateString($request->post['name'])) {
    throw new Exception(trans('error_name'));
  }

  // Validate email and phone
  if (!validateEmail($request->post['email']) 
    AND (empty($request->post['phone']) 
      || !valdateMobilePhone($request->post['phone']))) {
    throw new Exception(trans('error_email_or_mobile'));
  }

  // Validate password
  if(empty($request->post['password'])) {
    throw new Exception(trans('error_password'));
  }

  // Check password strongness
  if (($errMsg = checkPasswordStrongness($request->post['password'])) != 'ok') {
    throw new Exception($errMsg);
  } 

  // Password matching
  if($request->post['password'] !== $request->post['retype_password']) {
    throw new Exception(trans('error_password_not_match'));
  }
}

function validate_register_existance($request, $id = 0)
{
  // Check email address, if exist or not?
  if (!empty($request->post['email'])) {
    $statement = db()->prepare("SELECT * FROM `customers` WHERE `customer_email` = ? AND `customer_id` != ?");
    $statement->execute(array($request->post['email'], $id));
    if ($statement->rowCount() > 0) {
      throw new Exception(trans('error_email_exist'));
    }
  }

  // Check Mobile phone, is exist?
  if (!empty($request->post['phone'])) {
    $statement = db()->prepare("SELECT * FROM `customers` WHERE `customer_mobile` = ? AND `customer_id` != ?");
    $statement->execute(array($request->post['phone'], $id));
    if ($statement->rowCount() > 0) {
      throw new Exception(trans('error_phone_exist'));
    }
  }
}

if ($request->server['REQUEST_METHOD'] == 'POST' AND isset($request->post['action_type']) AND $request->post['action_type'] == 'CREATE')
{
  try {

    validate_register_request_data($request);
    validate_register_existance($request);
    $password = $request->post['password'];

    $request->post = array(
      'credit_balance' => 0,
      'due' => 0,
      'customer_name' => $request->post['name'],
      'dob' => date('Y-m-d', strtotime('1990-10-06')),
      'customer_email' => $request->post['email'],
      'customer_mobile' => $request->post['phone'],
      'customer_sex' => 1,
      'customer_age' => 20,
      'customer_address' => '000',
      'customer_city' => '000',
      'customer_state' => '0000',
      'customer_country' => '000',
      'status' => 1,
      'sort_order' => 1,
      'customer_store' => get_store_ids(),
    );

    $customer_id = $customer_model->addCustomer($request->post);
    $statement = db()->prepare("UPDATE `customers` SET `password` = ?, `raw_password` = ? WHERE `customer_id` = ?");
    $statement->execute(array(md5($password), $password, $customer_id));
    header('Content-Type: application/json');
    echo json_encode(array('msg' => trans('text_account_created'), 'id' => $customer_id));
    exit();

  } catch (Exception $e) { 

    header('HTTP/1.1 422 Unprocessable Entity');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array('errorMsg' => $e->getMessage()));
    exit();
  }
}


if ($request->server['REQUEST_METHOD'] == 'POST' AND isset($request->post['action_type']) AND $request->post['action_type'] == 'LOGIN')
{
  try {

    if (!validateString($request->post['username'])) {
      throw new Exception(trans('error_username'));
    }

    if (!validateString($request->post['password'])) {
      throw new Exception(trans('error_password'));
    }

    $username = $request->post['username'];
    $password = $request->post['password'];

    $statement = db()->prepare("SELECT * FROM `customers` WHERE (`customer_email` = ? OR `customer_mobile` = ?) AND `password` = ?");
    $statement->execute(array($username, $username, md5($password)));
    $the_customer = $statement->fetch(PDO::FETCH_ASSOC);
    if ($the_customer) {
      $session->data['is_clogged_in'] = 1;
      $session->data['cid'] = $the_customer['customer_id'];
      $session->data['cname'] = $the_customer['customer_name'];
    } else {
      throw new Exception(trans('error_record_not_found'));
    }
    header('Content-Type: application/json');
    echo json_encode(array('msg' => trans('text_login_success'), 'id' => $the_customer['customer_id']));
    exit();

  } catch (Exception $e) { 

    header('HTTP/1.1 422 Unprocessable Entity');
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(array('errorMsg' => $e->getMessage()));
    exit();
  }
}