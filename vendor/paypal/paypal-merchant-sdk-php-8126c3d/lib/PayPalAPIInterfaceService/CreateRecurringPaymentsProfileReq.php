<?php 
/**
 * 
 */
class CreateRecurringPaymentsProfileReq  
   extends PPXmlMessage{

	/**
	 * 
	 * @access public
	 
	 * @namespace ns
	 
	 	 	 	 
	 * @var CreateRecurringPaymentsProfileRequestType 	 
	 */ 
	public $CreateRecurringPaymentsProfileRequest;


	public function toXMLString()
	{
		    $str = '';
			$str .= '<ns:CreateRecurringPaymentsProfileReq>';
			if($this->CreateRecurringPaymentsProfileRequest != NULL)
			{
		   		$str .= '<ns:CreateRecurringPaymentsProfileRequest>';
				$str .= $this->CreateRecurringPaymentsProfileRequest->toXMLString();
				$str .= '</ns:CreateRecurringPaymentsProfileRequest>';
			}
			$str .= '</ns:CreateRecurringPaymentsProfileReq>';
			return $str;
	}
  
 
}
