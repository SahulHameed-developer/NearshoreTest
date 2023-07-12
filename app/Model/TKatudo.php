<?php
App::uses('AppModel', 'Model');
/**
 * 活動情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TKatudo extends AppModel {
	public $name = 'TKatudo';
	public $primaryKey = 'arno';
	public $components = array('Session', 'Common');
	// バリデーション
	public $validate = array(
			'sosikicd' => array('rule' => array('notBlank'),
					'message' => "組織を選択してください。"
			),
			'kbunruicd' => array('rule' => array('notBlank'),
					'message' => "活動分類を選択してください。"
			),
			'kaisaidate' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "日付を入力してください。"
					),
					'date' => array(
							'rule' => 'date',
							'message' => "日付が不正な形式です。"
					)
			),
			'kaisaitmfrom' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "開始時間が未入力です。"
 					)
			),
			'kaisaitmto' =>array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "終了時間が未入力です。"
					)
			),
			'hyoudai' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "表題を入力してください。"
					)
			),
			'meisyou' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "名称を入力してください。"
					)
			),
			'teiin' => array(
					'maxLength' => array(
							'rule' => array('range', -32769, 32768),
							'message' => '最大文字数を超えています。',
							'allowEmpty' => true
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
			)			
	);
}