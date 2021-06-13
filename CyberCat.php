<?php
// APIs dont like these unless encoded but we need them for regex checking
function remove_http($url) {
    $disallowed = array('http://', 'https://', 'https://www.', 'http://www.', 'www.');
    foreach($disallowed as $d) {
        if(strpos($url, $d) === 0) {
            return str_replace($d, '', $url);
        }
    }
    return $url;
}
if(isset($_POST['datalookup']))
{
    $data =  $_POST['datalookup'];
    // check if ip, domain or hash
    if(preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/',$data)){
        $type = "ip";
    }
    // match as domain
    elseif(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$data)){
        $type = "url";
        $data = remove_http($data);
    }
    // probably a hash at this point
    else {
        $type = "hash";
    }
}
// [======\ PASSIVE TOTAL /===============================================================]
function PassiveTotal($data, $query_type){
    $username = '';
    $password = '';
    $url = 'https://api.passivetotal.org/v2/'.$query_type;
// set payload
    $payload = json_encode( array( "query" => $data ) );
//  Initiate curl
    $ch = curl_init();
// Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt( $ch, CURLOPT_URL,$url );
    curl_setopt( $ch, CURLOPT_USERPWD, "$username:$password" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
// Execute
    $result=curl_exec($ch);
// Closing
    curl_close($ch);
    $d = json_decode($result, true);

    if($query_type=="X") {
        echo $result;
    }

    return $d;
}
// [======================================================================================]
// [======\ SHODAN /======================================================================]
function Shodan($data, $query_type){
    $password = '';
    $url = 'https://api.shodan.io/'.$query_type . "/". $data ."?key=" . $password;

//  Initiate curl
    $ch = curl_init();
// Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt( $ch, CURLOPT_URL,$url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
// Execute
    $result=curl_exec($ch);
// Closing
    curl_close($ch);
    $d = json_decode($result, true);

    if($query_type=="shodan/host") {
        echo $result;
    }

    return $d;
}
// [======================================================================================]
// [======\ IPQS /========================================================================]
function IPQS($data, $query_type){
    $key = '';
    $url = 'https://ipqualityscore.com/api/json/'.$query_type . "/". $key ."/" . $data;

//  Initiate curl
    $ch = curl_init();
// Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt( $ch, CURLOPT_URL,$url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
// Execute
    $result=curl_exec($ch);
// Closing
    curl_close($ch);
    $d = json_decode($result, true);

    return $d;
}
// [======================================================================================]

?>
<html>
<body style="margin:0px;padding:0px;background-image:url('https://wallpaperaccess.com/full/1398272.jpg');background-position: center center;background-attachment: fixed; cursor: crosshair;">
<style>
    .tdh1 {
        cellpadding-left:5px;
        width:250px;
        align:right;
        background-color:#07FFB1;
        color:#092847;
        font-family:verdana;
        font-size:18pt;
        font-weight:bold;
        padding:10px;
    }
    .tdh2 {
        cellpadding-left:5px;
        cellpadding-right:5px;
        width:750px;
        align:left;
        background-color:#07FFB1;
        color:#092847;
        font-family:verdana;
        font-size:16pt;
        padding:10px;
    }
    .tdh3 {
        cellpadding-left:5px;
        cellpadding-right:5px;
        width:750px;
        align:left;
        background-color:#00FFFF;
        color:#1B2F62;
        font-family:verdana;
        font-size:16pt;
        padding:10px;
    }
    .td1 {
        cellpadding-left:5px;
        width:250px;
        align:left;
        background-color:#1B2F62;
        color:#FFAA2A;
        font-family:verdana;
        font-size:12pt;
        font-weight:bold;
        padding:5px;
    }
    .td2 {
        cellpadding-left:5px;
        cellpadding-right:5px;
        width:750px;
        align:left;
        background-color:#1B2F62;
        color:#fff;
        font-family:verdana;
        font-size:10pt;
        padding:5px;
    }

    form{
        padding:0px;
        margin:0px;
    }

    input[type=text] {
        background-color:#07FFB1;
        color:#092847;
        font-family:verdana;
        font-size:16pt;
        padding:10px;
        border:0px;
        font-weight:bold;
        width:650px;
    }

    input[type=text]:focus {
        background-color:#092847;
        color:#FFAA2A;
    }

    input[type=text]:hover {
        border:solid 1px #1B2F62;
    }

    input[type=submit] {
        background-color:#FFAA2A;
        color:#000;
        font-family:verdana;
        font-size:16pt;
        padding:10px;
        border:1px solid #000;
        font-weight:bold;
    }

    input[type=submit]:hover {
        background-color:#1B2F62;
        color:#FFAA2A;
    }
    
    a:active{
        color:#07FFB1;
    }
    a:visited{
        color:#07FFB1;
    }
    a:hover{
        color:#07FFB1;
    }

    .tabs{
        margin:0px;
        padding:0px;
    }

    table {
        padding:0px;
        margin:0px;
    }

    /* tab list item */
    .tabs .tabs-list{
        list-style:none;
        margin:0px;
        padding:0px;
    }
    .tabs .tabs-list li{
        width:150px;
        margin:0px;
        float:left;
        margin-right:2px;
        padding:10px 5px;
        text-align: center;
        background-color:#FF10F0;
        color:#092847;
        border:#FF10F0 1px solid;
        font-size:12pt;
        font-weight:bold;
        font-family:verdana;
    }
    .tabs .tabs-list li:hover{
        cursor:pointer;
    }
    .tabs .tabs-list li a{
        text-decoration: none;
        color:white;
    }

    /* Tab content section */
    .tabs .tab{
        display:none;
        clear:both;
        width:1000px;
        background-color: #092847;
        margin:0px;
        padding:0px;
    }

    /* When active state */
    .active{
        display:block !important;
    }
    .tabs .tabs-list li.active{
        border-top:#FF10F0 1px solid;
        border-left:#FF10F0 1px solid;
        border-right:#FF10F0 1px solid;
        border-bottom:#FF10F0 1px solid;
        background-color:#092847;
        color:#00FFFF;
        font-size:12pt;
        font-weight:bold;
        font-family:verdana;
    }


</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $(".tabs-list li a").click(function(e){
            e.preventDefault();
        });

        $(".tabs-list li").click(function(){
            var tabid = $(this).find("a").attr("href");
            $(".tabs-list li,.tabs div.tab").removeClass("active");   // removing active class from tab and tab content
            $(".tab").hide();   // hiding open tab
            $(tabid).show();    // show tab
            $(this).addClass("active"); //  adding active class to clicked tab

        });

    });
</script>

<?php
if(!isset($_POST['datalookup'])) {
    echo '
?>
<center>
        <table style="width:1000px;height: 200px;position: fixed;top: 50%;left: 50%;margin-top: -200px;margin-left: -500px;">
            <?php $WHOIS = PassiveTotal($data, "whois"); ?>
            <tr><td colspan="2"><img src="https://i.ibb.co/cK57yym/ccat.png"></td></tr>
            <tr>
                <td class="tdh1" style="text-align: right"><b>LOOKUP:</b></td>
                <td class="tdh2"><b><form action="api.php" method="post">
                            <input type="text" name="datalookup" placeholder="IP - DOMAIN (http(s)://) - HASH"/>
                            <input type="submit" name="submit" value="GO" />
                        </form></b></td>
            </tr>
        <tr><td colspan="2" style="padding:12px; background-color: #1B2F62;color:white;font-size: 12pt;font-family: Verdana;font-weight: bold">(c) 2021 Truvis Thornton. <a target="_blank" href="https://github.com/Truvis/CyberCat">GIT CyberCat</a></td></tr>
        </table>
</center>

<?php
';
    exit();
}
?>

<center>
    <div class="tabs">
    <table style="width:1000px">
        <?php $WHOIS = PassiveTotal($data, "whois"); ?>
        <tr><td colspan="2"><img src="https://i.ibb.co/cK57yym/ccat.png"></td></tr>
        <tr>
        <td class="tdh1" style="text-align: right"><b>LOOKUP:</b></td>
        <td class="tdh2"><b><form action="CyberCat.php" method="post">
                    <input type="text" name="datalookup" placeholder="IP - DOMAIN (http(s)://) - HASH" value="<?php echo $data; ?>"/>
                    <input type="submit" name="submit" value="GO" />
                </form></b></td>
        </tr>
        <tr><td colspan="2">
            <ul class="tabs-list">
                <li class="active"><a href="#tab1">PassiveTotal</a></li>
                <li ><a href="#tab2">IPQS</a></li>
                <li ><a href="#tab3">VirusTotal<a/></li>
                <li ><a href="#tab4">H-Analysis<a/></li>
                <li ><a href="#tab5">XWho<a/></li>
            </ul>
        </td></tr>
    </table>

        <div id="tab1" class="tab active">
        <table style="width:1000px">
        <tr><td class="tdh3" colspan="2"><b>WHOIS</b></td></tr>
        <?php
        foreach($WHOIS as $f){
            foreach($f as $k=>$v) {
            echo "<tr>
            <td class=\"td1\">". $k ."</td>
            <td class=\"td2\">". $v ."</td>
            </tr>";
            }
        }
        ?>
            <tr><td class="tdh3" colspan="2"><b>SSL HISTORY</b></td></tr>
            <?php $SSL = PassiveTotal($data, "ssl-certificate/history"); ?>
            <?php
            foreach($SSL as $f) {
                foreach ($f as $k => $v) {
                    if (empty($v)){$v = 'none';}
                        $GET_SSL = PassiveTotal($v['sha1'], "ssl-certificate");
                            foreach($GET_SSL as $l) {
                                foreach ($l as $n) {
                                    echo "<tr><td class=\"td1\">" . $n['issueDate'] . "</td><td class=\"td2\">";
                                    foreach($n as $p=>$o) {
                                        echo "<b style='color:#07FFB1'>". $p . ":</b> ". $o ."</br>";
                                    }
                                        echo"</td></tr>";
                                }
                            }
                }
            }
            ?>
        <tr><td class="tdh3" colspan="2"><b>SINKHOLE</b></td></tr>
        <?php $SINKHOLE = PassiveTotal($data, "actions/sinkhole");
        foreach($SINKHOLE as $k=>$v){
            if(empty($v)){$v='none';}
                echo "<tr>
            <td class=\"td1\">". $k ."</td>
            <td class=\"td2\">". $v ."</td>
            </tr>";
        }
        ?>
        <tr><td class="tdh3" colspan="2"><b>SUBODMAINS</b></td></tr>
        <?php $SUBD = PassiveTotal($data, "enrichment/subdomains");
        foreach($SUBD as $f){
            foreach($f as $k=>$v) {
                if(empty($v)){$v='none';}
                echo "<tr>
            <td class=\"td1\">" . $k . "</td>
            <td class=\"td2\">" . $v . "</td>
            </tr>";
            }
        }?>
        <tr><td class="tdh3" colspan="2"><b>MALWARE</b></td></tr>
        <?php $MALWARE = PassiveTotal($data, "enrichment/malware");
        foreach($MALWARE as $f){
            foreach($f as $k=>$v) {
                if(empty($v)){$v='none';}
                echo "<tr>
            <td class=\"td1\">". $k ."</td>
            <td class=\"td2\">" . $v['collectionDate'] . " <br>" . $v['sample'] . " <br> " . $v['source'] . " <br> " . $v['sourceUrl'] . "</td>
            </tr>";
            }
        }?>
        </table>
        </div>

        <div id="tab2" class="tab">
            <table style="width:1000px">
                <tr><td class="tdh3" colspan="2"><b>IP INFO</b></td></tr>
                <?php
                        if ($type == "ip") {
                            $IP = IPQS($data, "ip");
                        } elseif ($type == "url") {
                            $IP = IPQS($data, "url");
                        }
                        foreach($IP as $k=>$v){
                        if(empty($v)){$v='none';}
                            echo "<tr>
                            <td class=\"td1\">". $k ."</td>
                            <td class=\"td2\">". $v ."</td>
                            </tr>";
                        }
                ?>
            </table>
        </div>

        <table style="width:1000px">
        <tr><td colspan="2" style="padding:12px; background-color: #FF10F0;color:white;font-size: 12pt;font-family: Verdana;font-weight: bold">(c) 2021 Truvis Thornton. <a target="_blank" href="https://github.com/Truvis/CyberCat">GIT CyberCat</a></td></tr>
        </table><br><br><br>
    </div>
</center>
</body>
</html>
