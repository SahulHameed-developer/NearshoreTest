<?php
/**
 *
 * @projectName:
 * @ModuleName:
 * @author:
 * @createDate:     
 * @version:   
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 */

App::uses('Helper', 'View');
class CommonHelper extends Helper  
{
	
	/**
	 * getJapDate
	 *
	 * $date 日付
	 *
	 * @return $jpdate
	 *
	 */
	public static function getJapDate($date) {
		if (! empty ( $date )) {
			$day  = date("w",strtotime($date));
			$jpdays = array("日","月","火","水","木","金","土");
			$jpdayVal = $jpdays[$day];
			$jpdate =date('Y年m月d日',strtotime($date)) . '  (' . $jpdayVal . ')  ';
		} else {
			$jpdate = "";
		}
		return $jpdate;
	}
	
	/**
	 * getController コントローラ名取得
	 * 
	 * @return string|unknown
	 */
	public function getController() {
		$controller = $this->request->params ['controller'];
		if (! empty ( $controller )) {
			$controllerName = $controller;
		} else {
			$controllerName ="";
		}
		return $controllerName;
	}

	/**
	 *getAction　アクション名取得
	 *
	 * @return string|unknown
	 */
	public function getAction() {
		$action = $this->request->params ['action'];
		if (! empty ( $action )) {
			$actionrName = $action;
		} else {
			$actionrName ="";
		}
		return $actionrName;
	}
	
	/**
	 * getDateFormat
	 *
	 * $date 日付
	 *
	 * @return $date
	 *
	 */
	public function getDateFormat($date) {
		$datetime = new DateTime($date);
		$date = $datetime->format('Y.m.d');
		return $date;
	}
}
