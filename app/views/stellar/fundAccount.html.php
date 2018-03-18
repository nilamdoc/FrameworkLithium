<div class="container">
<table class="table table-striped table-sm">
<caption>Funding of Account</caption>
<thead class="thead-light">
<tr>
 <th>#</th>
 <th>Stellar Lumen XLM Account</th>
 <th>Action</th>
</tr> 
</thead>
<tr>
 <td>1
<td>
<code><?=$pubkey?></code>&nbsp;
 <a href="/stellar/getAccount/<?=$pubkey?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Check Account</a>
</td>
<td>
 <?=$funded?>
</td>
</tr>
</table>
</div>
<div class="container">
<form method="post">
 <a href="/stellar/createAccount/" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">List Accounts</a>
 </form>
</div>