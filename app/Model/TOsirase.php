<?php
App::uses('AppModel', 'Model');
/**
 * お知らせ情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TOsirase extends AppModel {
	public $name = 'TOsirase';
	public $primaryKey = 'arno';
	public $components = array('Session', 'Common');
	// 更新日付がNULLの場合は、登録日付
	public $virtualFields = array(
			'kousinTourokudt' => 'IF(TOsirase.kousindt = "0000-00-00 00:00:00" OR TOsirase.kousindt IS NULL, TOsirase.tourokudt, TOsirase.kousindt) '
	);
	// バリデーション
	public $validate = array(
			'osirasedate' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "お知らせ日付を入力してください。"
					),
					'date' => array(
							'rule' => 'date',
							'message' => "日付が不正な形式です。"
					)
			),
			'osirasetime' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "お知らせ時刻を入力してください。"
 					)
			),
			'title' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "お知らせタイトルを入力してください。"
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
							'message' => "お知らせ内容を入力してください。"
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
			)
	);
}
?>