<?php
App::uses('AppModel', 'Model');
/**
 * 会社情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TKaisya extends AppModel {
	public $name = 'TKaisya';
	public $primaryKey = 'kaisyacd';
	public $components = array('Session', 'Common');
	// 更新日付がNULLの場合は、登録日付
	public $virtualFields = array(
			'kousinTourokudt' => 'IF(TKaisya.kousindt = "0000-00-00 00:00:00" OR TKaisya.kousindt IS NULL, TKaisya.tourokudt, TKaisya.kousindt) '
	);
	// バリデーション
	public $validate = array(
			'kaisyacd' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "会員コードが未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 5),
							'message' => '最大文字数を超えています。'
					)
			),
			'kaisyanm' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "会社名称が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'kaisyanmkana' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 255),
							'message' => '最大文字数を超えています。'
					)
			),
			'yubinno' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 7),
							'message' => '最大文字数を超えています。'
					)
			),
			'jyusyo1' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 255),
							'message' => '最大文字数を超えています。'
					)
			),
			'jyusyo2' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 255),
							'message' => '最大文字数を超えています。'
					)
			),
			'telno' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 15),
							'message' => '最大文字数を超えています。'
					)
			),
			'faxno' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 15),
							'message' => '最大文字数を超えています。'
					)
			),
			'daihyoyknm' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 80),
							'message' => '最大文字数を超えています。'
					)
			),
			'daihyonm' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'seturitu' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 4),
							'message' => '最大文字数を超えています。'
					)
			),
			'jyugyoin' => array(
					'maxLength' => array(
							'rule' => array('range', -32769, 32768),
							'message' => '最大文字数を超えています。',
							'allowEmpty' => true
					)
			),
			'hpurl' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 255),
							'message' => '最大文字数を超えています。'
					)
			),
			'syasintitle1' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			),
			'syasintitle2' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			),
			'syasintitle3' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			)
		);
}