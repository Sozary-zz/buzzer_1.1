<?php
/*
 * Controler
 */

class mainController
{
	public static function welcome($request,$context)
	{
		return context::SUCCESS;
	}
	public static function about($request,$context){
		return context::SUCCESS;
	}
	public static function validatePseudo($request,$context){
		if(isset($request["name"],$request["pseudo"])){
			setcookie("pseudo",$request["pseudo"]);
			echo "0x1";
			return context::NONE;
		}
		echo "0x0";
		return context::NONE;
	}
	public static function gatherData($request,$context){
		if(isset($request["name"])){
			shell_exec('php gather.php '.$request["name"]);
			$data = explode(" ",file_get_contents($request["name"].'/'.$request["name"].'.res'));
			array_shift($data);
			echo json_encode($data);
			return context::NONE;
		}
		echo "0x0";
		return context::NONE;
	}
	public static function buzz($request,$context){
		if(isset($request["player"],$request["user"])){
			if(!file_exists($request["user"].'/'.$request["player"].'.buzz')){
				file_put_contents($request["user"].'/'.$request["player"].'-'.$request["user"].'.buzz',microtime(true));
				file_put_contents($request["user"].'/'.$request["player"].'.buzz',"");
				echo "0x1";

				return context::NONE;
			}
		}
		echo "0x0";
		return context::NONE;
	}
	public static function startBuzzer($request,$context){
		if(isset($request["name"])){
			file_put_contents($request["name"].'/started.session','');
			echo "0x1";
			return context::NONE;
		}
		echo "0x0";
		return context::NONE;
	}
	public static function isRunning($request,$context){
		if(isset($request["name"]))
			if(file_exists($request["name"].'/started.session')){
				echo "0x1";
			return context::NONE;
			}
		echo "0x0";
		return context::NONE;
	}
	public static function resetSession($request,$context){
		if(isset($request['name'])){
			shell_exec('rm -rf '.$request["name"].'/');
			echo "0x1";
			return context::NONE;
		}
		echo "0x0";
		return context::NONE;
	}
	public static function endSession($request,$context){
		if(isset($request['name'])){
			shell_exec('rm -rf '.$request["name"].'/');
			echo "0x1";
			return context::NONE;
		}
		echo "0x0";
		return context::NONE;
	}

	public static function user($request,$context){
		if(isset($request["name"]) && $request["name"]!=""){

			mkdir($request["name"]);
			$f = $request["name"].'/'.$request["name"].'.session';
			$context->name=$request["name"];

			if(file_exists($f)){
				if(file_get_contents($f) == session_id())
					$context->status = "admin";
				else
					$context->status = "student";
				$context->running = file_exists($request["name"].'/started.session');
			}
			else{
				file_put_contents($request["name"].'/'.$request["name"].'.session',session_id());
				$context->status = "admin";
			}

			return context::SUCCESS;
		}
		else
			return context::ERROR;


	}
}
