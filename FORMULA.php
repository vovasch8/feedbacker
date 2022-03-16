<?php
class FORMULA
{
    private $conn;
	
	public function __construct($conn)
		{
			$this->conn = $conn;
			$this->array_kiev_departments = array(7);
			$this->array_odess_departments = array(9);
			$this->array_dnepr_departments = array(5);
			$this->array_lviv_departments = array(15);
			$this->array_if_departments = array(2,13);
			$this->array_ch_departments = array(12,3);
		}


	public function getCarSheduleBySmenaId($smena_item)
		{
			$sql = 'SELECT  `car_shedule`  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			return $row['car_shedule'];
		}

    public function kassa($smena_item)  // чистая касса
        {
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if($row['nal_hand'])
			{
				$nal_uklon = $row['nal_hand'];
			} else {

			if($car_shedule ==='12/12'){
				$nal_uklon = $row['nal'];
				} else {
				$nal_uklon = $row['nal_24'];
				}
			}	

			if($row['beznal_hand'])
			{
				$beznal_uklon = $row['beznal_hand'];
			} else {

			if($car_shedule ==='12/12'){
				$beznal_uklon = $row['beznal'];
				} else {
				$beznal_uklon = $row['beznal_24'];
				}
			}
			
			$nal_bolt = $row['bolt_nal_no_comission_hand'];
			$beznal_bolt = $row['bolt_beznal_no_comission_hand'];
			

			$kassa = $nal_uklon + $beznal_uklon;
			
			if($row['department']==6||$row['department']==12||$row['department']==9||$row['department']==3)
			{
				$uklon_persent = 0.85;
			} else {
				$uklon_persent = 0.83;
			}
			
			
			$kassa = round($kassa*$uklon_persent + $row['hand']) + $nal_bolt + $beznal_bolt;// + добавить нал болт на руках
			return $kassa;
		}
		
		
	public function total_kassa($smena)  // тотал чистой кассы
        {
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$total_kassa = '';
			foreach($smena as $smena_item)
			{
				$kassa = $this->kassa($smena_item['id']);
				$total_kassa = $total_kassa + $kassa;
			}
			return $total_kassa;
		}
		
	
	public function kassa_department($smena_item)  // чистая касса
        {
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			
			
			if($row['nal_hand'])
			{
				$nal_uklon = $row['nal_hand'];
			} else {
				
				if($car_shedule ==='12/12'){
				$nal_uklon = $row['nal'];
				} else {
				$nal_uklon = $row['nal_24'];
				}
			}
			
			$nal_bolt = $row['bolt_nal_no_comission_hand'];			
			$kassa_department = $nal_uklon + $row['hand'] + $nal_bolt;// + добавить нал болт на руках
			return $kassa_department;
		}
		
	public function total_kassa_department($smena)  // тотал чистой кассы
        {
			$total_kassa_department = '';
			foreach($smena as $smena_item)
			{
				$kassa_department = $this->kassa_department($smena_item['id']);
				$total_kassa_department = $total_kassa_department + $kassa_department;
			}
			return $total_kassa_department;
		}
		
	
		
	public function mileage_formula($smena_item)  // чистая касса
        {
			
			
			
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			
			
			if($row['mileage_uklon_hand'])
			{
			$mileage_uklon = $row['mileage_uklon_hand'];
			} else {
			
			if($car_shedule ==='12/12'){
				$mileage_uklon = intval($row['mileage_uklon']);
				} else {
				$mileage_uklon = intval($row['mileage_uklon_24']);
				}
			}
			
			if($row['orders_number_hand'])
			{
				$orders_number = $row['orders_number_hand'];
			} else {
				
				if($car_shedule ==='12/12'){
				$orders_number = $row['orders_number'];
				} else {
				$orders_number = $row['orders_number_24'];	
				}
			}
			
			$bolt_mileage = $row['bolt_mileage_hand'];	
			$bolt_orders = $row['bolt_orders_hand'];	
			
			//echo $smena_item['id'].' - '.$mileage_uklon.' - '.$orders_number.' - '.$row['hand'].'<br>';
		
			if($mileage_uklon||$bolt_mileage){
			$mileage_formula = round($mileage_uklon + $orders_number*3 + $row['hand']/8 + $bolt_mileage + $bolt_orders*3);
			} else {
			$mileage_formula = '';	
			}
			return $mileage_formula;
		}

	public function total_formula_mileage($smena)  // тотал чистой кассы
        {
			$total_formula_mileage = '';
			foreach($smena as $smena_item)
			{
				$mileage_formula = $this->mileage_formula($smena_item['id']);
				$total_formula_mileage = $total_formula_mileage + $mileage_formula;
			}
			return $total_formula_mileage;
		}

	


	public function nal_uklon($smena_item)  // чистая касса
        {
			
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if($row['nal_hand'])
			{
				$nal_uklon = $row['nal_hand'];
			} else {
				
				if($car_shedule ==='12/12'){
				$nal_uklon = $row['nal'];
				} else {
				$nal_uklon = $row['nal_24'];
				}
			}
			return $nal_uklon;
		}
		
		
		public function socar_amount($smena_item)  // чистая касса
        {
			
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if($row['socar_amount_hand'])
			{
				$socar_amount = $row['socar_amount_hand'];
			} else {
				
				if($car_shedule ==='12/12'){
				$socar_amount = $row['socar_amount_12'];
				} else {
				$socar_amount = $row['socar_amount_24'];
				}
			}
			return $socar_amount;
		}
		
		

	public function total_nal_uklon($smena)  // тотал чистой кассы
        {
			$total_nal_uklon = '';
			
			foreach($smena as $smena_item)
			{
				$nal_uklon = $this->nal_uklon($smena_item['id']);
				$total_nal_uklon = $total_nal_uklon + $nal_uklon;
			}
			
			return $total_nal_uklon;
		}

	public function beznal_uklon($smena_item)  // чистая касса
        {
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if($row['beznal_hand'])
			{
				$beznal_uklon = $row['beznal_hand'];
			} else {
				if($car_shedule ==='12/12'){
				$beznal_uklon = $row['beznal'];
				} else {
				$beznal_uklon = $row['beznal_24'];
				}
			}
			return $beznal_uklon;
		}
		
	public function total_beznal_uklon($smena)  // тотал чистой кассы
        {
			$total_beznal_uklon = '';
			foreach($smena as $smena_item)
			{
				$beznal_uklon = $this->beznal_uklon($smena_item['id']);
				$total_beznal_uklon = $total_beznal_uklon + $beznal_uklon;
			}
			return $total_beznal_uklon;
		}
		
	public function total_hand($smena)  // чистая касса
        {
			$total_hand = '';
			foreach($smena as $smena_item)
			{
				$total_hand = $total_hand + $smena_item['hand']; 
			}
			return $total_hand;
		}
		
		
	public function bg($status)  // чистая касса
        {
		switch ($status)
		{
		case 1:
		$bg = "table-success";
		$item_statuses_on_work++;
		break;
		
		case 2:
		$bg = "table-warning";
		break;
		
		case 3:
		$bg = "table-danger";
		break;
		
		default:
		$bg = '';
		}
			return $bg;
		}
		
		
		public function uklon_rides($smena_item)  // чистая касса
        {
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if($row['orders_number_hand'])
			{
				$uklon_rides = $row['orders_number_hand'];
			} else {
				
				if($car_shedule ==='12/12'){
				$uklon_rides = $row['orders_number'];
				} else {
				$uklon_rides = $row['orders_number_24'];	
				}
			}
			return $uklon_rides;
		}
		
		public function total_uklon_rides($smena)  // тотал чистой кассы
        {
			$total_uklon_rides = '';
			foreach($smena as $smena_item)
			{
				$uklon_rides= $this->uklon_rides($smena_item['id'], $car_shedule);
				$total_uklon_rides = $total_uklon_rides + $uklon_rides;
			}
			return $total_uklon_rides;
		}
		
		public function uklon_cansel($smena_item)  // чистая касса
        {
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if($row['cancel_number_hand'])
			{
				$uklon_cansel = $row['cancel_number_hand'];
			} else {
				if($car_shedule ==='12/12'){
				$uklon_cansel = $row['cancel_number'];
				} else {
				$uklon_cansel = $row['cancel_number_24'];
				}
			}				
			return $uklon_cansel;
		}
		
		public function total_uklon_cansel($smena)  // тотал чистой кассы
        {
			$total_uklon_cansel = '';
			foreach($smena as $smena_item)
			{
				$uklon_cansel= $this->uklon_cansel($smena_item['id'], $car_shedule);
				$total_uklon_cansel = $total_uklon_cansel + $uklon_cansel;
			}
			return $total_uklon_cansel;
		}
		
		public function uklon_mileage($smena_item)  // чистая касса
        {
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if($row['mileage_uklon_hand'])
			{
			$uklon_mileage = $row['mileage_uklon_hand'];
			} else {
			
			if($car_shedule ==='12/12'){
				$uklon_mileage = intval($row['mileage_uklon']);
				} else {
				$uklon_mileage = intval($row['mileage_uklon_24']);
				}
			}
			return round($uklon_mileage);
		}
		
		public function total_uklon_mileage($smena)  // тотал чистой кассы
        {
			$total_uklon_mileage = '';
			foreach($smena as $smena_item)
			{
				$uklon_mileage= $this->uklon_mileage($smena_item['id'], $car_shedule);
				$total_uklon_mileage = $total_uklon_mileage + $uklon_mileage;
			}
			return $total_uklon_mileage;
		}
		
		
		public function gps_mileage($smena_item)  // чистая касса
        {
			$car_shedule = $this->getCarSheduleBySmenaId($smena_item);
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			if($row['car_mileage_gps_hand'])
			{
				$gps_mileage = $row['car_mileage_gps_hand'];
			} else {
			if($car_shedule ==='12/12'){
			$gps_mileage = intval($row['car_mileage_gps']);
			} else {
			$gps_mileage = intval($row['car_mileage_gps_24']);	
			}
			}
			return $gps_mileage;
		}
		
		public function total_gps_mileage($smena)  // тотал чистой кассы
        {
			$total_gps_mileage = '';
			foreach($smena as $smena_item)
			{
				$gps_mileage= $this->gps_mileage($smena_item['id']);
				$total_gps_mileage = $total_gps_mileage + $gps_mileage;
			}
			return $total_gps_mileage;
		}
		
		
		public function total_bonus($smena)  // тотал чистой кассы
        {
			$total_bonus = '';
			foreach($smena as $smena_item)
			{
				$total_bonus = $total_bonus + $smena_item['bonus'];
			}
			return $total_bonus;
		}
		
		public function penalty_amount($gps_mileage, $mileage_formula)  // тотал чистой кассы
        {
			$penalty = $gps_mileage - $mileage_formula - 25;
			if($penalty >= 0){$penalty_amount = round($penalty*3.3);} 
			return $penalty_amount;
		}
		
		public function driver_salary($kassa , $car_profit, $socar_amount)
        {
			$driver_salary = $kassa - $car_profit - $socar_amount; // Зарплата водителя
			return $driver_salary;
		}

		public function bolt_nal_with_comission($smena_item)  // чистая касса
        {
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$row['bolt_nal_with_comission_hand'] ? $bolt_nal_with_comission = $row['bolt_nal_with_comission_hand'] : $bolt_nal_with_comission = $row['bolt_nal_with_comission'];
			return $bolt_nal_with_comission;
		}
		
		public function total_bolt_nal_with_comission($smena)  // тотал чистой кассы
        {
			$total_bolt_nal_with_comission = '';
			foreach($smena as $smena_item)
			{
				$bolt_nal_with_comission= $this->bolt_nal_with_comission($smena_item['id']);
				$total_bolt_nal_with_comission = $total_bolt_nal_with_comission + $bolt_nal_with_comission;
			}
			return $total_bolt_nal_with_comission;
		}
		
		
		public function bolt_nal_no_comission($smena_item)  // чистая касса
        {
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$row['bolt_nal_no_comission_hand'] ? $bolt_nal_no_comission = $row['bolt_nal_no_comission_hand'] : $bolt_nal_no_comission = $row['bolt_nal_no_comission'];
			return $bolt_nal_no_comission;
		}
		
		public function total_bolt_nal_no_comission($smena)  // тотал чистой кассы
        {
			$total_bolt_nal_no_comission = '';
			foreach($smena as $smena_item)
			{
				$bolt_nal_no_comission= $this->bolt_nal_no_comission($smena_item['id']);
				$total_bolt_nal_no_comission = $total_bolt_nal_no_comission + $bolt_nal_no_comission;
			}
			return $total_bolt_nal_no_comission;
		}
		
		
		public function bolt_beznal_no_comission($smena_item)  // чистая касса
        {
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$row['bolt_beznal_no_comission_hand'] ? $bolt_beznal_no_comission = $row['bolt_beznal_no_comission_hand'] : $bolt_beznal_no_comission = $row['bolt_beznal_no_comission'];
			return $bolt_beznal_no_comission;
		}
		
		public function total_bolt_beznal_no_comission($smena)  // тотал чистой кассы
        {
			$total_bolt_beznal_no_comission = '';
			foreach($smena as $smena_item)
			{
				$bolt_beznal_no_comission= $this->bolt_beznal_no_comission($smena_item['id']);
				$total_bolt_beznal_no_comission = $total_bolt_beznal_no_comission + $bolt_beznal_no_comission;
			}
			return $total_bolt_beznal_no_comission;
		}
		
		public function bolt_orders($smena_item)  // чистая касса
        {
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$row['bolt_orders_hand'] ? $bolt_orders = $row['bolt_orders_hand'] : $bolt_orders = $row['bolt_orders'];
			return $bolt_orders;
		}
		
		public function total_bolt_orders($smena)  // тотал чистой кассы
        {
			$total_bolt_orders = '';
			foreach($smena as $smena_item)
			{
				$bolt_orders= $this->bolt_orders($smena_item['id']);
				$total_bolt_orders = $total_bolt_orders + $bolt_orders;
			}
			return $total_bolt_orders;
		}
		
		
		public function bolt_mileage($smena_item)  // чистая касса
        {
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$row['bolt_mileage_hand'] ? $bolt_mileage = $row['bolt_mileage_hand'] : $bolt_mileage = $row['bolt_mileage'];
			return $bolt_mileage;
		}
		
		public function total_bolt_mileage($smena)  // тотал чистой кассы
        {
			$total_bolt_mileage = '';
			foreach($smena as $smena_item)
			{
				$bolt_mileage= $this->bolt_mileage($smena_item['id']);
				$total_bolt_mileage = $total_bolt_mileage + $bolt_mileage;
			}
			return $total_bolt_mileage;
		}
		
		public function socar_amount_hand($smena_item)  // чистая касса
        {
			$sql = 'SELECT  *  FROM `smena` where `id` = '.$smena_item;
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			$socar_amount_hand = $row['socar_amount_hand'];
			return $socar_amount_hand;
		}
		
		
		
		
		public function carProfitKiev($kassa, $total_rides_per_car, $smena_item)
		{
			$department_id = $this->getSmenaItem($smena_item)['department'];
			$car_shedule  = $this->getSmenaItem($smena_item)['car_shedule'];
			$bonus  = $this->getSmenaItem($smena_item)['bonus'];
			
			if($car_shedule==='12/12')
			{
			
			if($kassa>=1900&&$total_rides_per_car>=16)
			{
				$car_profit = $kassa*0.25;
			} 
			elseif($kassa>=1600&&$total_rides_per_car>=15) 
			{
				$car_profit = $kassa*0.3;
				
			}
			elseif($kassa>=1350&&$total_rides_per_car>=14) 
			{
				$car_profit = $kassa*0.35;
			}
			elseif($kassa>=1200&&$total_rides_per_car>=13) 
			{
				$car_profit = $kassa*0.4;
				
			}
			elseif($kassa>=1100&&$total_rides_per_car>=13) 
			{
				$car_profit = $kassa*0.45;
			}
			else 
			{
				$kassa*0.45<450?$car_profit_min=450:$car_profit_min=$kassa*0.45;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			
			} else {
				
				if($kassa>=3600&&$total_rides_per_car>=32)
			{
				$car_profit = $kassa*0.25;
			} 
			elseif($kassa>=3200&&$total_rides_per_car>=30) 
			{
				$car_profit = $kassa*0.3;
				
			}
			elseif($kassa>=2700&&$total_rides_per_car>=28) 
			{
				$car_profit = $kassa*0.35;
				
			}
			elseif($kassa>=2400&&$total_rides_per_car>=26) 
			{
				$car_profit = $kassa*0.4;
				
			}
			elseif($kassa>=2200&&$total_rides_per_car>=26) 
			{
				$car_profit = $kassa*0.45;
			}
			else 
			{
				$kassa*0.45<900?$car_profit_min=900:$car_profit_min=$kassa*0.45;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			}
			return round($car_profit - $bonus);
		}
		
		
		public function carProfitOdessa($kassa, $total_rides_per_car, $smena_item)
		{
			$department_id = $this->getSmenaItem($smena_item)['department'];
			$car_shedule  = $this->getSmenaItem($smena_item)['car_shedule'];
			$bonus  = $this->getSmenaItem($smena_item)['bonus'];
			
			if($car_shedule==='12/12')
			{
			
			if($kassa>=2000&&$total_rides_per_car>=25)
			{
				$car_profit = $kassa*0.20;
			} 
			elseif($kassa>=1600&&$total_rides_per_car>=22) 
			{
				$car_profit = $kassa*0.25;
				
			}
			elseif($kassa>=1350&&$total_rides_per_car>=20) 
			{
				$car_profit = $kassa*0.30;
			}
			elseif($kassa>=1200&&$total_rides_per_car>=18) 
			{
				$car_profit = $kassa*0.35;
				
			}
			elseif($kassa>=1100&&$total_rides_per_car>=15) 
			{
				$car_profit = $kassa*0.40;
			}
			else 
			{
				$kassa*0.45<450?$car_profit_min=450:$car_profit_min=$kassa*0.45;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			
			} else {
				
				if($kassa>=4000&&$total_rides_per_car>=50)
			{
				$car_profit = $kassa*0.20;
			} 
			elseif($kassa>=3200&&$total_rides_per_car>=44) 
			{
				$car_profit = $kassa*0.25;
				
			}
			elseif($kassa>=2700&&$total_rides_per_car>=40) 
			{
				$car_profit = $kassa*0.30;
				
			}
			elseif($kassa>=2400&&$total_rides_per_car>=36) 
			{
				$car_profit = $kassa*0.35;
				
			}
			elseif($kassa>=2200&&$total_rides_per_car>=30) 
			{
				$car_profit = $kassa*0.40;
			}
			else 
			{
				$kassa*0.45<900?$car_profit_min=900:$car_profit_min=$kassa*0.45;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			}
			return round($car_profit - $bonus);
		}
		
		
		public function carProfitCharkiv($kassa, $total_rides_per_car, $smena_item)
		{
			$department_id = $this->getSmenaItem($smena_item)['department'];
			$car_shedule  = $this->getSmenaItem($smena_item)['car_shedule'];
			$bonus  = $this->getSmenaItem($smena_item)['bonus'];
			
			if($car_shedule==='12/12')
			{
			
			if($kassa>=1900&&$total_rides_per_car>=22)
			{
				$car_profit = $kassa*0.25;
			} 
			elseif($kassa>=1600&&$total_rides_per_car>=20) 
			{
				$car_profit = $kassa*0.30;
				
			}
			elseif($kassa>=1350&&$total_rides_per_car>=18) 
			{
				$car_profit = $kassa*0.35;
			}
			elseif($kassa>=1200&&$total_rides_per_car>=16) 
			{
				$car_profit = $kassa*0.40;
				
			}
			elseif($kassa>=1100&&$total_rides_per_car>=13) 
			{
				$car_profit = $kassa*0.45;
			}
			else 
			{
				$kassa*0.45<450?$car_profit_min=450:$car_profit_min=$kassa*0.45;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			
			} else {
				
				if($kassa>=3800&&$total_rides_per_car>=44)
			{
				$car_profit = $kassa*0.25;
			} 
			elseif($kassa>=3200&&$total_rides_per_car>=40) 
			{
				$car_profit = $kassa*0.30;
				
			}
			elseif($kassa>=2700&&$total_rides_per_car>=36) 
			{
				$car_profit = $kassa*0.35;
				
			}
			elseif($kassa>=2400&&$total_rides_per_car>=32) 
			{
				$car_profit = $kassa*0.40;
				
			}
			elseif($kassa>=2200&&$total_rides_per_car>=26) 
			{
				$car_profit = $kassa*0.45;
			}
			else 
			{
				$kassa*0.45<900?$car_profit_min=900:$car_profit_min=$kassa*0.45;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			}
			return round($car_profit - $bonus);
		}
		
		
		public function carProfitDnepr($kassa, $total_rides_per_car, $smena_item)
		{
			$department_id = $this->getSmenaItem($smena_item)['department'];
			$car_shedule  = $this->getSmenaItem($smena_item)['car_shedule'];
			$bonus  = $this->getSmenaItem($smena_item)['bonus'];
			
			if($car_shedule==='12/12')
			{
			
			if($kassa>=1800&&$total_rides_per_car>=22)
			{
				$car_profit = $kassa*0.25;
			} 
			elseif($kassa>=1600&&$total_rides_per_car>=20) 
			{
				$car_profit = $kassa*0.3;
				
			}
			elseif($kassa>=1350&&$total_rides_per_car>=18) 
			{
				$car_profit = $kassa*0.35;
			}
			elseif($kassa>=1200&&$total_rides_per_car>=16) 
			{
				$car_profit = $kassa*0.4;
				
			}
			elseif($kassa>=1100&&$total_rides_per_car>=13) 
			{
				$car_profit = $kassa*0.45;
			}
			else 
			{
				$kassa*0.45<450?$car_profit_min=450:$car_profit_min=$kassa*0.45;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			
			} else {
				
				if($kassa>=3600&&$total_rides_per_car>=44)
			{
				$car_profit = $kassa*0.25;
			} 
			elseif($kassa>=3200&&$total_rides_per_car>=40) 
			{
				$car_profit = $kassa*0.3;
				
			}
			elseif($kassa>=2700&&$total_rides_per_car>=36) 
			{
				$car_profit = $kassa*0.35;
				
			}
			elseif($kassa>=2400&&$total_rides_per_car>=32) 
			{
				$car_profit = $kassa*0.4;
				
			}
			elseif($kassa>=2200&&$total_rides_per_car>=26) 
			{
				$car_profit = $kassa*0.45;
			}
			else 
			{
				$kassa*0.45<900?$car_profit_min=900:$car_profit_min=$kassa*0.45;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			}
			return round($car_profit - $bonus);
		}
		
		public function carProfitLviv($kassa, $total_rides_per_car, $smena_item)
		{
			$department_id = $this->getSmenaItem($smena_item)['department'];
			$car_shedule  = $this->getSmenaItem($smena_item)['car_shedule'];
			$bonus  = $this->getSmenaItem($smena_item)['bonus'];
			
			if($car_shedule==='12/12')
			{
			
			if($kassa>=1900&&$total_rides_per_car>=23)
			{
				$car_profit = $kassa*0.20;
			} 
			elseif($kassa>=1700&&$total_rides_per_car>=21) 
			{
				$car_profit = $kassa*0.25;
				
			}
			elseif($kassa>=1500&&$total_rides_per_car>=19) 
			{
				$car_profit = $kassa*0.30;
			}
			elseif($kassa>=1350&&$total_rides_per_car>=17) 
			{
				$car_profit = $kassa*0.35;
				
			}
			elseif($kassa>=1200&&$total_rides_per_car>=15) 
			{
				$car_profit = $kassa*0.40;
			}
			else 
			{
				$kassa*0.40<450?$car_profit_min=450:$car_profit_min=$kassa*0.40;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			
			} else {
				
				if($kassa>=3800&&$total_rides_per_car>=46)
			{
				$car_profit = $kassa*0.20;
			} 
			elseif($kassa>=3400&&$total_rides_per_car>=42) 
			{
				$car_profit = $kassa*0.25;
				
			}
			elseif($kassa>=3000&&$total_rides_per_car>=38) 
			{
				$car_profit = $kassa*0.30;
				
			}
			elseif($kassa>=2700&&$total_rides_per_car>=34) 
			{
				$car_profit = $kassa*0.35;
				
			}
			elseif($kassa>=2400&&$total_rides_per_car>=30) 
			{
				$car_profit = $kassa*0.40;
			}
			else 
			{
				$kassa*0.40<900?$car_profit_min=900:$car_profit_min=$kassa*0.40;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			}
			return round($car_profit - $bonus);
		}
		
		
		public function carProfitIf($kassa, $total_rides_per_car, $smena_item)
		{
			$department_id = $this->getSmenaItem($smena_item)['department'];
			$car_shedule  = $this->getSmenaItem($smena_item)['car_shedule'];
			$bonus  = $this->getSmenaItem($smena_item)['bonus'];
			
			if($car_shedule==='12/12')
			{
			
			if($kassa>=2000&&$total_rides_per_car>=24)
			{
				$car_profit = $kassa*0.20;
			} 
			elseif($kassa>=1800&&$total_rides_per_car>=22) 
			{
				$car_profit = $kassa*0.25;
				
			}
			elseif($kassa>=1500&&$total_rides_per_car>=20) 
			{
				$car_profit = $kassa*0.30;
			}
			elseif($kassa>=1350&&$total_rides_per_car>=18) 
			{
				$car_profit = $kassa*0.35;
				
			}
			elseif($kassa>=1200&&$total_rides_per_car>=16) 
			{
				$car_profit = $kassa*0.40;
			}
			else 
			{
				$kassa*0.40<450?$car_profit_min=450:$car_profit_min=$kassa*0.40;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			
			} else {
				
				if($kassa>=4000&&$total_rides_per_car>=48)
			{
				$car_profit = $kassa*0.20;
			} 
			elseif($kassa>=3600&&$total_rides_per_car>=44) 
			{
				$car_profit = $kassa*0.25;
				
			}
			elseif($kassa>=3000&&$total_rides_per_car>=40) 
			{
				$car_profit = $kassa*0.30;
				
			}
			elseif($kassa>=2700&&$total_rides_per_car>=36) 
			{
				$car_profit = $kassa*0.35;
				
			}
			elseif($kassa>=2400&&$total_rides_per_car>=32) 
			{
				$car_profit = $kassa*0.40;
			}
			else 
			{
				$kassa*0.40<900?$car_profit_min=900:$car_profit_min=$kassa*0.40;
				!$kassa||!$total_rides_per_car?$car_profit='':$car_profit=$car_profit_min;
			}
			}
			return round($car_profit - $bonus);
		}
		
		
		public function getSmenaItem($smena_item)
		{
			$sql = 'SELECT  *  FROM `smena` WHERE `id` = "'.$smena_item.'"';
			$result = mysqli_query($this->conn, $sql);
			$row = mysqli_fetch_assoc($result);
			return $row;
		}
		
		public function calculator($smena_item)
		{
			$result=array();
			$kassa = $this->kassa($smena_item);
			$kassa_department = $this->kassa_department($smena_item);
			$mileage_formula = $this->mileage_formula($smena_item);
			$nal_uklon = $this->nal_uklon($smena_item);
			$beznal_uklon = $this->beznal_uklon($smena_item);
			$uklon_rides = $this->uklon_rides($smena_item);
			$uklon_cansel = $this->uklon_cansel($smena_item);
			$uklon_mileage = $this->uklon_mileage($smena_item);
			$gps_mileage = $this->gps_mileage($smena_item);
			$penalty_amount = $this->penalty_amount($gps_mileage, $mileage_formula);
			$bolt_nal_with_comission = $this->bolt_nal_with_comission($smena_item);
			$bolt_nal_no_comission = $this->bolt_nal_no_comission($smena_item);
			$bolt_beznal_no_comission = $this->bolt_beznal_no_comission($smena_item);
			$bolt_orders = $this->bolt_orders($smena_item);
			$total_rides_per_car = $uklon_rides + $bolt_orders;
			$bolt_mileage = $this->bolt_mileage($smena_item);
			$department_id = $this->getSmenaItem($smena_item)['department'];
			$socar_amount = $this->socar_amount($smena_item);
			$smena_shedule = $this->getSmenaItem($smena_item)['car_shedule'];
			
			if(in_array($department_id,$this->array_kiev_departments))
			{
				$car_profit = $this->carProfitKiev($kassa, $total_rides_per_car, $smena_item);
			}
			if(in_array($department_id,$this->array_ch_departments))
			{
				$car_profit = $this->carProfitCharkiv($kassa, $total_rides_per_car, $smena_item);
			}
			if(in_array($department_id,$this->array_odess_departments))
			{
				$car_profit = $this->carProfitOdessa($kassa, $total_rides_per_car, $smena_item);
			}
			if(in_array($department_id,$this->array_dnepr_departments))
			{
				$car_profit = $this->carProfitDnepr($kassa, $total_rides_per_car, $smena_item);
			}
			if(in_array($department_id,$this->array_lviv_departments))
			{
				$car_profit = $this->carProfitLviv($kassa, $total_rides_per_car, $smena_item);
			}
			if(in_array($department_id,$this->array_if_departments))
			{
				$car_profit = $this->carProfitIf($kassa, $total_rides_per_car, $smena_item);
			}
			
			$car_profit += $penalty_amount;
			
			$driver_salary = $this->driver_salary($kassa , $car_profit, $socar_amount);
						
			
			$result = array(
			'department_id' =>$department_id,
			'smena_shedule' =>$smena_shedule,
			'socar_amount' =>$socar_amount,
			'driver_salary' =>$driver_salary,
			'car_profit' =>$car_profit,
			'kassa' => $kassa,
			'kassa_department' => $kassa_department,
			'mileage_formula' => $mileage_formula,
			'nal_uklon' => $nal_uklon,
			'beznal_uklon' => $beznal_uklon,
			'uklon_rides' => $uklon_rides,
			'total_rides_per_car' => $total_rides_per_car,
			'uklon_cansel' => $uklon_cansel,
			'uklon_mileage' => $uklon_mileage,
			'gps_mileage' => $gps_mileage,
			'penalty_amount' => $penalty_amount,
			'bolt_nal_with_comission' => $bolt_nal_with_comission,
			'bolt_nal_no_comission' => $bolt_nal_no_comission,
			'bolt_beznal_no_comission' => $bolt_beznal_no_comission,
			'bolt_orders' => $bolt_orders,
			'bolt_mileage' => $bolt_mileage
			);
			
			return $result;
		}
		
		public function repairs_status($value)
		{
			$arr = get_object_vars(json_decode($value));
			$message ='';
			foreach($arr as $key=>$value)
			{
				if($key==='checkbox_dvs'&&$value){$message .=' ДВС';}
				if($key==='checkbox_akkp'&&$value){$message .=' АККП';}
				if($key==='checkbox_lkp'&&$value){$message .=' ЛКП';}
				if($key==='checkbox_dtp'&&$value){$message .=' ДТП';}
				if($key==='checkbox_xod'&&$value){$message .=' Ход.';}
				if($key==='checkbox_ele'&&$value){$message .=' Элект.';}
			}

			return $message;
		}
}


