<?php
App::uses('AppModel', 'Model');
/**
 * DLカテゴリーマスタのModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class MDlcate extends AppModel {
	public $validate = array(
			'dlcatenm' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "カテゴリー名を入力してください。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 30),
							'message' => '最大文字数を超えています。'
					)
			),
			'hyojino' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "表示順を入力してください。"
					),
					'numbersOnly' => array(
							'rule' => array('numbersOnly'),
							'message' => '数値を入力してください。'
					),
					'notzero' => array(
							'rule' => array('notzero'),
							'message' => '有効な表示順を入力してください。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 3),
							'message' => '最大文字数を超えています。'
					)
			)
	);
	function numbersOnly() {
		$hyojino = trim($this->data['MDlcate']['hyojino']);
		return preg_match('/^[0-9]*$/',$hyojino);
	}
	function notzero($fields) {
		$hyojino = trim($this->data['MDlcate']['hyojino']);
		if ($hyojino != 0) {
			return true;
		} else {
			return false;
		}
	}
}