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
<tr>
 <td>1</td>
 <td>
 <code><?=$pubkey?></code>&nbsp;
 </td>
 <td>
 <?=ucwords(strtolower($account['data']['type']))?>
 </td>
  <td>
 <?=$account['data']['code']?>
 </td>
  <td class="text-right">
 <?=number_format($account['data']['balance'],7)?>
 </td>
</tr>
</table>
<form method="post">
 <?php foreach($others as $o){?>
  <?=$o['public']?>
 <?php }?>
</form>
</div>

<div class="container">
<form method="post">
 <a href="/stellar/createAccount/" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">List Accounts</a>
 </form>
</div>