<?php

	class ExchangesTrade{
		public $date;
		public $price;
		public $amount;
		public $tid;
	}
	
	class Ticker{
		public $h;
		public $l;
		public $ll;
		public $a;
		public $av;
	}
	
	class OrderBook{
		public $asks;
		public $bids;
	}
	
	class UserBalance{
		public $BalanceBTC;
		public $BalanceLTC;
		public $BalanceNIS;
	}
	
	class AccountRaw{
		public $BalanceBTC;
		public $BalanceLTC;
		public $BalanceNIS;
		public $BTC;
		public $LTC;
		public $NIS;
		public $Created;
		public $Fee;
		public $FeeInNIS;
		public $id;
		public $OrderCreated;
		public $PricePerCoin;
		public $Ref;
		public $TypeId;
	}
	
	class AddOrderResponse{
		public $OrderResponse;
		public $NewOrder;
	}
	
	class OrderResponse{
		public $HasError;
		public $Error;
	}
	
	class od{
		public $d;
		public $t;
		public $s;
		public $a;
		public $p;
		public $p1;
		public $id;
		public $aa;
	}
	
	class OrderData{
	
		public $Amount;
		public $Price;
		public $Total;
		public $IsBid;
		public $Pair;
		
	}
	
	class TradeOrder{
		public $a;
		public $d;
		public $id;
		public $p;
		public $pair;
		public $isBid;
		public $s;
	}
	
	class Orders{
		public $bids;
		public $asks;
	}
	
	class NewOrders{
		public $bids;
		public $asks;
	}

	class CheckoutLinkModel{
		public $Price;
		public $Description;
		public $CoinType;
		public $ReturnURL;
		public $CancelURL;
		public $NotifyByEmail;
	}
	
	class CheckoutResponse{
		public $error;
		public $id;
	}
?>