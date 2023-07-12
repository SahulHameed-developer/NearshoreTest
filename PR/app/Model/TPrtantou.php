<?php
App::uses('AppModel', 'Model');
/**
 * 有益情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TPrtantou extends AppModel {
	public $name = 'TPrtantou';
	public $primaryKey = 'arno';
	
	public $validate = array(
			'tantounm' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "担当者名が未入力です。"
					)
			),
			'busyo' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "担当部署が未入力です。"
					)
			),
			'tantoumsg' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "メッセージが未入力です。"
					)
			)
	);
}
?>