<?php
//Class thống kê truy cập
//By Songoku Zendvn
//5-5-2014
namespace ZendVN\Statistics;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
class Access{
	protected $adapter;
	protected $sqlObj;
    protected $db;
    protected $day;//Ngày hiện tại
    protected $month;//Tháng hiện tại
    protected $year;//Năm hiện tại
    public function __construct(){
        $this->adapter 	= GlobalAdapterFeature::getStaticAdapter();
        $this->sqlObj 	= new Sql($this->adapter);
        $now = getdate();//Thời gian truy cập hiện tại
        $this->day 		= $now["mday"];//Ngày hiện tại
        $this->month 	= $now["mon"];//Tháng hiện tại
        $this->year 	= $now["year"];//Năm hiện tại
        
        $this->accessToday();//Thông kê lượt truy cập trong ngày
        $this->totalCounterToday();//Tổng truy cập trong ngày
        $this->deleteAccessYesterday();//Xóa dữ liệu thống kê ngày hôm trước
    }
    public function accessToday(){
        //select IP đang truy cập tại thời điểm đó
        //$local = Zendvn_CurrentUrl::get();
        $ip = $_SERVER['REMOTE_ADDR'];
        //$ip = $this->db->quote($ip);

		
		$select     = $this->sqlObj->select();
		$select->from('statistics_access')
				->where('ip = "'.$ip.'"')
                ->where('day = '.$this->day)
                ->where('month = '.$this->month)
                ->where('year = '.$this->year);  
		 
		$result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
		$result = (!empty($result)) ? $result[0] : null;
		 

        //Nếu có dữ liệu truy cập của địa chỉ IP thì tiến hành cậpp nhật lượt truy cập cho IP dó
        if(!empty($result))
		{
            $time_accessDB 	= $result['time_access'];
            
            $time_access 	= time();//Thời gian hiện tại của người truy cập
			$time_out 		= 900;//15 phút truy cập
			$time_new 		= $time_access - $time_out;
            //Thời gian trong database nhỏ hon thời gian new nghia là họ đã rời website , vào một thời điểm nào dó trong ngày họ truy cập lại thì + 1 lượt truy câp cho IP đó
			if($time_accessDB < $time_new)
			{
				$counter = $result['counter'];
                $count = $counter + 1;
				$data = array(
							'counter'=>$count,
							'time_access'=>$time_access,
							);
			

				
				$updateObj  = $this->sqlObj->update('statistics_access');
				$updateObj->set($data);
				$updateObj->where('id = '.$result['id']);
				$sqlString  = $this->sqlObj->getSqlStringForSqlObject($updateObj);
				$this->adapter->query($sqlString)->execute();
			}	
		}
        //Nếu địa chỉ IP dang truy cập của thời gian hiện tại chua có trong database
		//Tiến hành insert Ðịa chỉ IP, lượt truy cập của IP dó = 1, ngày, tháng, nam của người dó khi truy cập vào website
		else{
            $time_access = time();
            $counter = 1;
			$data = array(
							'ip'=>$_SERVER['REMOTE_ADDR'],
							'counter'=>$counter,
							'day'=>$this->day,
							'month'=>$this->month,
							'year'=>$this->year,
							'time_access'=>$time_access,
							);

			
			$insertObj  = $this->sqlObj->insert('statistics_access');
			$insertObj->values($data);
			$sqlString  = $this->sqlObj->getSqlStringForSqlObject($insertObj);
			$this->adapter->query($sqlString)->execute();	
							
		}
		
    }
    //Xóa thống kê truy cập của ngày hôm trước
    public function deleteAccessYesterday(){
        //select dữ liệu không phải của ngày hiện tại
       
		$select     = $this->sqlObj->select();
		$select->from('statistics_access')
               	->where('day != '.$this->day)
                ->where('month != '.$this->month, \Zend\Db\Sql\Predicate\Predicate::OP_OR)
                ->where('year != '.$this->year, \Zend\Db\Sql\Predicate\Predicate::OP_OR);
		      
		$result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);

        foreach($result as $value){
            
			
			$deleteObj  = $this->sqlObj->delete('statistics_access');
			$deleteObj->where(
			new \Zend\Db\Sql\Predicate\In('id', array($value['id']))      
			);

			$sqlString  = $this->sqlObj->getSqlStringForSqlObject($deleteObj);
			$this->adapter->query($sqlString)->execute();
        }
    }
    //Tính tổng lượt truy cập của ngày
   	public function totalCounterToday()
	{
		$totalCounter = 0;
		
		$select     = $this->sqlObj->select();
		$select->from('statistics_access')
               	->where('day = '.$this->day)
                ->where('month = '.$this->month)
                ->where('year = '.$this->year);
		      
		$result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);

		foreach($result as $value)
		{
			$totalCounter += $value['counter'];//Tính tổng lượt truy cập của một ngày hôm đó
		}
		$this->accessDate($totalCounter);
	}
    //Cập nhật dữ liệu để thống kê theo biểu đồ, thống kê tổng lượt truy cập theo ngày, tháng, năm
    public function accessDate($totalCounter)
	{
        //Select dữ liệu truy cập của ngày hôm đó
       
		$select     = $this->sqlObj->select();
		$select->from('statistics_access_date')
				->where('day = '.$this->day)
                ->where('month = '.$this->month)
                ->where('year = '.$this->year);
		      
		$result     = \ZendVN\Db\Sql\Result::toArray($select,$this->adapter);
		$result     = (!empty($result)) ? $result[0] : null;

		//Nếu chưa có dữ liệu truy cập của ngày hôm đó thì tiến hành insert tổng số truy cập , ngày, tháng, năm
        if(empty($result['total_counter']))
		{
			$data = array(
						'total_counter'=>$totalCounter,
						'day'=>$this->day,
						'month'=>$this->month,
						'year'=>$this->year,
						);
			
			
			$insertObj  = $this->sqlObj->insert('statistics_access_date');
			$insertObj->values($data);
			$sqlString  = $this->sqlObj->getSqlStringForSqlObject($insertObj);
			$this->adapter->query($sqlString)->execute();	


		}else{
		//Ngược lại tiến hành update tổng lượt truy cập  
			$data = array(
						'total_counter'=>$totalCounter,
						);
			
			
			$updateObj  = $this->sqlObj->update('statistics_access_date');
			$updateObj->set($data);
			$updateObj->where('id = '.$result['id']);
			$sqlString  = $this->sqlObj->getSqlStringForSqlObject($updateObj);
			$this->adapter->query($sqlString)->execute();
		}
	}
} 
