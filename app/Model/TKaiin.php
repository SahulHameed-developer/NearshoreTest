<?php
App::uses('AppModel', 'Model');
/**
 * 会員情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TKaiin extends AppModel {
	public $name = 'TKaiin';
	public $primaryKey = 'kaiincd';
	public $components = array('Session', 'Common');
	public $virtualFields = array(
			'kyoukaiykcdEmpty' => 'IF(TKaiin.kyoukaiykcd IS NULL, 999, IF(TKaiin.kyoukaiykcd = "", 999, TKaiin.kyoukaiykcd))',
			'kaiinnmkanaEmpty' => 'IF(TKaiin.kaiinnmkana IS NULL, TKaiin.kaiinnm, IF(TKaiin.kaiinnmkana = "", TKaiin.kaiinnm, TKaiin.kaiinnmkana))'
	);
	// バリデーション
	public $validate = array(
			'kaiincd' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "会員コードが未入力です。"
					),
					'numeric' => array(
							'rule' => 'numeric',
							'allowEmpty' => true,
							'message' => '会員コードが無効です。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 6),
							'message' => '最大文字数を超えています。'
					)
			),
			'kaiinsbcd' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "会員種別が未選択です。"
					)
			),
			'kaiinnm' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "会員名称が未入力です。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'kaiinnmkana' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'kaisyayknm' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'mailaddr' => array(
					'mail' => array(
							'rule' => 'email',
							'allowEmpty' => true,
							'message' => 'メールアドレスが無効です。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'seinendate' => array(
					'date' => array(
							'rule' => 'date',
							'allowEmpty' => true,
							'message' => '生年月日が無効です。'
					)
			),
			'nyukaidate' => array(
					'date' => array(
							'rule' => 'date',
							'allowEmpty' => true,
							'message' => '入会日付が無効です。'
					)
			),
			'taikaidate' => array(
					'date' => array(
							'rule' => 'date',
							'allowEmpty' => true,
							'message' => '退会日付が無効です。'
					)
			),
			'syokaisyanm' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'ksyasintitle' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			),
			'tmailaddr1' => array(
					'mail' => array(
							'rule' => 'email',
							'allowEmpty' => true,
							'message' => '通知メールアドレス1が無効です。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'tmailaddr2' => array(
					'mail' => array(
							'rule' => 'email',
							'allowEmpty' => true,
							'message' => '通知メールアドレス2が無効です。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'tmailaddr3' => array(
					'mail' => array(
							'rule' => 'email',
							'allowEmpty' => true,
							'message' => '通知メールアドレス3が無効です。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'lgid' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'lgpass' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'jyubinno' => array(
					'numeric' => array(
							'rule' => 'numeric',
							'allowEmpty' => true,
							'message' => '自宅郵便番号が無効です。'
					),
					'maxLength' => array(
							'rule' => array('maxLength', 7),
							'message' => '最大文字数を超えています。'
					)
			),
			'jjyusyo1' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 255),
							'message' => '最大文字数を超えています。'
					)
			),
			'jjyusyo2' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 255),
							'message' => '最大文字数を超えています。'
					)
			),
			'jtelno' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 15),
							'message' => '最大文字数を超えています。'
					)
			),
			'kttelno' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 15),
							'message' => '最大文字数を超えています。'
					)
			),
			'ktmailaddr' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'syumitxt1' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'syumitxt2' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'syumitxt3' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					)
			),
			'sikousyoku' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			),
			'sikounomi' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			)
	);
	function beforeSave($options = array()) {
		$count = $this->find('count', array(
				'conditions' => array('kaiincd' => $this->data[$this->name]['kaiincd'])
		));
		if ($count == 0) {
			return true;
		}
		return false;
	}
}