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
<input type="hidden" name="sendFrom" value="<?=$pubkey?>">
 <div class="row">
  <div class="form-group col-md-6">
  <label for="sendTo">Select to send coins</label>
  <select id="sendTo"  name="sendTo" class="form-control">
   <option selected>Choose...</option>
   <?php foreach($others as $o){?>
   <option value="<?=$o['public']?>"><?=$o['public']?></option>
   <?php }?>
  </select>
  </div>
  <div class="form-group col-md-6">
    <label for="amount">Amount</label>
    <input type="text" class="form-control" id="amount" name="amount" aria-describedby="amountHelp" placeholder="10">
    <small id="amountHelp" class="form-text text-muted">How much XLM you would like to send, <strong>maximum <?=number_format($account['data']['balance'],7)?></strong>.</small>
  </div>
 </div>
 <div class="row">
 <div class="form-group col-md-6">
 <button type="submit" name="submit" class="btn btn-primary">Transfer</button>
 </div>
 </div>
</form>
</div>

<div class="container">
<form method="post">
 <a href="/stellar/createAccount/" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">List Accounts</a>
 </form>
</div>

<?php 
if(!is_null( $response)){
var_dump($response);
}
?>