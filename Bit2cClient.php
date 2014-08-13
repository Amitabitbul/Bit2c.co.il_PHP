<?php
	require_once('Enums.php');
	require_once('Objects.php');
	
	class Bit2cClient{
		private $Key;
		private $Secret;
		private $Url;
		
		public function Bit2cClient($url , $key, $secret){
			$this->Key = $key;
			$this->Url = $url;
			$this->Secret = strtoupper($secret);	
		}
		
		public function GetQueryString($obj){
			$params['nonce'] = (time());
			
			if($obj != null)
			foreach( get_object_vars($obj) as $field_name => $field_value ){
				$params[$field_name] = $field_value;
			}
			
			$flag = false;
			$str = '';
			foreach( $params as $key => $val ){
				if( !$flag )
					$flag = true;
				else
					$str .= '&';
				
                if($key == 'IsBid')
                {
                    if( strlen($val) == 0 )
                        $val = 'false';
                    else
                        $val = 'true';
                }
                    
				$str .= "{$key}={$val}";
			}
			return ($str);
		}
		
		private function ComputeHash( $message ){
			return base64_encode(hash_hmac('sha512', $message, $this->Secret , true));
		}
		
		private function Query( $object , $url ){
			
			$qString = $this->GetQueryString($object);
			$sign = $this->ComputeHash($qString);
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL , $url);
			curl_setopt($curl,CURLOPT_HTTPHEADER,array("Key:{$this->Key}", "Sign:{$sign}")); 
			curl_setopt($curl,CURLOPT_POST,true); 
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl,CURLOPT_POSTFIELDS,$qString);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);			
			
			$res = curl_exec($curl);
			return $res;
		}
		
		private function CastObject($obj, $res){
			foreach( get_object_vars($res) as $field_name => $field_value ){
					$obj->$field_name = $field_value;
			}
			
			return $obj;
		}
		
		public function GetTrades($pair = PairType::BtcNis, $since = 0, $date = 0){
			$json = json_decode(file_get_contents("{$this->Url}Exchanges/{$pair}/trades.json"));
			foreach($json as $trade){
				$Trade = new ExchangesTrade();
				$Trade = $this->CastObject($Trade, $trade);
				$Trades[] = $Trade;
			}
			return $Trades;
		}
		
		public function GetTicker($pair = PairType::BtcNis){
			$json = json_decode(file_get_contents("{$this->Url}Exchanges/{$pair}/Ticker.json"));
			$ticker = new Ticker();
			$ticker = $this->CastObject($ticker, $json);
			return $ticker;
		}
		
		public function GetOrderBook($pair = PairType::BtcNis){
			$json = json_decode(file_get_contents("{$this->Url}Exchanges/{$pair}/orderbook.json"));
			$orderBook = new OrderBook();
			
			foreach($json->bids as $bid){
				$bids[] = $bid;
			}
			
			foreach($json->asks as $ask){
				$asks[] = $ask;
			}
			
			$orderBook->bids = $bids;
			$orderBook->asks=$asks;
			
			return $orderBook;
		}
		
		public function AddOrder($orderData){
			$url = "{$this->Url}Order/AddOrder";
			$json = json_decode($this->Query($orderData, $url));
			
			$orderRes = new OrderResponse();
			$od = new od();
			
			$od = $this->CastObject($od, $json->NewOrder);
			$orderRes = $this->CastObject($orderRes, $json->OrderResponse);
			
			$addOrderRes = new AddOrderResponse();
			$addOrderRes->OrderResponse = $orderRes;
			$addOrderRes->NewOrder = $od;
			
			return $addOrderRes;
		}
		
		public function MyOrders($pair = PairType::BtcNis){
			$obj = new stdClass();
			$obj->pair = $pair;
			
			$url = "{$this->Url}Order/MyOrders";
			$json = json_decode($this->Query($obj, $url));
			$orders = new Orders();
			
			if(!empty($json->bids)){
				foreach($json->bids as $bid){
					$tradeOrder = new TradeOrder();
					$tradeOrder = $this->CastObject($tradeOrder, $bid);
					$bids[] = $tradeOrder;
				}
				$orders->bids = $bids;
			}

			if(!empty($json->asks)){
				foreach($json->asks as $ask){
					$tradeOrder = new TradeOrder();
					$tradeOrder = $this->CastObject($tradeOrder, $ask);
					$asks[] = $tradeOrder;
				}
				$orders->asks = $asks;
			}
			
			return $orders;
		}
		
		public function AccountHistory($fromTime=0, $toTime=0){
			
			$obj = new stdClass();
			$obj->fromTime = $fromTime;
			$obj->toTime = $toTime;
			$url = "{$this->Url}Order/AccountHistory";
			
			$json = json_decode($this->Query($obj, $url));
			foreach($json as $raw){
				$accountRaw = new AccountRaw();
				$accountRaw = $this->CastObject($accountRaw, $raw);
				$accountRaws[] = $accountRaw;
			}
			
			return isset($accountRaws)? $accountRaws : null;
		}
		
		public function CancelOrder($id){
			$obj = new stdClass();
			$obj->id = $id;
			$url = "{$this->Url}Order/CancelOrder";
			$json = json_decode($this->Query($obj, $url));
			$orderResponse = new OrderResponse();
			$orderResponse = $this->CastObject($orderResponse, $json);
			return $orderResponse;
		}
		
		public function ClearMyOrders($pair = PairType::BtcNis){
			
			$orders = $this->MyOrders();
			foreach($orders as $type => $val){
				if(!empty($val))
				foreach($val as $order){
					if($order->pair == $pair)
						$this->CancelOrder($order->id);
				}
			}
		}
		
		public function Balance(){
			$url = "{$this->Url}Account/Balance";
			$response = $this->Query(null, $url);
			$json = json_decode($response);
			$balance = new UserBalance();
			$balance = $this->CastObject($balance, $json);
			return $balance;
		}
		
		public function CreateCheckout($data){
			$url = "{$this->Url}Merchant/CreateCheckout";
			$json = json_decode($this->Query($data, $url));
			$CheckoutResponse = new CheckoutResponse();
			$CheckoutResponse = $this->CastObject($CheckoutResponse , $json);
			return $CheckoutResponse;
		}
	}
?>