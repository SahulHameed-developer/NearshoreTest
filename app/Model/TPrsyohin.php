<?php
App::uses('AppModel', 'Model');
/**
 * 有益情報のModel
 *
 * @author MICROBIT Co.Ltd.,
 */
class TPrsyohin extends AppModel {
	public $name = 'TPrsyohin';
	public $primaryKey = 'arno';
	public $components = array('Session', 'Common');
	// 更新日付がNULLの場合は、登録日付
	public $virtualFields = array(
			'kousinTourokudt' => 'IF(TPrsyohin.kousindt = "0000-00-00 00:00:00" OR TPrsyohin.kousindt IS NULL, TPrsyohin.tourokudt, TPrsyohin.kousindt) '
	);
	public $validate = array(
			'syohinnm' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "内容を入力してください。"
					)
			),
			'syousai' => array(
					'notBlank' => array(
							'rule' => 'notBlank',
							'required' => true,
							'message' => "内容を入力してください。"
					)
			),
			'kikanfrom' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "日付を入力してください。"
					),
					'date' => array(
							'rule' => 'date',
							'message' => "日付が不正な形式です。"
					)
			),
			'kikanto' => array(
					'notEmpty' => array(
							'rule' => array('notBlank'),
							'message' => "日付を入力してください。"
					),
					'date' => array(
							'rule' => 'date',
							'message' => "日付が不正な形式です。"
					)
			)
	);
	
}
?>