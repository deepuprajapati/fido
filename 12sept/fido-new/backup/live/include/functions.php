<?php
/**
*	ALL COMMON FUNCTIONS
*/

/*
*@access:	public
*@param:	Array
*@return:	Array in <pre> tag
*/

function d($data){
	if(isset($data) and is_array($data) and count($data)>0){
		echo"<pre>";
		print_r($data);
		echo"</pre>";
	}
	else{
		echo"<b><i>Empty Array</i></b>";
	}
}

/*
*@access:	public
*@param:	String
*@return:	A Redirection
*/
function redirect($uri){
	header('Location:'. $config['SITE_URL'].$uri);
	exit;
}

/*
*@access:	public
*@param:	String
*@return:	A Redirection
*/
function redirectAdmin($uri){
	header('Location:'. $config['SITE_URL'].$uri);
	exit;
}

function checkPermission($permission)	// used to see if user is having permission or not
{
	if(!is_array($permission))
		return false;
	foreach($permission as $key=>$per)
	{
		if(isset($_SESSION['permission'][$key][$per]) && $_SESSION['permission'][$key][$per]=='ON')
		{
			return true;
		}
		else{
			return false;
		}
	}
}
//checkPermission(1);
function convert_number_to_words(float $number,$x=1) {

   //$number = 190908100.25;
  if($x ==1){
      $moneypart1 = "Rupees";
      $moneypart2 = "Paise";
  }elseif ($x ==4) {
      $moneypart1 = "SGD";
      $moneypart2 = "cents";
  }
  else{
      $moneypart1 = "dollar";
      $moneypart2 = "cents";
  }
   $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "and ".$moneypart2." ". ($words[$decimal - $decimal%10] . " " . $words[$decimal % 10]) : '';
    return ($Rupees ? $moneypart1." ".$Rupees : '') . $paise. " Only";
}

//work order maker

function work_order_maker($num){
	$count = strlen($num);
	switch ($count) {
    case 1:
        return "000".$num;
        break;
    case 2:
        return "00".$num;
        break;
    case 3:
        return "0".$num;
        break;
	default:
        return 	$num;
}

}
function getList($val,$data = []){
    global $config;
    
		$url = $config['SITE_URL'].'api.php?check=' . $val;
		$data_string = json_encode($data);
		$ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		if(strlen($data_string) > 0) {
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    	'Content-Type: application/json',
		    	'Content-Length: ' . strlen($data_string))
				);
		}
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function getCURL($url){
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	//print_r($output);

	return $groups = json_decode($output, true);
}
function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

function postCURL($url,$data){
        $postdata='';
    $postdata=json_encode($data);
/* foreach($data as $key=>$value)
    {
        $postdata+=$key.'='.$value.'&';
    }*/
    
	$ch = curl_init();
    //$postdata= json_encode($data);
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    	'Content-Type: application/json',
		    	'Content-Length: ' . strlen($postdata))
    );
			
	$output = curl_exec($ch);
	curl_close($ch);
    if($output){
	return true;
    }else
    {
        return false;
    }
}

function isValidImage($url) {
	$url_headers=explode(".", $url);
	if(isset($url_headers[1])){
			$type=strtolower($url_headers[1]);
			$valid_image_type=array('png','jpeg','jpg','gif','pdf');

			if(in_array($type,$valid_image_type)){
					return true; // Its an image
			}
			return false;// Its an URL
	}
}

function dd($val){
	echo"<pre>";
	print_r($val);
	echo"<pre>";
	die;
}
function isEligibleForInvoice($x){
	$media_report = new media_report();
	$mreport = $media_report->findCustom( array('media_id' => $x,'active'=>1 ));
	if (array_key_exists(0, $mreport)) {
		if($mreport[0]['active'] == 1) $check = 1;
	}
	else{
		$check = 0;
	}
	$project  = new project();
	$val = $project->find($x);
	if($val['process'] == 1 && $val['po_approvel'] == 1 && $check == 1){
		return true;
	}
	else {
		return false;
	}

}

function isEligibleForInvoiceForNonmedia($x){
	$project  = new project();
	$val = $project->find($x);
	if($val['process'] == 1 && $val['po_approvel'] == 1){
		return true;
	}
	else {
		return false;
	}
}

function hasPermission($x,$y){
			if (in_array($x, $y)) {
		    return true;
			}
			else {
				return false;
			}
}
 
function createEstimate($x,$name){
    global $config;
	$company=new Partner();
	$project  = new project();
	$workOrder = new est_order2017();
	$wo1 = $workOrder->max('wo');
 $wo2 = work_order_maker($wo1);
 $Fyear=$project->getFinancialYear();
 $wo = "ESTIMATE/".$Fyear."/".$wo2;
    
	$workOrder->wo = ($wo1+1);
	$workOrder->create();
	$project->id = $x;
	$project->W_O = $wo;
	$project->status = 1;
	$project->save();
	$comp = $project->findcustomrow(array('id'=>$x));
	$comp1 = $company->findcustomrow(array('id'=>$comp['clientid']));
	$user = new User();
	$accntlead = $user->findcustomrow(array('id'=>$comp1['account_lead']));
	$usermail = $user->findcustomrow(array('id'=>$comp['userid']));
$message.= "The Requisition slip has been Approved by <strong>".$name."</strong>. Please visit FIDO to Upload its PO.
<br><br>";
$message.= "PFB further details: <br><br>";
$message.= "<strong>Requisition No:- ".$comp['Requisition_No']." .<br><br> Estimate No:- ".$wo.".<br><br> Project Name :- ".$comp['project_name'].".<br><br>  Client:- ".$comp1['partner_name']."</strong>";
                $urlforservice = ($config['API_BASE_URL']."sendmail");
		
                $data['email']=$usermail['email'];
                $data['name']=$usermail['name'];
                $data['msg']=$message;
                $data['subject'] ='New Estimate Approved';
                $services = postCURL($urlforservice,$data);
    $cmnt = "<strong>".$comp['project_name']."</strong> has been <strong>approved</strong> by <strong>".$name."</strong> and estimate no is <strong>".$wo."</strong>";
                saveNotification($usermail['id'],$cmnt,0,$wo,1);
}

function deleteEstimate($x){
	$project  = new project();
	$project_history = new project_history();
	$sql = 'CALL rowshift('.$x.')';
	$project_history->customQuery($sql);
	$project->delete($x);

}

function saveNotification($a,$b,$c,$d,$e)
        {
            $notification = new notification();
            $notification->user_id = $a;
            $notification->comment = htmlspecialchars($b);
            $notification->danger = $c;
            $notification->url = $d;
            $notification->active = $e;
            $notification->create();
        }

function docApproval($x){
    $project  = new project();
	$project->id = $x;
	$project->po_approvel = 1;
	$project->save();
}

function checkParent($id){
    $user  = new Admin();
    global $alw;
    foreach($user->all() as $k=>$v){
        if($v['id'] == $id){
             $alw[] = $v['parent_id'];
             checkParent($v['parent_id']);
        }
    }
    return $alw;
}
 

function count_digit($number) {
  return strlen($number);
}

function divider($number_of_digits) {
    $tens="1";

  if($number_of_digits>8)
    return 10000000;

  while(($number_of_digits-1)>0)
  {
    $tens.="0";
    $number_of_digits--;
  }
  return $tens;
}

function showInTwoDigit($x){
$num = $x;
$ext="";//thousand,lac, crore
$number_of_digits = count_digit($num); //this is call :)
    if($number_of_digits>3)
{
    if($number_of_digits%2!=0)
        $divider=divider($number_of_digits-1);
    else
        $divider=divider($number_of_digits);
}
else
    $divider=1;

$fraction=$num/$divider;
$fraction=number_format($fraction,2);
if($number_of_digits==4 ||$number_of_digits==5)
    $ext="k";
if($number_of_digits==6 ||$number_of_digits==7)
    $ext="Lac";
if($number_of_digits==8 ||$number_of_digits==9)
    $ext="Cr";
return $fraction;
}

function getPercent($x,$y){
    return $x*100/$y;
}

function desimal_to_digit($x){
    $originalNumber = $x;
    $multipliedNumber = originalNumber * 100; //output is 15086.99
    $integerMultipliedNumber = floor($multipliedNumber); //output is 15086
    $twoDecimalResult = (float) ($integerMultipliedNumber / 100); //output is 150.86
    return $twoDecimalResult;
}

?>
