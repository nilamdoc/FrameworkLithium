<div class="container">
<?php if($secret){ ?>
<h3>New Account created</h3>
<table class="table table-striped table-sm">
 <tr>
 <th>Public Key</th>
 <td><?=$pub?></td>
 <td>Share to receive XLM Coins</td>
 </tr>
 <tr>
 <th>Secret Key</th>
 <td><?=$secret?></td>
 <th>Copy / Store / Private / Do not share</th>
 </tr>
</table>
<?php }?>
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
 <td><?=$i?></td>
 <td>
 <code><?php  print_r($account['accounts']['public']); ?></code>
 </td>
 <td>
  <a href="/stellar/fundAccount/<?=$account['accounts']['public']?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">Fund Account</a>
 </td>
</tr>
<?php $i++;} ?>
</table>
</div>
<div class="container">
<form method="post">
 <button type="submit" name="submit" class="btn btn-primary">Create new account</button>
 <?=$user['Network']?> network.<br>
 <small>Select your network in Profile - Settings to change.</small>
</form>
</div>