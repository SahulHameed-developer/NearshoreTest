<?php
App::uses('AppModel', 'Model');
/**
 * ファイル情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TFile extends AppModel {
	public $name = 'TFile';
	public $components = array('Session', 'Common');
	// 更新日付がNULLの場合は、登録日付
	// public $virtualFields = array(
	// 		'kousinTourokudt' => 'IF(TFile.kousindt = "0000-00-00 00:00:00" OR TFile.kousindt IS NULL, TFile.tourokudt, TFile.kousindt) '
	// );
		// バリデーション
	public $validate = array(
		'rno' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "カテゴリーを選択してください。"
 				)
		),
		'title' => array(
				'maxLength' => array(
						'rule' => array('maxLength', 60),
						'message' => '最大文字数を超えています。'
				)
		),
		'filepath' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "ファイルを選択してください。"
 				)
		),
		'hyojino' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "表示順を入力してください。"
					)
		)
	);
	function numbersOnly() {
		$hyojino = trim($this->data['MDlcate']['hyojino']);
		return preg_match('/^[0-9]*$/',$hyojino);
	}
}
?>