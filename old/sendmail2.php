<?php

//isset($_REQUEST['email'])

  if (isset($_REQUEST['email']))  {
  
  //Email information
  $to = $_REQUEST['email'];
  $subject = "Hello ". $_REQUEST['name'] ." : Confirmation to Sailesh and Eshwari's Marriage";
  
  
  //create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time())); 


  //define the headers we want passed. Note that they are separated with \r\n
$headers = "From: invite@saileshwedseshwari.in\r\nReply-To: saileshkalluri@gmail.com". "\r\n";
$headers .= "Cc: saileshkalluri@gmail.com, kolluri.eshwari@gmail.com". "\r\n";
//add boundary string and mime type specification
$headers .= "MIME-Version: 1.0" . "\r\n" . "Content-type: text/html; charset=UTF-8" . "\r\n"; 
  
  $email = "invite@saileshwedseshwari.in";
  
  $comment = $_REQUEST['message'];
 
 
$message = '<h3>Hi '.$_REQUEST['name'].'</h3>' ;
$message .= '
    <div style="margin-left: 30px">
        <div>
            <h4>Thank you, We are extremely happy to see that we recieved your RSVP. </h4>
           <h4>
        You are cordially invited to our wedding on 
        
       <a href="http://calendar.google.com/calendar/render?action=TEMPLATE&text=Sailesh%20and%20Eshwari%20Marriage&dates=20160301T042500Z/20160305T150000Z&details=For+details,+Please%20Visit%20:+saileshwedseshwari.in&location=Wedding- Sri Manjunatha Palace Marriage Hall, Thanisandra Main Road, Bangalore. Reception- Sama Bhoopal Reddy Gardens, Piller No. 173, Upparapally, Hyderabad&sf=true&output=xml#eventpage_6"> 
       <span style="background-color: yellow; ">
                1<sup>st</sup> and 5<sup>th</sup> March, 2017

            </span> </a>

            
        
    </h4>
        </div>
        <div >
            Here are the details: <br />
            <br />
            <table style="margin-left: 30px ; font-weight:bold;">
                <tr>
                    <td>Name </td>
                    <td>:&nbsp; '.$_REQUEST['name'] .'</td>
                </tr>
                <tr>
                    <td>No. of Guests </td>
                    <td>:&nbsp; '.$_REQUEST['guests'] .'</td>
                </tr>
                <tr>
                    <td>Attending </td>
                    <td>:&nbsp; '.$_REQUEST['attending'] .'</td>
                </tr>
                <tr>
                    <td>Message </td>
                    <td>:&nbsp; '.$_REQUEST['message'] .'</td>
                </tr>

            </table>
        </div>

        <div >
            Venue details: <br />
            <br />
            <table style="margin-left: 30px ; font-weight:bold;">
                <tr>
                    <td>Wedding: </td>
                    <td>Sri Manjunatha Palace Marriage Hall, Thanisandra Main Road, Bangalore</td>
                    <td>
                        <a class="map-button" href="https://www.google.com/maps/place/Manjunatha+Convention+Hall/@13.054807,77.6309858" target="_blank">
                            <span>Open in Google Maps</span>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Reception: </td>
                    <td>Sama Bhoopal Reddy Gardens, Piller No. 173, Upparapally, Hyderaguda, Attapur, Hyderabad</td>
                    <td>
                        <a class="map-button" href="https://maps.google.com/?q=17.3519389,78.479113" target="_blank">
                            <span>Open in Google Maps</span>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        
        
    </div>
    <div>
        <h3 style="margin-bottom: 0">Thank You,</h3>
        <p style="margin-top: 5px"><b>Sailesh &amp; Eshwari</b></p>
    </div>
    <div style="text-align: center">
        
    </div>';
    

//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed";
?>  
  
  <?	   
  //Email response
  echo "Thank you !";
  }
  
  //if "email" variable is not filled out, display the form
  else  {
echo "Sorry Email Couldnt be sent!";
  }
?>	