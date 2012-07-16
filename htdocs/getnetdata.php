<?php

header("Content-type: text/json");


///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';


// Classes
//--------

use \clearos\apps\base\Engine as Engine;
use \clearos\apps\base\Shell as Shell;

clearos_load_library('base/Engine');
clearos_load_library('base/Shell');

// Exceptions
//-----------

use \clearos\apps\base\Validation_Exception as Validation_Exception;

clearos_load_library('base/Validation_Exception');

                  	try {
                                $shell = new Shell();
                                $args = '/proc/net/dev';
                                $shell->execute('/bin/cat', $args , false);
                                $output1 = $shell->get_output();
				$starttime = microtime(true);
			} catch (Exception $e) {
			        $this->page->view_exception($e);
			        return;
		        }
                       	usleep(800000);
			//sleep(1);
			try {
                        	$shell = new Shell();
                                $args = '/proc/net/dev';
                                $shell->execute('/bin/cat', $args , false);
                                $output2 = $shell->get_output();
				$finishtime = microtime(true);
                        } catch (Exception $e) {
                                $this->page->view_exception($e);
                                return;
                        }
                        // parse start data                                                                   
                        foreach($output1 as $line){
                                $line = " " . $line;
                                $line2 = preg_replace('/\s+/m',"|",$line);
                                if (strpos($line2,"eth")||preg_match("/^\|wlan/",$line2)||preg_match("/^\|ppp/",$line2)) {
                                      	$pieces=explode("|",$line2);
					$recvdata=explode(":",$pieces[1]);
					$interface=$recvdata[0];
					$ethlist[] = $interface;
					$start[$interface]['recvd']=$recvdata[1]*8/1000000;
					$start[$interface]['sent']=$pieces[9]*8/1000000; 
                                }
			}						
			// parse finish data
			foreach($output2 as $line){
                                $line = " " . $line;
                                $line2 = preg_replace('/\s+/m',"|",$line);
                                if (strpos($line2,"eth")||preg_match("/^|wlan/",$line2)||preg_match("/^\|ppp/",$line2)){
                                     	$pieces=explode("|",$line2);
					$recvdata=explode(":",$pieces[1]);
					$interface=$recvdata[0];
                                        $finish[$interface]['recvd']=$recvdata[1]*8/1000000;
					$finish[$interface]['sent']=$pieces[9]*8/1000000; 
                                }
                        }
	$timedelta = $finishtime - $starttime;// seconds measured using microtime
	//echo $timedelta ."|";								
	//$localtime = localtime();
	//print_r($localtime);
	//$time = mktime($localtime[2],$localtime[1],$localtime[0],$localtime[4]+1,$localtime[3],$localtime[5]+1900);
	//echo $time;
	//$x = $time * 1000; //formatted to convert from unix time to JS time
	$x = $finishtime * 1000;
	//echo $x ."|";
	foreach($ethlist as $interface){
		//echo $interface ."|";		
		$y = round(($finish[$interface]['recvd'] - $start[$interface]['recvd'])/$timedelta,3); //echo $y ."|";
		$z = round(($finish[$interface]['sent'] - $start[$interface]['sent'])/$timedelta,3); //echo $z ."|";
	
		//assemble array into two series
		$data[] = array('label'=>$interface.'-recv','data'=>array($x,$y));
		$data[] = array('label'=>$interface.'-sent','data'=>array($x,$z));
	}
	echo json_encode($data);
         
?>


