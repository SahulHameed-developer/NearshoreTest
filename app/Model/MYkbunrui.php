<?php
App::uses('AppModel', 'Model');
/**
 * 役員分類マスタのModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class MYkbunrui extends AppModel {
	public $validate = array(
			'yakuinnm' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "名称が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'kmnm1' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "項目名称１が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 20),
							'message' => '最大文字数を超えています。'
					)
			),
			'kmnm2' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "項目名称２が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 20),
							'message' => '最大文字数を超えています。'
					)
			),
			'kmnm3' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "項目名称３が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 20),
							'message' => '最大文字数を超えています。'
					)
			),
			'kmnm4' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "項目名称４が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 20),
							'message' => '最大文字数を超えています。'
					)
			)
	);
}