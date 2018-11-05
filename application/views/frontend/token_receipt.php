<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="<?php echo base_url().'resources/frontend/images/logo-invoice.png'; ?>" style="width:100%; max-width:90px;">
                            </td>
                            
                            <td>
                               <?php echo $r->address; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td width="160px">
                               <?php echo $u->uFname; ?> <?php echo $u->uLname; ?>
                               <br>

                               <?php if($u->uAddress){ echo $u->uAddress; ?>

                                <?php }else{ ?>

                                <?php if($u->uCity){ echo $u->uCity; ?>

                               <br>
                                <?php } ?>

                               <?php
                               $country = $this->db->where('id',$u->uCountry)->get('dev_web_countries')->result_object();
                               if(!empty($country))
                               {
                                echo $country->nicename;
                                ?>
                                <?php } } ?>
                            </td>
                            
                            <td>
                                <b>License Nr.</b>
                                <?php echo $r->license; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                   Token Receipt No.
                </td>
                
                <td>
                    <?php echo $t->transaction_id; ?>
                </td>
            </tr>
            <tr class="heading">
                <td>
                   Token Receipt Date
                </td>
                
                <td>
                    <?php echo date("Y-m-d",strtotime($t->datecreated)); ?>
                </td>
            </tr>
            <tr class="heading">
                <td>
                    Bonus
                </td>
                
                <td>
                    <?php $_x= $t->tokens - $t->without_bonus_tokens;
                    echo number_format(( $_x / $t->without_bonus_tokens ) * 100,2).'%';
                     ?>
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Currency
                </td>
                
                <td>
                    <?php echo $t->amtType; ?>
                </td>
            </tr>
             <tr class="">
                <td>
            <br>
            <br>
        </td>
    </tr>

           
            
            <tr class="heading">
                <td>
                    Item
                </td>
                
                <td>
                    Price
                </td>
            </tr>
            
            <tr class="item">
                <td>
                   <?php echo number_format($t->tokens,decimals_()); ?> SRXIO TOKENS
                </td>
                
                <td>
                   <?php echo $t->amountPaid; ?> <?php echo $t->amtType; ?>
                </td>
            </tr>

             <tr class="">
                <td>
            <br>
            <br>
        </td>
    </tr>
    <tr class="heading">
                <td>
                    Total
                </td>
                
                <td>
                    <?php echo $t->amountPaid; ?> <?php echo $t->amtType; ?> (Debit)
                </td>
            </tr>


    <tr class="">
                <td>
            <br>
            <br>
        </td>
    </tr>


    <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td width="260px">
                               Details:
                               <br>

                               



<?php if($c->type==1){ ?>
                   <?php if($c->address){ ?>

Wallet Address: <?php echo $c->address; ?>
<br>
                  


                    <?php } }else if($c->type==2){ ?>

Method: Stripe<br>


                        <?php }else if($c->type==3){ ?>

                    
                        <?php if($c->bank_name){ ?>
Bank Name: <?php echo $c->bank_name; ?><br>
                           
                        <?php } if($c->bank_address){ ?>
Bank Address: <?php echo $c->bank_address; ?><br>
                       
                        <?php } if($c->routing_number){ ?>
Routing Number: <?php echo $c->routing_number; ?><br>
                       
                        <?php } if($c->swift_code){ ?>
Swift Code: <?php echo $c->swift_code; ?><br>
                      
                        <?php } if($c->iban){ ?>
IBAN: <?php echo $c->iban; ?><br>
                       
                        <?php } if($c->account_number){ ?>
Account Number: <?php echo $c->account_number; ?><br>
                         
                        <?php } if($c->account_name){ ?>
Account Name: <?php echo $c->account_name; ?><br>

                      
                        <?php } if($c->account__address){ ?>
Account Address: <?php echo $c->account__address; ?><br>
                       
                        <?php } if($c->account__phone_number){ ?>
Account Phone Number: <?php echo $c->account__phone_number; ?><br>
                       
                        <?php }  ?>

                     
                  


                        <?php }elseif($c->type==4 || $c->type==5){ ?>

Method: Western Union<br>
                        <?php if($c->receiver_full_name){ ?>
Receiver Full Name:<?php echo $c->receiver_full_name; ?><br>
                       
                        <?php } if($c->receiver_city){ ?>

Receiver City:<?php echo $c->receiver_city; ?><br>
                       
                        <?php } if($c->receiver_city){ ?>
Receiver Country:<?php 
                                $rcvr_country = $this->front_model->get_query_simple('nicename','dev_web_countries',array('id'=>$c->receiver_country))->result_object()[0];
                                echo $rcvr_country->nicename;
                                 ?>

                       
                        <?php }  ?>
<br>

                        <?php } ?>




















































                               
                            </td>
                            
                           
                        </tr>
                    </table>
                </td>
            </tr>
            
            
        </table>
    </div>
</body>
</html>