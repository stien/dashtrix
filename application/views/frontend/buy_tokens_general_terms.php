<?php include("common/header.php");


$selected_amount_price = "<b>".$crypto_required.' '. $option->c_name."</b>";


$_SESSION['buy_step_1']['option'] = $_SESSION['buy_tokens_tib']['step_2']['currency'];

$_SESSION['buy_step_2']['amount'] = $_SESSION['buy_tokens_tib']['step_2']['amount_of_tokens'];


$vf = $this->db->where('uID',UID)->get('dev_web_user_verification')->result_object()[0];

$name = "<b>".$vf->uFname. ' '.$vf->uLname."</b>";
$address = "<b>".$vf->uAddress."</b>";

?>

<div class="wrapper-page widht-800" style=" margin-bottom: 100px;">

   <h2><?php echo get_lang_msg("kyc_verification"); ?></h2>

                   

<form method="POST" action="" accept-charset="UTF-8" id="personal-info">
<?php require 'common/change_lang_kyc_tib.php'; ?>

 <div class="card-box">


 <?php if(isset($_SESSION['thankyou'])){?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="successfull">
                                <?php echo $_SESSION['thankyou'];?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if(isset($_SESSION['error'])){?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="wrongerror">
                                <?php echo $_SESSION['error'];?>
                            </div>
                        </div>
                    </div>
                <?php } ?>


        <div class="panel-body">

            <div class="row">

                <div class="col-lg-12" style="max-height: 350px; overflow-y: scroll;">

                     <?php

                                        if($_SESSION['kyc_lang']=="en" || $_SESSION['kyc_lang']=="")
                                           {



                                        ?>



SUBSCRIPTION AGREEMENT FOR A BASKET OF METALS AND THE SUBSEQUENT ISSUANCE OF TOKENS AS MEANS OF IDENTIFICATION

<br>

    THIS Subscription Agreement for a basket of metals (“Basket”) and the subsequent issuance of tokes as means of identification (this “Agreement”) is made as of <b><?php echo date("m-d-Y"); ?></b>, by and between
<br>

TIBERIUS TECHNOLOGY VENTURES AG, a company organized under the laws of Switzerland with its registered office at Dorfstrasse 13, 6340 Baar (the “Seller”, “TTV”, “Custodian”) and <?php echo $name; ?> (the “Buyer” or “Assignor”) registered under the address <?php echo $address; ?>.
<br>

(each a “Party” and collectively the “Parties”).
<br>

The Agreement consists of the three sub-agreements (“Sub-Agreements”):
<br>

•   Subscription Agreement for a basket of metals and the subsequent issuance of tokens as means of identification<br>
•   Custody Agreement<br>
•   Instruction to hold possession on behalf of the Buyer or any affiliate<br>

The Agreement contains also an explicit instruction addressed to TTV to subscribe the Basket on behalf of the Buyer which is subsequently assigned to the Buyer and request the issuance of Tiberius Coins (“T-Coin”) as means of identification. 
<br>

WHEREAS<br>

WHEREAS, TTV is planning to sell a basket of different base and precious metals to Buyer (“Basket”);
WHEREAS, any asset that is not a currency with respect to being legal tender, such as the Basket and all cryptocurrencies, is not considered a currency (“Risk Asset”);<br>
WHEREAS, the funds or accepted Risk Assets paid by the Buyer to TTV as part of the Subscription of the Basket will be under the control of TTV (“Subscription Funds”);<br>
WHEREAS, TTV reserves the right to fully, partially, or not at all honor the Subscription of  the Buyer (“Unfulfilled Subscription”);<br>
WHEREAS, unused Subscription Funds will be returned to the Buyer in the case of an Unfulfilled Subscription (“Unused Subscription Funds”);<br>
WHEREAS, TTV may trade any Risk Asset on behalf of the Buyer when attempting to buy the Basket as part of the Subscription but later sell all or part of the Basket or any other asset proceeding from the Subscription Funds as part of an Unfulfilled Subscription at the discretion of TTV (“Closed-Out Basket/Assets”);<br>
WHEREAS, any costs, trading losses, or opportunity costs incurred by TTV in either buying the Basket for a Subscription or a Closed-Out Basket/Assets relating to an Unfulfilled Subscription will be paid by the Buyer before any Unused Subscription Funds are returned to the Buyer (“Trading Costs”);
WHEREAS, Trading Costs encompass all cost, opportunity costs, and trading losses incurred when TTV trades Subscription Funds or any Risk Asset or currency proceeding from the Subscription Funds;
WHEREAS, TTV will publicly publish the prices of cryptocurrencies traded that will be passed onto the Buyer which will be near the market rate less Trading Costs;<br>
WHEREAS, the Buyer instructs TTV to place the Basket in a bonded warehouse of its choice (“Warehouse”) and the Warehouse issues warehouse certificates in the form of order papers endorsed in blank (“Warehouse Certificate”);<br>
WHEREAS, the Warehouse Certificates shall be replaced by a global certificate (“Global Certificate”) and the Warehouse Certificates and Global Certificate shall be held by TTV or a party appointed by TTV in custody;<br>
WHEREAS, the Buyer shall have joint ownership in the Global Certificate according to the ratio between the total amount of metal represented by the Warehouse Certificates in aggregate and the individual amount of metal represented by the Warehouse Certificates belonging to the Buyer;<br>
WHEREAS, TTV and the Buyer agree that TTV shall hold the Global Certificate in possession on behalf of the Buyer or any third party to whom the Buyer will transfer its joint-ownership (Miteigentum) in the Global Certificate;<br>
WHEREAS, TTV, in its capacity as the seller of the Basket and the issuer of the token shall issue T-Coins providing the Buyer identification to the Basket whereby such tokens shall be generated at the end of the Initial Metals Sale (“IMS”) taking place until the end of 2018 or earlier and subsequently thereafter;<br>
WHEREAS, TTV has issued a White Paper dated as of the date hereof and made available to the Buyer explaining the sale of the Basket and the function and the purpose of the T-Coins (“White Paper”);<br>
WHEREAS, on the Effective Date of this Agreement the Seller undertakes to sell to the Buyer, and the Buyer undertakes to purchase from the Seller the Basket and the Seller subsequently issues non-transferrable claims for the delivery of the T-Coins upon the terms and conditions set forth in this Agreement;<br>
WHEREAS, the Buyer explicitly instructs TTV to subscribe for the Basket on behalf of the Buyer in the Seller’s own name and then to assign the T-Coins to the Buyer;<br>
WHEREAS, the transfer of the future T-Coins shall be effected after the IMS has successfully taken place subject to the terms and conditions set forth in this Agreement;<br>
NOW, THEREFORE in consideration of the mutual covenants and undertakings contained herein, and subject to the terms and conditions set forth herein, and with the intent to be bound, the Parties agree as follows:
<br>
AGREEMENT<br>


Purchase Price. The Price per Basket is determined in the case of base and precious metals at the Fixing at the end of the IMS event. <br>
Base Metals: The Purchase Price is then calculated based on the market price of the metals represented in the Basket derived from the cash or three Month Official prices* at the London Metal Exchange at [1-2 p.m. CET] on the day TTV procures the Basket over the course of the IMS event plus the physical premium as determined by the market and a mark-up of 4.5% (if this Subscription Agreement was signed of before TTV sold 10million CHF worth of token) and 9% (afterwards) (“fixing”).*) For the cash or the Three Month prices please refer to www.lme.com. In case there is no liquidity the fill price received in the course of procuring the metal will be used.<br>
Precious Metals: The Purchase Price is then calculated based on the market price of the metals represented in the Basket derived from the daily afternoon fixing price published by the London Bullion Market Association on the day TTV procures the Basket over the course of the IMS event plus the physical premium as determined by the market and a mark-up of 4.5% (if this Subscription Agreement was signed of before TTV sold 10million CHF worth of token) and 9% (afterwards) (“fixing”).<br>
Subscription. The Buyer subscribes for <?php echo $selected_amount_price; ?> and the Seller sells the aforementioned number of Baskets subject to the fixing and issues T-Coins to the Buyer as determined according to the Terms and Conditions of the Agreement. <br>
    IN WITNESS HEREOF, the Parties hereto have caused this Agreement to be duly executed as of the day and year below written. The Parties agree and confirm by executing this Agreement explicitly that:<br>
•   They have read and understand the terms and conditions of this Agreement (including General Terms and Conditions and Risk Disclosure);<br>
•   They have received sufficient information about the metals which form the Basket and the function of the T-Coin to make an informed decision;<br>
•   They have read and understand the content of the White Paper in the context of the sale of metals and the subsequent issuance of the T-Coin tokens.<br>

SIGNATURE PAGE TO FOLLOW<br>


<br>

<div class="col-md-12 nopad">
<div class="col-md-6 nopad">                               
The Buyer/Signature <br>
[……………….]     
</div>                     
<div class="col-md-6 nopad">   
<span class="pull-right">                          
Date/Place
     </span>  
</div>
</div>

<br>                
<br>                
<br> 

<div class="col-md-12 nopad">
<div class="col-md-6 nopad">                               
The Seller/Signature <br>
[……………….]     
</div>     

<div class="col-md-6 nopad">  
 <span class="pull-right">                          
Date/Place
     </span>  
</div>
</div>



                                        <?php

                                            }elseif($_SESSION['kyc_lang']=="es"){
                                        ?>


CONTRATO DE SUSCRIPCIÓN PARA UNA CANASTA DE METALES Y LA EMISIÓN SUBSECUENTE DE FICHAS COMO MEDIO DE IDENTIFICACIÓN



    ESTE Contrato de suscripción para una canasta de metales (“canasta”) y la subsecuente emisión de fichas como medio de identificación (este “contrato”) se celebra a partir de <b><?php echo date("m-d-Y"); ?></b> por y entre<br>
<br>
TIBERIUS TECHNOLOGY VENTURES AG, una empresa fundada bajo las leyes de Suiza con domicilio legal en Dorfstrasse 13, 6340 Baar (el “vendedor”, “TTV”, “custodio“) Y <?php echo $name; ?> (el “comprador” o “cedente”), con domicilio registrado en <?php echo $address; ?>.<br><br>

(Cada uno de ellos una “parte” y colectivamente las “partes”).<br><br>

El contrato consiste en los tres subcontratos (“subcontratos”):<br><br>

• Contrato de suscripción para una canasta de metales y la emisión subsecuente de fichas como medio de identificación.<br>
• Acuerdo de custodia.<br>
• Indicación para conservar la posesión en representación del comprador o de cualquier asociado.<br><br>

El contrato también contiene una instrucción explícita dirigida a TTV para suscribirse a la canasta en representación del comprador que es posteriormente asignada al comprador y para solicitar la emisión de Tiberius Coins (“T-Coin”) como medio de identificación. <br><br>


CONSIDERANDO QUE<br><br>

CONSIDERANDO QUE TTV planea vender una canasta de diferente base y metales preciosos al comprador (“canasta”).<br>
CONSIDERANDO QUE cualquier activo que no sea una moneda en el sentido de ser una unidad monetaria legal, como la canasta y todas las criptomonedas, no se considera una moneda (“activos de riesgo”).<br>
CONSIDERANDO QUE los fondos o activos de riesgo aceptados pagados por el comprador a TTV como parte de la suscripción de la canasta estarán bajo el control de TTV (“fondos de suscripción”).<br>
CONSIDERANDO QUE TTV se reserva el derecho a honrar total, parcial o en absoluto la suscripción del comprador (“suscripción incumplida”).<br>
CONSIDERANDO QUE los fondos de suscripción no utilizados se devolverán al comprador en el caso de una suscripción incumplida (“fondos de suscripción no utilizados”).<br>
CONSIDERANDO QUE TTV puede negociar cualquier activo de riesgo en representación del comprador al tratar de comprar la canasta como parte de la suscripción pero más adelante vender todo o parte de la canasta o cualquier otro activo procedente de los fondos de la suscripción como parte de una suscripción incumplida a criterio de TTV (“cierre de canasta/activos”).<br>
CONSIDERANDO QUE cualquier costo, pérdida comercial o costo de oportunidad en el que haya incurrido TTV al comprar la canasta para una suscripción o un cierre de canasta/activos en relación a una suscripción incumplida serán pagados por el comprador antes de que los fondos de suscripción no utilizados se devuelvan al comprador (“costos comerciales”).<br>
CONSIDERANDO QUE los costos comerciales engloban todos los costos, costos de oportunidad y pérdidas comerciales en los que haya incurrido TTV al comerciar fondos de suscripción, cualquier activo de riesgo o moneda procedente de los fondos de suscripción.<br>
CONSIDERANDO QUE TTV dará a conocer públicamente los precios de las criptomonedas comerciadas que se transferirán al comprador, los cuales serán cercanos al valor del mercado menos los costos comerciales.
CONSIDERANDO QUE el comprador le indica a TTV colocar la canasta en un almacén de aduanas de su elección (“almacén”) y el almacén emite certificados de almacén en forma de documentación de pedidos endosada en blanco (“certificado de almacén”).<br>
CONSIDERANDO QUE los certificados de almacén serán reemplazados por un certificado global (“certificado global”) y los certificados de almacén y certificados globales permanecerán en custodia de TTV o una parte designada por TTV.<br>
CONSIDERANDO QUE el comprador tendrá la propiedad conjunta en el certificado global de acuerdo con la relación entre la cantidad total de metales representados por los certificados de almacén en su conjunto y la cantidad individual de metal representado por los certificados de almacén que pertenecen al comprador.<br>
CONSIDERANDO QUE TTV y el comprador están de acuerdo en que TTV mantenga el certificado global en su posesión en representación del comprador o de cualquier tercero a quien el comprador transfiera su propiedad conjunta (Miteigentum) en el certificado global.<br>
CONSIDERANDO QUE TTV, en su capacidad como el vendedor de la canasta y el emisor de la ficha, emitirá T-Coins proporcionando la identificación del comprador a la canasta en la cual dichas fichas serán generadas al final de la venta inicial de metales (IMS, por sus siglas en inglés) teniendo lugar hasta finales del 2018 o antes y subsecuentemente después.<br>
CONSIDERANDO QUE TTV ha emitido un libro blanco fechado a partir de la fecha presente y puesto a disposición del comprador detallando la venta de la canasta y la función y el propósito de las T-Coins (“libro blanco”).<br>
CONSIDERANDO QUE, en la fecha de vigencia de este contrato, el vendedor se compromete a venderle al comprador y el comprador se compromete a comprarle al vendedor la canasta y el vendedor subsecuentemente emite solicitudes intransferibles para la entrega de las T-Coins conforme a los términos y condiciones establecidos en este contrato.<br>
CONSIDERANDO QUE el comprador expresamente le indica a TTV suscribirse a la canasta en representación del comprador a nombre del vendedor y luego destinar las T-Coins al comprador.<br>
CONSIDERANDO QUE la transferencia de las futuras T-Coins se efectuará después de que la IMS haya tenido lugar con éxito y conforme a los términos y condiciones establecidos en este contrato.<br>
AHORA, teniendo en cuenta los acuerdos y compromisos mutuos contenidos en este documento, conforme a los términos y condiciones establecidos en este documento y con la intención de comprometerse, las partes acuerdan lo siguiente:<br><br>

ACUERDOS<br><br>


Precio de compra. El precio por canasta se determina en el caso de metales base y preciosos durante el ajuste al final del evento de IMS. <br>
Metales base: Posteriormente el precio de compra se calcula con base en el precio en el mercado de los metales que se representan en la canasta derivado del efectivo o del precio oficial de tres meses* en la Bolsa de Metales de Londres [1-2 p.m. CET] en el día que TTV adquiera la canasta en el transcurso del evento de IMS, más la prima física según lo determinado por el mercado y un incremento en el precio del 4.5% (si este contrato de suscripción se firmó antes de que TTV vendiera el equivalente a 10 millones de CHF en fichas) y del 9% (después del “ajuste”)*. Para el efectivo o el precio de tres meses, por favor, consulte www.lme.com. En caso de que no haya liquidez, se utilizará el precio total recibido en el curso de la adquisición del metal.<br>
Metales preciosos: Posteriormente el precio de compra se calcula con base en el precio en el mercado de los metales que se representan en la canasta derivado del precio fijo diario por la tarde publicado por la London Bullion Market Association en el día que TTV adquiera la canasta en el transcurso del evento de IMS, más la prima física según lo determinado por el mercado y un incremento en el precio del 4.5% (si este contrato de suscripción se firmó antes de que TTV vendiera el equivalente a 10 millones de CHF en fichas) y del 9% (después del “ajuste”).<br>
Suscripción.  El comprador se suscribe por <?php echo $selected_amount_price; ?> y el vendedor vende dicho número antes mencionado de canastas sujeto al ajuste y las emisiones de T-Coins al comprador como se determina conforme a los términos y condiciones del contrato. <br> 
    En fe de lo cual, las partes aquí presentes han hecho que este contrato sea debidamente ejecutado el día y año escrito a continuación. Las partes están de acuerdo y confirman mediante la celebración de este contrato expresamente que:<br>
•   Han leído y entendido los términos y condiciones de este contrato (incluyendo los términos y condiciones generales y la transparencia del riesgo).<br>
•   Han recibido la suficiente información sobre los metales que forman la canasta y la función de la T-Coin como para tomar una decisión informada.<br>
•   Han leído y entendido el contenido del libro blanco en el contexto de la venta de metales y la subsecuente emisión de las fichas T-Coin.<br><br>

PÁGINA DE FIRMAS A CONTINUACIÓN<br><br>

<div class="col-md-12 nopad">
<div class="col-md-6 nopad">                               
El comprador/Firma <br>
[……………….]     
</div>                     
<div class="col-md-6 nopad">   
<span class="pull-right">                          
Fecha/Lugar
     </span>  
</div>
</div>

<br>                
<br>                
<br> 

<div class="col-md-12 nopad">
<div class="col-md-6 nopad">                               
El vendedor/Firma <br>
[……………….]     
</div>     

<div class="col-md-6 nopad">  
 <span class="pull-right">                          
Fecha/Lugar
     </span>  
</div>
</div>



                                        <?php

                                            }elseif($_SESSION['kyc_lang']=="tr"){
                                        ?>

METAL SEPETİ VE BUNA MÜTEAKİP TANIMLAMA ARACI OLAN TOKENLERİN DÜZENLENMESİ İÇİN ABONELİK SÖZLEŞMESİ
<br><br>

İş bu Abonelik Sözlşemesine bir metal sepetin satımı <b><?php echo date("m-d-Y"); ?></b> ve buna müteakip tanımlama aracı olan tokenlerin çıkarılması için (“Sözleşme”) itibari ile, aşağıdakiler arasında girilmiştir.<br>

TIBERIUS TECHNOLOGY VENTURES AG, İsviçre yasalarına göre düzenlenmiştir ve Dorfstrasse 13, 6340 Baar adresinde kayıtlıdır (“Satıcı”, “TTV”, “Emin”).<br><br>

ve <br><br>

<?php echo $name; ?> (“Alıcı” veya “Devreden”) <?php echo $address; ?> adresinde kayıtlı.<br><br>

(her bir “Taraf” ve toplu olarak “Taraflar”).<br><br>

İş bu Sözleşme üç alt sözleşmeden oluşmaktadır (“Alt Sözleşmeler”):<br><br>

•   Metal bir sepet ve müteakiben tanımlama amaçlı tokenlerin çıkarılmasını içeren Abonelik Sözleşmesi<br>
•   Emanet Sözleşmesi<br>
•   Alıcı veya herhangi bir iştirakı adına zilyetlik talimatı<br><br>
    
    Bu Sözleşme ayrıca Alıcı adına Sepete abonelik yapması, daha sonra bu Sepeti Alıcıya geçirmesi ve tanımlama amaçlı Tiberius Coin’leri (“T-Coin”) çıkarması için TTV’ye verilen açık bir talimatı da içermektedir.<br><br>


GİRİŞ<br><br>

TTV Alıcıya farklı baz ve değerli metallerden oluşan bir sepet satmayı planlamaktadır (“Sepet”);
Sepet ve tüm kripto para birimleri gibi tedavülü zorunlu para birimi olmayan herhangi bir finansal varlık, para birimi olarak kabul edilmez (“Risk Varlığı”);<br>
Sepet Aboneliğinin bir parçası olarak Alıcı tarafından TTV’ye ödenen fonlar veya kabul edilmiş Risk Varlıkları TTV kontrolü altında olacaktır (“Abonelik Fonları”);<br>
TTV, Alıcının Aboneliğini tamamen veya kısmen yerine getirme veya hiç yerine getirmeme hakkını saklı tutar (“Yerine Getirilmeyen Abonelik”);<br>
Abonelik Fonları, Yerine Getirilmeyen Abonelik halinde Alıcıya iade edilir (“Kullanılmayan Abonelik Fonları”);<br><br>

TTV herhangi bir Risk Varlığının, Aboneliğin parçası olan Sepet alımı sırasında ticaretini yapabilir ama daha sonra TTV kendi takdirine bağlı olarak Yerine Getirilmeyen Abonelik kapsamında Abonelik Fonlarından gelen herhangi bir varlığı veya Sepetin tümünü veya bir kısmını satabilir (“Tasfiye edilen Sepet/Varlıklar”);<br>
TTV'nin, Abonelik için Sepeti satın almasında ya da Yerine Getirilmeyen Abonelik ile ilgili Tasfiye edilen Sepet/Varlıklar satın almasında maruz kaldığı maliyetler, ticari kayıplar veya fırsat maliyetleri, Kullanılmayan Abonelik Fonları iade edilmeden önce Alıcı tarafından ödenecektir (“Ticari Maliyetler”);<br>
Ticari Maliyetler, TTV'nin Abonelik Fonlarının ticaretini yapması veya Abonelik Fonlarından herhangi bir Risk Varlığı veya para birimi üzerinden işlem yapması durumunda gerçekleşen tüm maliyet, fırsat maliyetleri ve ticari kayıpları kapsamaktadır;<br>
TTV, Alıcıya geçecek olan, ticareti yapılan kripto para birimlerinin fiyatlarını kamuya açık yayımlayacaktır ve bu fiyat Ticari Maliyetler düşülerek piyasa oranlarına yakın olacaktır;
Alıcı, TTV'ye seçtiği bir antrepoya Sepeti yerleştirme talimatı verir (“Depo”) ve Depo boş sipariş kağıtları halinde depo sertifikaları düzenler (“Depo Sertifikası”); <br>
Depo Sertifikaları, Global Sertifika ile değiştirilecektir (“Global Sertifika”) ve Depo Sertifikaları ve Global Sertifika, TTV veya TTV tarafından atanan bir taraf nezaretinde tutulacaktır;<br>
Alıcı, birleştirilmiş Depo Sertifikalarında temsil edilen toplam metal miktarı ile Alıcıya ait Depo Sertifikaları tarafından temsil edilen bireysel metal miktarı arasındaki orana göre Global Sertifika üzerinde müşterek mülkiyet sahibi olacaktır;<br>
Alıcı ve TTV, TTV’nin Alıcı veya Alıcının Global Sertifikada müşterek mülkiyetini transfer ettiği üçüncü taraf (Miteigentum) adına Global Sertifikayı zilyetinde tutacağına hemfikirdirler.  <br>
TTV, Sepetin satıcısı ve tokenlerin üreticisi sıfatıyla Alıcıya Sepetini tanımlayan T-Coin’leri çıkarır ve bu tokenler 2018’in sonuna kadar veya daha önce veya hemen sonrasında gerçekleşecek olan Dijital Metal Arzının (Initial Metal Sale “IMS”) sonunda oluşturulur;<br>
TTV, Alıcıya Sepetin satışı ve T-Coin’lerin fonksiyonu ve amacını açıklayan, iş bu Sözleşmede yer alan tarih ile aynı tarihi içeren bir Beyaz Kâğıt düzenlemiştir (“Beyaz Kâğıt”);<br>
İş bu Sözleşmenin Yürürlük Tarihinde Satıcı, Alıcıya satış yapmayı ve Alıcı, Satıcının Sepetinden satın almayı taahhüt eder ve Satıcı, daha sonra iş bu Sözleşmenin hüküm ve şartlarına tabi olarak T-Coin'lerin teslim edilmesine ilişkin transfer edilemez hak taleplerini ihraç eder;<br>
Alıcı, TTV’ye Alıcı adına Sepete abonelik yapmasını ve daha sonra T-Coin’lerin Alıcıya atanmasının açıkça talimatını vermektedir;<br>
Gelecek T-Coin’lerin transferi iş bu Sözleşmenin hüküm ve şartlarına tabi olarak IMS’in başarıyla gerçekleşmesinin ardından etkilenecektir;<br><br>

DOLAYISI İLE, yasal olarak Sözleşme ile bağlı olma niyetinde olan Taraflar, iş bu Sözleşme ile beyan edilen karşılıklı taahhütler ve anlaşmalar dikkate alınarak, burada bulunan hüküm ve şartlara tabi olarak aşağıdaki gibi mutabıktırlar:<br><br>

SÖZLEŞME<br><br>


Satın Alma Fiyatı.<br>
 Sepet başına fiyat, IMS etkinliğinin sonunda Sabitlemede baz ve değerli metaller durumuna göre belirlenir. <br>
Baz Metaller: Satın Alma Fiyatı daha sonra Sepet'te temsil edilen metallerin piyasa fiyatlarına göre nakit olarak türetilir veya TTV’nin Sepeti satın aldığı gün artı piyasada belirlenen fiziki prim, %4,5 (eğer bu Abonelik Sözleşmesi TTV CHF 10 milyon değerinde token satmadan önce imzalanmışsa) ve %9 (daha sonra) zamma göre Londra Metal Borsası’ndaki üç aylık resmi fiyatlar [13.00-14.00 CET] doğrultusunda hesaplanır. Nakit ve Üç Aylık fiyatlar için lütfen www.lme.com adresine müracaat ediniz. Sabitlemede likidite mevcut değilse, TTV’nin Sepeti alımından kaynaklanan dolum fiyatı kullanılacaktır.<br><br> 

Değerli Metaller: Satın Alma Fiyatı, Sepette temsil edilen metallerin piyasa fiyatının TTV’nin Sepeti satın alma tarihinde Londra Külçe Pazarı Birliği tarafından yayımlanan günlük öğleden sonra sabitleme fiyatından türetilmesi, artı %4,5 (eğer bu Abonelik Sözleşmesi TTV CHF 10 milyon değerinde token satmadan önce imzalanmışsa) ve %9 (daha sonra) zamma göre hesaplanacaktır(“Sabitleme”). <br>
Abonelik. Alıcı, <?php echo $selected_amount_price; ?> miktarında yatırım yapmakta ve Satıcı sabitlemeye bağlı olarak yukarıda sözü geçen sayıda Sepet satmakta ve Alıcıya iş bu Sözleşmenin Hüküm ve Şartları uyarınca T-Coin’ler çıkarmaktadır. <br>
    BURADA TARAFLAR, iş bu Sözleşmenin aşağıda yazılı gün ve yıl itibariyle usulüne uygun olarak yerine getirilmesine neden olmuşlardır. Taraflar, bu Sözleşmeyi uygulayarak aşağıdakileri açıkça kabul eder ve onaylarlar:<br><br>

• İş bu Sözleşmenin hüküm ve şartlarını okuyup anlamışlardır (Genel Hüküm ve Şartlar ve Risk Bildirimi dahil);<br>
• Sepeti oluşturan metaller ve T-Coin'in işlevi hakkında bilinçli karar vermek için yeterli bilgi almışlardır;<br>
• Metallerin satışı ve müteakiben T-Coin tokenlerinin çıkarılması bağlamında Beyaz Kağıdın içeriğini okuyup anlamışlardır.<br><br><br>






İMZA SAYFASI BİR SONRAKİ SAYFADADIR<br><br><br>





<div class="col-md-12 nopad">
<div class="col-md-6 nopad">                               
Alıcı/İmza <br>
[……………….]     
</div>                     
<div class="col-md-6 nopad">   
<span class="pull-right">                          
Tarih/Yer
     </span>  
</div>
</div>

<br>                
<br>                
<br> 

<div class="col-md-12 nopad">
<div class="col-md-6 nopad">                               
Satıcı/İmza <br>
[……………….]     
</div>     

<div class="col-md-6 nopad">  
 <span class="pull-right">                          
Tarih/Yer
     </span>  
</div>
</div>




                                        <?php

                                            }
                                        ?>



                </div>
            </div>
        </div>
</div>



    <div class="col-md-12 nopad m-t-40">

        <div class="form-group">
            <input type="hidden" name="step_1_agree" value="1">
             <a href="<?php echo base_url().'buy-tokens/'.strtolower($option->name).'/hash'; ?>">
            <button id="i_agree" class="btn btn-default pull-right " type="button" name="submit" value="1">
                <?php echo get_lang_msg("confirm"); ?>
            </button>
        </a>
            <a href="<?php echo base_url().'better-luck-next-time'; ?>">
                <button class="btn btn-danger pull-right m-r-10" type="button">
                    <?php echo get_lang_msg("cancel"); ?></button>
            </a>

        </div>

    </div>         
</div>
                         
                
                   

                                   

                              

</form>

             

</div>



<script>

    var resizefunc = [];

</script>

<?php include("common/footer.php");?>



<style type="text/css">
    .taking_image img{
      float: left;
    width: 200px;
    margin: 10px;
    padding: 2px;
    border:1px solid;
}
.easy{
    float: left;
    width: 100%;
}
.mt-10{
    margin-top: 10px;
}
.w-auto{
    width: auto !important;
}
.on_kyc_margin_bottom_100{
    margin-bottom: 100px;
}
</style>


</body>

</html>

