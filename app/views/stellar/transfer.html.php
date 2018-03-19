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
 <code><?=$data['data']['account']?></code>&nbsp;
 <?php if($data['data']['balance']>0){?>
 <a href="/stellar/transfer/<?=$data['data']['account']?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Send Coins</a>
 <?php }?>
 </td>
 <td>
 <?=ucwords(strtolower($data['data']['type']))?>
 </td>
  <td>
 <?=$data['data']['code']?>
 </td>
  <td class="text-right">
 <?=number_format($data['data']['balance'],7)?>
 </td>
</tr>
<?php $i++;} ?>

</table>
</div>
<div class="container">
<form method="post">
 <a href="/stellar/createAccount/" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">List Accounts</a>
 </form>
</div>