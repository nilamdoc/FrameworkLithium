<div class="container">
<table class="table table-striped table-sm">
<caption>List of Stellar Accounts</caption>
<thead class="thead-light">
<tr>
 <th>#</th>
 <th>Stellar Lumen XLM Account</th>
 <th>Action</th>
</tr> 
</thead>
<?php $i=1;foreach($accounts as $account){?>
<tr>
 <td><?=$i?>
<td>
<code><?php  print_r($account['public']); ?></code>
</td>
<td>
 <a href="/stellar/fundAccount/<?=$account['public']?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Fund Account</a>
</td>
</tr>
<?php $i++;} ?>
</table>
</div>
<div class="container">
<form method="post">
 <button type="submit" name="submit" class="btn btn-primary">Create new account</button>
</form>
</div>