<?php

	abstract  class AccountAction{
		const SellBTC = 0;
		const BuyBTC = 1;
		const FeeBuyBTC = 2;
		const FeeSellBTC = 3;
		const DepositBTC = 4;
		const DepositNIS = 5;
		const WithdrawalBTC = 6;
		const WithdrawalNIS = 7;
		const FeeWithdrawalBTC = 8;
		const FeeWithdrawalNIS = 9;
		const Unknown = 10;
		const PayWithBTC = 11;
		const ReceivedPaymentBTC = 12;
		const FeeReceivedPaymentBTC = 13;
		const DepositLTC = 14;
		const WithdrawalLTC = 15;
		const FeeWithdrawalLTC = 16;
		const BuyLTCBTC = 17;
		const SellLTCBTC = 18;
		const BuyLTCNIS = 19;
		const SellLTCNIS = 20;
	}
	
	abstract  class CoinType{
		const BTC = 0;
		const LTC = 1;
		const NIS = 2;
	}
	
	abstract  class OrderStatusType{
		const _New = 0;
		const Open = 1;
		const NoFunds = 2;
		const Wait = 3;
	}

	abstract  class PairType{
		const BtcNis = 0;
		const LtcBtc = 1;
		const LtcNis = 2;
	}

?>