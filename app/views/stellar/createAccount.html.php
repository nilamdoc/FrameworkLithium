<div class="container">
<table class="table table-striped table-sm">
<caption>List of Stellar Accounts</caption>
<thead class="thead-light">
<tr>
 <th>#</th>
 <th>Stellar Lumen XLM Account</th>
</tr> 
</thead>
<?php $i=1;foreach($accounts as $account){?>
<tr>
 <td><?=$i?>
<td>
<code><?php  print_r($account['public']); ?></code>
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