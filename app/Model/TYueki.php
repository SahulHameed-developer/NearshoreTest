<?php
App::uses('AppModel', 'Model');
/**
 * 有益情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TYueki extends AppModel {
	public $name = 'TYueki';
	public $primaryKey = 'arno';
	public $components = array('Session', 'Common');
	// 更新日付がNULLの場合は、登録日付
	public $virtualFields = array(
			'kousinTourokudt' => 'IF(TYueki.kousindt = "0000-00-00 00:00:00" OR TYueki.kousindt IS NULL, TYueki.tourokudt, TYueki.kousindt) '
	);
	// バリデーション
	public $validate = array(
			'yuekidate' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "日付を入力してください。"
					),
					'date' => array(
							'rule' => 'date',
							'message' => "日付が不正な形式です。"
					)
			),
			'yuekitime' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "時刻を入力してください。"
 					)
			),
			'kaiinnm' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "会員名称が未入力です"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 40),
							'message' => '最大文字数を超えています。'
					),
					'withTwoString' => array(
							'rule' => array('withTwoString'),
							'message' => '姓と名の間に全角スペースを入力してください。'
					),
			),
			'title' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "タイトルを入力してください。"
					),
					'maxLength' => array(
							'rule' => array('maxLength', 100),
							'message' => '最大文字数を超えています。'
					)
			),
			'naiyo' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "内容を入力してください。"
					)
			),
			'syasin1Title' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			),
			'syasin2Title' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			),
			'syasin3Title' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			),
			'file1Title' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			),
			'file2Title' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			),
			'file3Title' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 60),
							'message' => '最大文字数を超えています。'
					)
			),
			'sankourl' => array(
					'maxLength' => array(
							'rule' => array('maxLength', 512),
							'message' => '最大文字数を超えています。'
					)
			)
	);
	/**
	 *　画面名：入会申込
	 *　機能名：全角スペースがあるチェックの処理。
	 */
	function withTwoString($fields) {
		$twoStringValue = trim($this->data['TYueki']['kaiinnm']);
		$twoStringValue = preg_replace('/\s{2,}/', '　', $twoStringValue);
		$twoStringValue = explode('　', $twoStringValue);
		if (sizeof($twoStringValue) == 2) {
			return true;
		} else {
			return false;
		}
	}
}
?>