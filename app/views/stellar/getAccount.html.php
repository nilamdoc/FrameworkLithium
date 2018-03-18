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
 <td><code><?=$data['account']?></code></td>
 <td><?=$data['type']?></td>
 <td><?=$data['code']?></td>
 <td><?=$data['balance']?></td>
</tr>
</table>
</div>
<div class="container">
<form method="post">
 <a href="/stellar/createAccount/" class="btn btn-primary btn-sm active" role="button" aria-pressed="true">List Accounts</a>
 </form>
</div>