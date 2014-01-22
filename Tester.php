<?php
	require_once('Bit2cClient.php');
		
	//$client = new Bit2cClient("https://www.bit2c.co.il/","api-key","api-secret");

	// UserBalance Example 
	/*$balance = $client->Balance();	
	print_r($balance);*/
	
	
	// GetTrades Example 
	/*$trades = $client->GetTrades(PairType::BtcNis);
	print_r($trades); */
	
	// Get Ticker Example 
	/*$ticker = $client->GetTicker();
	print_r($ticker);*/
	
	
	/* Get Order Book Example
	$orderBook = $client->GetOrderBook();
	print_r($orderBook);*/
	
	/* AddOrder Example
	$orderData = new OrderData();
	$orderData->Amount = 1.2342;
	$orderData->Price = 3600;
	$orderData->Total = $orderData->Amount * $orderData->Price;
	$orderData->IsBid = true;
	$orderData->Pair = PairType::BtcNis;
	
	$orderRes = $client->AddOrder($orderData);
	print_r($orderRes);
	*/
	
	/* Get My Orders Example */
	/*$orders = $client->MyOrders();
	print_r($orders);*/
	
	/*Get Account History
	$history = $client->AccountHistory();
	print_r($history);
	*/
	
	/* Clear My Orders 
	$client->ClearMyOrders();
	*/
	
	/* Cancel Order
	$client->CancelOrder(123456);
	*/
	
	/* Create Checkout Example 
	$data =  new CheckoutLinkModel();
	$data->Price = 6000;
	$data->Description = 'my checkout';
	$data->CoinType = CoinType::NIS;
	$data->RetrunURL = '';
	$data->CancelURL = '';
	$data->NotifyByEmail = 'true';
	
	$response = $client->CreateCheckout($data);
	print_r($response);
	*/

?>