<div class="container">
<table class="table table-striped table-sm">
<caption>Account Details</caption>
<thead class="thead-light">
<tr>
 <th>#</th>
 <th>Stellar Lumen XLM Account</th>
 <th>Type</th>
 <th>Code</th>
 <th>Balance</th>
</tr> 
</thead>
<?php $i = 1; foreach($accountData as $data){?>
<tr>
 <td><?=$i?></td>
 <td>
 <code><?=$data['data']['account']?></code>
 </td>
 <td>
 <?=$data['data']['type']?>
 </td>
  <td>
 <?=$data['data']['code']?>
 </td>
  <td>
 <?=$data['data']['balance']?>
 </td>
</tr>
<?php } ?>

</table>
</div>
<div class="container">
<form method="post">
 <a href="/stellar/createAccount/" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">List Accounts</a>
 </form>
</div>