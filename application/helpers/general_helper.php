<?php 




function guid()
{
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s%s', str_split(bin2hex($data), 4));
}
function convert_curr($to,$from=null)
{
    if(!$from)
        $from = "USD";

	$url = "https://min-api.cryptocompare.com/data/price?fsym=".$from."&tsyms=".$to."&extraParams=DeDevelopers";

	//  Initiate curl
	$ch = curl_init();
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);




	// Will dump a beauty json :3
	return $result;
	// json_decode($result, true);
}
function is_confirmed($ntwrk,$tid)
{
	$url = "https://chain.so/api/v2/is_tx_confirmed/".$ntwrk."/".$tid;
	// echo $url;exit;
	//  Initiate curl
	$ch = curl_init();
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);




	// Will dump a beauty json :3
	return $result;
}

function is_confirmed_eth($tid)
{
	$url = "https://api.etherscan.io/api?module=transaction&action=getstatus&txhash=".$tid."&apikey=3FU59IZ51YJWTEEVW94T76N8P8AEG6ERRH";
	// echo $url;exit;
	//  Initiate curl
	$ch = curl_init();
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);




	// Will dump a beauty json :3
	return $result;
}
function get_my_tokens($id)
{
	$ti = &get_instance();


    $user_balance = $ti->db->where('uID',$id)->get('dev_web_user')->result_object()[0];
    return $user_balance->tokens;


	$trans = $ti->db->where('uID',$id)->where('status',2)->get('dev_web_transactions')->result_object();
	$tokens=0;
	foreach($trans as $tran)
	{
		$tokens +=$tran->tokens;
	}

		$tokens_ = $ti->db->where('uID',$id)->get('dev_web_user')->result_object()[0]->tokens;



 

	return $tokens;


}
function get_terms_div($term="")
{

	$div_1 ='<div class="statement">
                        <div class="form-group">
                            <label>Statement</label>
                            <textarea class="form-control" name="statement[]">';

                            $div_2 = '</textarea>
                        </div>

                        <div class="kut">
                            <button onclick="removeTerm(this)" type="button" class="btn btn-xs btn-danger">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>';



	
		
		return $div_1.$term.$div_2;

	

}
function eas_creation__(){
    foreach($_SESSION['attachments_of_camp'] as $one_file) {
    	$one_file = explode('|',$one_file)[0];

        if(in_array(explode('.',$one_file)[count(explode('.',$one_file))-1],array('doc','DOCX','docx','DOC','pdf','PDF','rtf','RTF'))){


            $str.= '<div class="col-md-2 nopad c-file" style="float:left; margin:5px;"><img src="' . base_url() . 'resources/frontend/images/doc_small.png" style="width:100%">
 						</div>
							';

        }
        else {
            $str.= '<div class="col-md-2 nopad c-file" style="float:left; margin:5px;"><img src="' . base_url() . 'resources/uploads/campaigns/' . $one_file . '" style="width:100%">
            
</div>
							';



        }





    }

    echo $str;
}
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
function get_square_vars($c){
	$return = FALSE;
	$left_str = $c;

	for($i=1; $i<=substr_count($c,'['); $i++)
	{
		$return_ = explode(']',explode('[',$left_str)[1])[0];
		$left_str = str_replace('['.$return_.']','',$left_str);
		$return .= '['.$return_.']';

		if($i!=substr_count($c,'[')){
			if($i!=substr_count($c,'[')-1)
				$return .= ', ';
			else
				$return .= ' and ';

		}
	}
	return $return;
	// return $return;

}
function selfie_doc($required=0)
{
	$var = '<div style="float:left; width:100%; padding-top:10px; padding-bottom:10px; ">
                                            <input name="inputfile[]" type="file" accept="application/pdf, image/*" class="form-control inputfile"  value="" data-name="selfie"
                                            ';

    if($required==1) $var .= " required ";
    $var .='
                                            >
                                            <label class="msg"></label>
                                            <img data-id="selfie" src="" class="display_none">

            </div>
                                       ';

    $x = ' <i onclick="javascript:removeBill(this)" class="btn btn-danger btn-xs fa fa-times" style="position:absolute; top:5; right:5; "></i>';


    return $var;
}
function any_type_doc($required=0)
{
    $var = '<div style="float:left; width:100%; padding-top:10px; padding-bottom:10px; ">
                                            <input name="inputfile[]" type="file" accept="application/pdf, image/*" class="form-control inputfile"  value="" data-name="kyc_any_doc"
                                            ';

    if($required==1) $var .= " required ";
    $var .='
                                            >
                                            <label class="msg"></label>
                                            <img data-id="selfie" src="" class="display_none">

            </div>
                                       ';

    $x = ' <i onclick="javascript:removeBill(this)" class="btn btn-danger btn-xs fa fa-times" style="position:absolute; top:5; right:5; "></i>';


    return $var;
}
function bill_doc($required=0)
{
	$var = ' <div style="float:left; width:100%;  padding-bottom:10px; padding-top:10px; ">
                                            <input name="inputfile[]" type="file" accept="application/pdf, image/*" class="form-control inputfile"  value="" data-name="bill"
                                            ';

    if($required==1) $var .= " required ";
    $var .='
                                            >
                                            <label class="msg"></label>
                                            <img data-id="bill" src="" class="display_none">
           
            </div>
                                       ';

    return $var;
}
function custom_number_format($n, $precision = 3) {
    if(!$n || $n==0 || $n=="" || $n=="nan" || $n=="NAN") return 0;
    if( $n < 1000)
    {
        $n_format = number_format($n);
    }
    else if ($n < 1000000) {
        // Anything less than a million
        $n_format = number_format($n / 1000, $precision) . 'K';
    } else if ($n < 1000000000) {
        // Anything less than a billion
        $n_format = number_format($n / 1000000, $precision) . 'M';
    } else {
        // At least a billion
        $n_format = number_format($n / 1000000000, $precision) . 'B';
    }

    return $n_format;
}
function nice_img_view($title='Document',$img='defualt_popup.png',$link='')
{
	$var = '<div class="col-md-4 col-lg-3 col-sm-6 col-xs-12">
            <div class="imgbox">
                <div class="imgbox_ im">
                    <a href="'.$link.'" target="_blank">
                        <img src="'.$img.'" class="">
                    </a>
                </div>
                <div class="imgbox_ bdy">
                    <div class="imgbox_ bdy_ txt">
                        '.$title.'
                    </div>
                    <div class="imgbox_ bdy_ btns">
                        <a class="btn btn-default left imgbox_ bdy_ btns_ btn_view_bx " href="'.$link.'" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-primary right imgbox_ bdy_ btns_ btn_download_bx " download href="'.$link.'">
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>';
    return $var;
}
function get_extension($string)
{
    return explode('.',$string)[count(explode('.',$string))-1];
}
function strpos_recursive($haystack, $needle, $offset = 0, &$results = array()) {                
    $offset = strpos($haystack, $needle, $offset);
    if($offset === false) {
        return $results;            
    } else {
        $results[] = $offset;
        return strpos_recursive($haystack, $needle, ($offset + 1), $results);
    }
}

function check_roles($req)
{

    $roles = $_SESSION['RolesSession']['roles'];
    if(in_array('-1', $roles) || in_array($req, $roles))
        return true;
    redirect(base_url().'admin/logout');
    exit;
}
function role_exists($req)
{

    $roles = $_SESSION['RolesSession']['roles'];
    if(in_array('-1', $roles) || in_array($req, $roles))
        return true;
    return false;
}
function get_kyc_token()
{
    $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://pluginst.identitymind.com/sandbox/auth",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "x-api-key: hICtErxc6G0SS4druDbj8i0vH4ePJgq10lYExkT1"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return false;
        } else {
          return json_decode($response)->token;

        }
}
function am_i($name){
        ////////////////
    // if($name=="lib")
    // {
    //     return true;
    // }
        ////////////////


    if($name=="securix" && base_url()=="https://dashboard.securix.io/")
        return true;
    if($name=="scia" && base_url()=="https://ico.scia.io/")
        return true;
    if($name=="dnatix" && base_url()=="https://tokensale.dnatix.com/"){

        $dna_tx = &get_instance();
        $allowed = $dna_tx->db->get('dev_web_config')->result_object()[0]->dnatix_allowed;

        if($allowed==1)
        return true;
    }
    if($name=="gbmstech" && (base_url()=="https://ico.gbmstech.io/" || base_url()=="http://ico.gbmstech.io/"))
    {
        return true;
    }
    if($name=="demo" && base_url()=="https://demo.icodashboard.io/")
    {
        return true;
    }
    if($name=="lib" && base_url()=="https://ico.libereum.io/")
    {
        return true;
    }
    if($name=="hydro" && (base_url()=="http://ico.hydrotank.io/" || base_url()=="https://ico.hydrotank.io/"))
    {
        return true;
    }
    if($name=="areplatform" && (base_url()=="https://dashboard.areplatform.com/" || base_url()=="http://dashboard.areplatform.com/"))
    {
        return true;
    }
    if($name=="tib" && (base_url()=="https://ims.tiberiuscoin.com/" || base_url()=="http://ims.tiberiuscoin.com/"))
    {
        return true;
    }
    if($name=="yanu" && (base_url()=="https://my.yanu.ai/" || base_url()=="http://my.yanu.ai/"))
    {
        return true;
    }
    return false;
}
function get_bonus($id,$dig=false)
{
    $ti = &get_instance();
    $token = $ti->db->where('tkID',$id)->get('dev_web_token_pricing')->result_object()[0];
    if($dig)
    {
        $str = "[";
        $bonuses = $ti->db->where('token_id',$id)->get('dev_web_bonuses')->result_object();
        if(empty($bonuses)) return $token->tokenBonus;



        foreach($bonuses as $key=>$bonus)
        {
            $str.="[";
            $str .= number_format($bonus->more_than,2);
                $str.=",";
            $str .= number_format($bonus->less_than,2);
                $str.=",";            
            $str .= number_format($bonus->bonus,2);
            $str.="]";

            if($key!=count($bonuses)-1)
                $str.=",";

        }
        $str .= "]";
        return $str;
    }
    else{
        return $token->tokenBonus;
    }
}
function get_calculated_bonus($id,$amount,$dig)
{
    $ti = &get_instance();
    $token = $ti->db->where('tkID',$id)->get('dev_web_token_pricing')->result_object()[0];
    if($dig)
    {
        $str = "[";
        $bonuses = $ti->db->where('token_id',$id)
        ->where('more_than <=',$amount)
        ->where('less_than >=',$amount)
        ->get('dev_web_bonuses')->result_object();
        if(empty($bonuses)) return $token->tokenBonus;



        
        return $bonuses[0]->bonus;
    }
    else{
        return $token->tokenBonus;
    }
}
function next_camp($id)
{
    $ti = &get_instance();
    $count = $ti->db->count_all_results('dev_web_ico_settings');

    for($i=1; $i<=$count; $i++)
    {
        $camp = $ti->db->where('id !=',$id)->where('tokens_sold < tokens_for_sale')->get('dev_web_ico_settings');
        return $camp->result_object()[0];
    }
    return false;

}
function next_token($id)
{
    $ti = &get_instance();
    
    $token = $ti->db->where('prev_token',$id)->get('dev_web_token_pricing');
    return $token->result_object()[0];
    
    return false;

}
function add_level($v="")
{
    $x = '<div class="level" style="position: relative; width: 30%; clear: both;float: left;" >
                                    <input type="number" required name="level[]" style="margin-bottom: 10px;" class="form-control" value="'.$v.'">
                                    <button style="position: absolute; top: 5px; right: 5px;     padding: 4px;" onclick="remove_level(this)" type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
                                </div>';

    echo $x;
}
function calculate_price_should_be($templ)
{

     $converting  = convert_curr("USD",$templ->currency_type);

    $converting = json_decode($converting,true);
                    foreach($converting as $cc)
                        $converting = $cc;

        // return $templ->tokenPrice;


    return $converting * $templ->tokenPrice;


}

function print_leve($data)
{
    $ti = &get_instance();
    echo $ti->load->view('frontend/common/bonus_level_div',$data);
}
function decimals_()
{

    if(isset($_SESSION['DECIMALS__']))
        return $_SESSION['DECIMALS__'];
    return 3;
}
function all_langs()
{
    $str = "Afrikaans:af;Arabic:ar;Bashkir:ba;Bulgarian:bg;Bosnian:bs;Corsican:co;Welsh:cy;German:de;English:en;Spanish:es;Basque:eu;Finnish:fi;Filipino:fl;Western Frisian:fy;Scottish Gaelic:gd;Gujarati:gu;Hebrew:he;Croatian:hr;Hungarian:hu;Armenian:hy;Igbo:ig;Italian:it;Javanese:jv;Kazakh:kk;Kannada:kn;Kurdish:ku;Latin:la;Lao:lo;Latvian:lv;Māori:mi;Malayalam:ml;Marathi:mr;Maltese:mt;Nepali:ne;Norwegian:no;Punjabi:pa;Pashto:ps;Romanian:ro;Sindhi:sd;Slovak:sk;Samoan:sm;Somali:so;Serbian:sr;Sundanese:su;Swahili:sw;Telugu:te;Thai:th;Tongan:to;Tatar:tt;Tahitian:ty;Urdu:ur;Vietnamese:vi;Yiddish:yi;Simplified Chinese:zh;Amharic:am;Azerbaijani:az;Belarusian:be;Bengali:bn;Catalan:ca;Czech:cs;Danish:da;Greek:el;Esperanto:eo;Estonian:et;Persian:fa;Fijian:fj;French:fr;Irish:ga;Galician:gl;Hausa:ha;Hindi:hi;Haitian:ht;Hawaiian:hw;Indonesian:id;Icelandic:is;Japanese:ja;Georgian:ka;Central Khmer:km;Korean:ko;Kyrgyz:ky;Luxembourgish:lb;Lithuanian:lt;Malagasy:mg;Macedonian:mk;Mongolian:mn;Malay:ms;Burmese:my;Dutch:nl;Chichewa:ny;Polish:pl;Portuguese:pt;Russian:ru;Sinhalese:si;Slovenian:sl;Shona:sn;Albanian:sq;Southern Sotho:st;Swedish:sv;Tamil:ta;Tajik:tg;Tagalog:tl;Turkish:tr;Traditional Chinese:tw;Ukrainian:uk;Uzbek:uz;Xhosa:xh;Yoruba:yo;Zulu:zu;";


    $arr = explode(';',$str);

    unset($arr[count($arr)-1]);

   



    foreach($arr as $ar)
    {
        $langs[] = array('name'=>explode(':',$ar)[0], 'short_name'=>explode(':',$ar)[1]);
    }

      

    return $langs;
}
function get_question_kcy($q)
{

    $current_lang = $_SESSION['kyc_lang']?$_SESSION['kyc_lang']:'en';

    $ti = &get_instance();
    $question = $ti->db->where('lang',$current_lang)->where('unique_id',$q)->get('dev_web_kyc_qs_tib')->result_object();

    if(empty($question))
    {
        $question = $ti->db->where('lang','en')->where('unique_id',$q)->get('dev_web_kyc_qs_tib')->result_object();
    }

    if(empty($question))
        return "QUESTION NOT ADDED";
    else 
        $question = $question[0];

    return $question->qs;
}
function get_lang_msg($msg,$lang="en")
{
    if($lang=="" || $lang=="en")
        $lang=$_SESSION['kyc_lang'];
    if($lang=="")
        $lang="en";

    if($lang=="en")
    {
        return english_words($msg);
    }
    elseif($lang=="es")
    {
        return es_words($msg);
    }
    elseif($lang=="tr")
    {
        return tr_words($msg);
    }

}
function english_words($words)
{
    switch ($words) {
        case 'kyc_verification':
            return "KYC Verification";
            break;
        case 'i_agree':
            return "I Agree";
            break;
        case 'i_disagree':
            return "I Disagree";
            break;
        case 'confirm':
            return "Confirm";
            break;
        case 'cancel':
            return "Cancel";
            break;
        case 'step_1_text':
            return "I am not a US citizen, nor am I a resident of the USA, nor am I a US Green Card Holder. I understand, and I am aware that no US citizen, US resident, or US Green Card Holder may be an owner or holder of a Tiberius Coin and Tiberius Technology Ventures reserves the right to terminate any Tiberius Coin that it finds is in the possession of a US citizen, US resident, or US Green Card holder.  <br> <br>

I am not a citizen or resident (tax or otherwise) of Kyrgyzstan, Morocco, Nepal, Bangladesh, Algeria or a resident or a citizen of any other country in which Token Generating Events, Initial Coin Offerings or similar transactions and events are banned. The Buyer is also not affected by sanctions issued by the USA, such as sanctions related to Belarus, Burundi, Central African Republic, Cuba, Democratic Republic of Congo, Iran, Iraq, Lebanon, Libya, North Korea, Somalia, Sudan, South Sudan, Syria, Ukraine/Russia, Venezuela, Yemen, and Zimbabwe.";
            break;
        case 'first_name':
            return "First Name";
            break;
        case 'last_name':
            return "Last Name";
            break;
        case "enter_your":
            return "Enter your";
            break;
        case "email_address":
            return "Email Address";
            break;
        case "step_3_heading":
            return "Please upload your NATIONAL ID or PASSPORT or DRIVER’S LICENSE or other government issued identification";
            break;
        case "address_proof_string":
            return "Proof of your address e.g Utility Bills or Driving Licence ";
            break;
        case "vf_email_msg":
            return "Please verify your email address by entering code we sent you in email or by clicking link in email address";
            break;


        
        default:
            return ucfirst(str_replace('_',' ',$words));
            
            break;
    }
}
function es_words($words)
{
    switch ($words) {
        case 'kyc_verification':
            return "Verificación KYC";
            break;
        case 'i_agree':
            return "Estoy de acuerdo";
            break;
        case 'i_disagree':
            return "Estoy en desacuerdo";
            break;
        case 'confirm':
            return "Confirmar";
            break;
        case 'cancel':
            return "Cancelar";
            break;
        case 'step_1_text':
            return "No soy ciudadano de los EE. UU., Ni soy residente de los EE. UU., Ni soy titular de la tarjeta verde de EE. UU. Entiendo, y soy consciente de que ningún ciudadano de los EE. UU., Residente de los EE. UU. O titular de la tarjeta verde de los EE. UU. Puede ser propietario o titular de una Tiberius Coin y Tiberius Technology Ventures se reserva el derecho de rescindir cualquier Tiberius Coin que considere que está en posesión de ciudadano de los EE. UU., residente de los EE. UU. o titular de la tarjeta verde de EE. UU. <br> <br> 
No soy un ciudadano o residente (impuesto o de otro tipo) de Kirguistán, Marruecos, Nepal, Bangladesh, Argelia o un residente o ciudadano de cualquier otro país en el que se produzcan eventos de generación de fichas, ofertas iniciales de monedas o transacciones similares y los eventos están prohibidos. El comprador tampoco está afectado por las sanciones emitidas por los EE. UU., Como las sanciones relacionadas con Bielorrusia, Burundi, República Centroafricana, Cuba, República Democrática del Congo, Irán, Iraq, Líbano, Libia, Corea del Norte, Somalia, Sudán, Sudán del Sur , Siria, Ucrania / Rusia, Venezuela, Yemen y Zimbabwe.";
            break;
        case 'first_name':
            return "Nombre";
            break;
        case 'last_name':
            return "Apellido";
            break;
        case "enter_your":
            return "Entra tu";
            break;
        case "email_address":
            return "correo electrónico";
            break;
        case "step_3_heading":
            return "Cargue su identificación nacional o PASAPORTE o LICENCIA DE CONDUCTOR o otra identificación emitida por el gobierno";
            break;
        case "address_proof_string":
            return "Prueba de su dirección, por ejemplo, facturas de servicios públicos o licencia de conducir ";
            break;
        case "vf_email_msg":
            return "Verifique su dirección de correo electrónico ingresando el código que le enviamos por correo electrónico o haciendo clic en el enlace en la dirección de correo electrónico";
            break;
        case "date_of_birth":
            return "Fecha de nacimiento";
            break;
        case "residential_address":
            return "Dirección residencial";
            break;
        case "country_of_residence":
            return "País de residencia";
            break;
        case "nationality":
            return "Nacionalidad";
            break;
        case "profession":
            return "Profesión";
            break;
        case "city":
            return "Ciudad";
            break;
        case "state":
            return "Estado";
            break;
        case "zip_code":
            return "Código postal";
            break;
        case "street":
            return "Calle";
            break;
        case "apartment":
            return "Apartamento";
            break;
        case "enter_code":
            return "Introduzca el código";
            break;




        
        default:
            return ucfirst(str_replace('_',' ',$words));
            
            break;
    }
}
function tr_words($words)
{
    switch ($words) {
        case 'kyc_verification':
            return "KYC Doğrulama";
            break;
        case 'i_agree':
            return "Katılıyorum";
            break;
        case 'i_disagree':
            return "Katılmıyorum";
            break;
        case 'confirm':
            return "Onaylamak";
            break;
        case 'cancel':
            return "İptal etmek";
            break;
        case 'step_1_text':
            return "Ben bir ABD vatandaşı ve ABD mukimi değilim, ne de ABD Yeşil Kart sahibiyim. Hiçbir ABD vatandaşının, ABD'de ikamet edenlerin veya ABD Yeşil Kart sahiplerinin Tiberius Coin sahibi veya hamili olamayacağını ve Tiberius Technology Ventures'ın herhangi bir ABD vatandaşı, mukimi veya ABD Yeşil Kart sahibinin elinde Tiberius Coin bulunduğunu tespit etmesi halinde feshetme hakkını saklı tuttuğunu anlıyorum ve bunun bilincindeyim.  <br> <br>

Kırgızistan, Ekvator, İzlanda, Fas, Nepal, Bolivya, Bangladeş, Cezayir veya Token Oluşturma Etkinliklerinin, dijital para arzı (Initial Coin Offering) veya benzeri etkinliklerin ve işlemlerin yasaklandığı ülkelerin vatandaşı veya mukimi değilim. Alıcı ayrıca ABD tarafından verilen yaptırımlardan etkilenmemektedir; örneğin Beyaz Rusya, Burundi, Orta Afrika Cumhuriyeti, Küba, Kongo Demokratik Cumhuriyeti, İran, Irak, Lübnan, Libya, Kuzey Kore, Somali, Sudan, Güney Sudan, Suriye, Ukrayna / Rusya, Venezuela, Yemen ve Zimbabve ile ilgili olmak.";
            break;
        case 'first_name':
            return "İsim";
            break;
        case 'last_name':
            return "Soyadı";
            break;
        case "enter_your":
            return "Girin";
            break;
        case "email_address":
            return "e-mail adresi";
            break;
        case "step_3_heading":
            return "Lütfen KİMLİĞİNİZİ veya PASSPORT veya SÜRÜCÜ EHLİYETİNİZİ veya diğer resmi kimliklerinizi yükleyiniz.";
            break;
        case "address_proof_string":
            return "Proof of your address e.g Utility Bills or Driving Licence ";
            break;
        case "vf_email_msg":
            return "Please verify your email address by entering code we sent you in email or by clicking link in email address";
            break;
        case "date_of_birth":
            return "Doğum Tarihi";
            break;
        case 'residential_address':
            return 'İkamet adresi';
            # code...
            break;
        case 'country_of_residence':
            # code...
            return "İkamet ettiğiniz ülke";
            break;
        case "nationality":
            return "Uyruk";
            break;
        case "profession":
            return "Meslek";
            break;
        case "city":
            return "Kent";
            break;
        case "state":
            return "Belirtmek, bildirmek";
            break;
        case "zip_code":
            return "Posta kodu";
            break;
        case "street":
            return "sokak";
            break;
        case "apartment":
            return "Apartman";
            break;
        case "enter_code":
            return "Kodu girin";
            break;

        // case ''

        
        default:
            return ucfirst(str_replace('_',' ',$words));
            break;
    }
}

