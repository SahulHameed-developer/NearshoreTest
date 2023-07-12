<?php
/**
 *
 * @projectName:
 * @ModuleName:
 * @author:
 * @createDate:     
 * @version:   
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 */
App::uses('Helper', 'View');

class ConstantsHelper extends Helper {
	
	// Homeページ コントローラ名
	public $TOP_CTL = 'top';
		
	// ABOUT コントローラ名
	public $ABOUT_CTL = 'about';

	// PUBLICAION コントローラ名
	public $PUBLICAION_CTL = 'publication';

	// MEMBER コントローラ名
	public $MEMBER_CTL = 'member';

	// CONTACT コントローラ名
	public $CONTACT_CTL = 'contact';

	// INDEXは、CONTACTコントローラのアクション名
	public $INDEX_ACT = 'index';

	// CONFIRMは、CONTACTコントローラのアクション名
	public $CONFIRM_ACT = 'confirm';
	
	// FINISHは、CONTACTコントローラのアクション名
	public $FINISH_ACT = 'finish';

	// INDEXは、CONTACTコントローラのアクション名
	public $INDEX2_ACT = 'index2';

	// CONFIRMは、CONTACTコントローラのアクション名
	public $CONFIRM2_ACT = 'confirm2';
	
	// FINISHは、CONTACTコントローラのアクション名
	public $FINISH2_ACT = 'finish2';

}