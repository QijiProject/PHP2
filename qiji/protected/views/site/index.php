<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<?php
if(Yii::app()->user->isGuest)
{
?>
<input type="button" onclick="location.href='<?php echo $this->createUrl("site/login"); ?>';" value="Login" />
<?php
}
else
{
?>
<div>
    <input type="button" onclick="location.href='<?php echo $this->createUrl("site/im"); ?>';" value="Login to IM" />
    <input type="button" onclick="location.href='<?php echo $this->createUrl("site/imlogout"); ?>';" value="Logout IM" />

    <?php
    if(isset($msg)) { ?>
    <div class="info">
        <?php echo $msg; ?>
    </div>
    <?php } ?>
    <!-- <input type="button" onclick="location.href='<?php //echo $this->createUrl("site/getbalance"); ?>';" value="GetBalance" /> -->
    <input type="button" onclick="location.href='<?php echo $this->createUrl("site/logout"); ?>';" value="Logout" />
</div>

<br><hr>

<div>
    <button onclick="getBalance()">GetBalance</button>
    <button onclick="getBalanceAjax()">GetBalanceAjax</button>
    <p id="balance"></p>
</div>

<br><hr>

<!-- form deposit -->
<div class="form">
    Amount: <input type="amount" name="amount" id="amount"><br>
    <!-- <button onclick="doDeposit()">DoDeposit</button> -->
    <button onclick="doDepositAjax()">DoDepositAjax</button>
    <p id="deposit"></p>

</div>
<!-- form -->

<br><hr>

<!-- form deposit -->
<div class="form">
    Amount: <input type="amount" name="amountW" id="amountW"><br>
    <button onclick="doWithdrawAjax()">DoWithdrawAjax</button>
    <p id="withdraw"></p>

</div>
<!-- form -->
<?php
}
?>

<p id="balance"></p>

<script>
function getBalance() {
    // var uri = "http://10.101.1.87:8080/webproject/transaction/getBalance?membercode=test";
    var uri = "http://sbstaging.qiji7878.com/webproject/transaction/getBalance?membercode=test";
    var url = encodeURI(uri);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("balance").innerHTML = this.responseText;
    }
    };
    xhttp.open("GET", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    // xhttp.send("fname=Henry&lname=Ford");
}

function getBalanceAjax() {
    // var uri = "http://10.101.1.87:8080/webproject/transaction/getBalance?membercode=test";
    var uri = "http://sbstaging.qiji7878.com/webproject/transaction/getBalance?membercode=test";
    var url = encodeURI(uri);
    // $.ajax({
    //     url: url,
    //     type: 'GET',
    //     dataType: 'json',//server repsonse
    //     contentType: 'application/json',
    //     success: function (response) {
    //         // document.getElementById("balance").innerHTML=response.d.Body.getMemberBalanceXMLResponse.amount;
    //         $("#balance").html(response.d.Body.getMemberBalanceXMLResponse.amount);
    //         // alert(response);
    //         // if (response.statusCode == '200') {
    //             // $("#balance").html(response.d.Body.getMemberBalanceXMLResponse.amount);
    //         // }
    //     },
    //     error: function(XMLHttpRequest, textStatus, errorThrown) { 
    //         alert("Status: " + textStatus); alert("Error: " + errorThrown); 
    //     },
    //     complete: function () {

    //     }
    // });

    $.get(url, function(result, status){
        // alert("Data: " + result + "\nStatus: " + status);
        $("#balance").html(result);
      });
}

function doDeposit() {
    // var x = document.forms["myForm"]["amount"].value;

    // var amount = document.getElementById("amount").value;
    // alert(amount);

    // var uri = "http://10.101.1.87:8080/webproject/transaction/doTransaction";
    var uri = "http://sbstaging.qiji7878.com/webproject/transaction/doTransaction";
    var url = encodeURI(uri);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("deposit").innerHTML = this.responseText;
    }
    };
    // xhttp.open("POST", "http://localhost/yii/new/index.php?r=sports/try", true);
    xhttp.open("POST", url, true);
    // xhttp.open("GET", "http://uat.jocom.com.my", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send();
    // xhttp.send("fname=Henry&lname=Ford");
}

function doDepositAjax() {    
    // var uri = "http://10.101.1.87:8080/webproject/transaction/doTransaction";
    var uri = "http://sbstaging.qiji7878.com/webproject/transaction/doTransaction";
    var url = encodeURI(uri);
    // alert("Value: " + $("#amount").val());

    // var data = {"membercode": "test","amount": $("#amount").val(),"currencyCode": "RMB","tout": "10001","tin": "10000"};
    var data = {"amount": $("#amount").val(),"tout": "10001","tin": "10000"};

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',//server repsonse
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function (response) {
            // $("#balance").html=response.d.Body.withdrawXMLResponse.statusDesc;
            // document.getElementById("deposit").innerHTML=response.d.Body.depositXMLResponse.statusDesc+": "+$("#amount").val();
            $("#deposit").html(response.d.Body.depositXMLResponse.statusDesc+": "+$("#amount").val());
            // alert(response.status);
            // alert(response.d.Body.withdrawXMLResponse.statusDesc);
            // console.log(response);
            // $("#balance").html=response;
            // for (x in response) {
            //     document.getElementById("balance").innerHTML += x + "<br>";
            // }
            // var result = JSON.parse(response);
            // alert(result);
            
            // if (response.m == 'statusCode: 200') {
            // if (response.statusCode == '200') {
            //     alert(response.m);
            //     // $("#balance").html=response.d.Body.withdrawXMLResponse.statusDesc;
            //     document.getElementById("balance").innerHTML=response.d.Body.withdrawXMLResponse.statusDesc;
            // }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            alert("Status: " + textStatus); alert("Error: " + errorThrown); 
        },
        complete: function () {

        }
    });

}

function doWithdrawAjax() {    
    // var uri = "http://10.101.1.87:8080/webproject/transaction/doTransaction";
    var uri = "http://sbstaging.qiji7878.com/webproject/transaction/doTransaction";
    var url = encodeURI(uri);

    // var data = {"membercode": "test","amount": $("#amountW").val(),"currencyCode": "RMB","tout": "10000","tin": "10001"};
    var data = {"amount": $("#amountW").val(),"tout": "10000","tin": "10001"};

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',//server repsonse
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function (response) {
            // $("#balance").html=response.d.Body.withdrawXMLResponse.statusDesc;
            // document.getElementById("withdraw").innerHTML=response.d.Body.withdrawXMLResponse.statusDesc+": "+$("#amountW").val();
            $("#withdraw").html(response.d.Body.withdrawXMLResponse.statusDesc+": "+$("#amountW").val());
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            alert("Status: " + textStatus); alert("Error: " + errorThrown); 
        },
        complete: function () {

        }
    });

}
</script>