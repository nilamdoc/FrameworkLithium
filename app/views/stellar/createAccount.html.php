<div class="container">
<table class="table">
<tr>
 <th>#</th>
 <th>Stellar Lumen Account</th>
</tr> 
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