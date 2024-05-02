<?php

function shop($field = null) 
{
	$shop_model = registry()->get('loader')->model('shop');
	if (!$field) {
		return $shop_model->get();
	}
	return $shop_model->get($field);
}