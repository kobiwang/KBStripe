<?php
/**
 * Created by PhpStorm.
 * User: kobi
 * Date: 15/10/15
 * Time: 下午1:56
 */

require './stripe/init.php';


//你 的 key
\Stripe\Stripe::setApiKey("sk_test_xxxxxxxxxxxxxxx");


//根据银行卡生成token
function createTokenWithCard()
{

    try {
        $result = \Stripe\Token::create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 10,
                "exp_year" => 2016,
                "cvc" => "314"
            )
        ));

        $token = $result->id;
        echo $result;
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }


}

//根据银行卡生成custom
function createCustomerWithCard()
{

    try {
        $result = \Stripe\Token::create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 10,
                "exp_year" => 2016,
                "cvc" => "314"
            )
        ));

        $token = $result->id;

        $customer = \Stripe\Customer::create(array(
            "description" => "kobi.wang@gmail.com",
            "email"=>"kobi.wang@gmail.com",
            "source" => $token // obtained with Stripe.js
        ));

        echo $customer;
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }

}


//根据customer_id 付款
function createPayWithCustemor($customer_id)
{
    try {
        $result = \Stripe\Charge::create(array("amount" => 50,
            "currency" => "usd",
            "customer" => "cus_xxxxxxxxxxx",
            'description' => "bbbbbssss"
        ));
        echo $result;

    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }


}


//根据信用卡付款
function createPayWithToken()
{

    try {
        $result = \Stripe\Charge::create(array("amount" => 50,
            "currency" => "usd",
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 10,
                "exp_year" => 2016,
                "cvc" => "314"
            ),
            'description' => "bbbbbssss"
        ));
        echo $result;

    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }

}


//创建循环付款计划 , interval 循环时间 : day, week, month or year.  $planID 是自己定义的字符串  是最关键的数据
function testCreatePlan()
{

    try {
        //self::authorizeFromEnv();
        $planID = 'pro-39';
        $plan = \Stripe\Plan::create(array(
            'amount' => 3900,
            'interval' => 'day',
            'currency' => 'usd',
            'name' => 'Plan',
            'id' => $planID
        ));

        echo $plan;

    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }

}


//创建信用卡循环付款客户
function testCustemPayPlanWithCard()
{


    try {

        $result = \Stripe\Token::create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 10,
                "exp_year" => 2016,
                "cvc" => "314"
            )
        ));


        // plan 是后台创建好的 plan id
        $customer = \Stripe\Customer::create(array(
            "description" => "kobi.wang@gmail.com",
            "email" => "kobi.wang@gmail.com",
            "source" => $result->id, // obtained with Stripe.js
            "plan" => "pro-39"
        ));


        echo $customer;

    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }


}

//删除信用卡循环付款客户
function testDeleteCustem($custem_id)
{


    try {
        $cu = \Stripe\Customer::retrieve($custem_id);
        $result = $cu->delete();
        echo $result;
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }

}


//更新客户信用卡
function updateCustomer($custem_id){

    try {

        $result = \Stripe\Token::create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 10,
                "exp_year" => 2016,
                "cvc" => "314"
            )
        ));


        $cu = \Stripe\Customer::retrieve($custem_id);
        $cu->source = $result->id; // obtained with Stripe.js
        $cu->save();
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }


}



//testCustemPayPlanWithCard();

//createTokenWithCard();

