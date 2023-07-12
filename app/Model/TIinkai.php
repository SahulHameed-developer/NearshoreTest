<?php
App::uses('AppModel', 'Model');
/**
 * 委員会紹介情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TIinkai extends AppModel {
	public $name = 'TIinkai';
	public $components = array('Session', 'Common');
	public $validate = array(
		'gaiyou' => array(
			'notEmpty' => array(
					'rule' => array('notBlank'),
					'message' => "概要を入力してください。"
			)
		),
		'syasinTitle' => array(
			'notEmpty' => array(
					'rule' => array('notBlank'),
					'message' => "一覧写真タイトルを入力してください。"
			)
		)
	);
}